<?php # -*- coding: utf-8 -*-
/*
 * This file is part of the BrainFaker package.
 *
 * (c) Giuseppe Mazzapica
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Brain\Faker\Provider;

class Post extends FunctionMockerProvider
{
    use FunctionMockerProviderTrait;

    public const MIME_TYPES = [
        'image/jpeg',
        'image/gif',
        'image/png',
        'image/bmp',
        'image/tiff',
        'video/avi',
        'video/divx',
        'video/quicktime',
        'video/mpeg',
        'video/mp4',
        'video/ogg',
        'video/webm',
        'text/plain',
        'text/csv',
        'text/tab-separated-values',
        'text/calendar',
        'text/richtext',
        'text/css',
        'text/html',
        'audio/mpeg',
        'audio/wav',
        'audio/ogg',
        'audio/midi',
        'application/rtf',
        'application/javascript',
        'application/pdf',
        'application/java',
        'application/zip',
        'application/rar',
        'application/msword',
        'application/onenote',
        'application/wordperfect',
    ];

    public const DATE_FORMAT = 'Y-m-d H:i:s';

    /**
     * @var array[]
     */
    private $posts = [];

    /**
     * @param \WP_Post $post
     * @return callable
     */
    public static function withSame(\WP_Post $post): callable
    {
        return function (\WP_Post $thePost) use ($post): bool {
            return (int)$thePost->ID === (int)$post->ID;
        };
    }

    /**
     * @return void
     */
    public function reset(): void
    {
        $this->posts = [];
        parent::reset();
    }

    /**
     * @param array $properties
     * @return \WP_Post
     *
     * phpcs:disable Inpsyde.CodeQuality.FunctionLength.TooLong
     */
    public function __invoke(array $properties = []): \WP_Post
    {
        // phpcs:enable Inpsyde.CodeQuality.FunctionLength.TooLong

        $zone = $this->generator->timezone;

        $properties = array_change_key_case($properties, CASE_LOWER);
        $properties = $this->setupDateProperties($properties, $zone);

        $id = array_key_exists('id', $properties)
            ? $properties['id']
            : $this->uniqueGenerator->numberBetween(1, 99999);

        $publish = ($properties['post_status'] ?? null) === 'publish';

        $gmt =  new \DateTimeZone('GMT');

        $date = $this->generator->dateTimeThisCentury($publish ? '-1 hour' : '+10 years', $zone);
        $dateMod = $this->generator->dateTimeThisCentury('now', $zone);

        $title = $this->generator->sentence($this->generator->numberBetween(1, 5));

        $content = $properties['post_content']
            ?? $properties['content']
            ?? $this->generateRandomHtml();

        $contentFiltered = $properties['post_content_filtered']
            ?? $properties['content_filtered']
            ?? trim(strip_tags($content));

        $defaults = [
            'post_author' => (string)$this->generator->numberBetween(1, 99999),
            'post_date' => $date->format('Y-m-d H:i:s'),
            'post_date_gmt' => $date->setTimezone($gmt)->format('Y-m-d H:i:s'),
            'post_title' => $title,
            'post_excerpt' => $this->generator->sentences(3, true),
            'post_status' => '',
            'comment_status' => $this->generator->randomElement(['open', 'closed']),
            'ping_status' => $this->generator->randomElement(['open', 'closed']),
            'post_password' => rand(1, 100) > 80 ? $this->generator->password(4, 8) : '',
            'post_name' => preg_replace('/[^a-z0-9-_]/i', '-', $title),
            'to_ping' => '',
            'pinged' => '',
            'post_modified' => $dateMod->format('Y-m-d H:i:s'),
            'post_modified_gmt' => $dateMod->setTimezone($gmt)->format('Y-m-d H:i:s'),
            'post_parent' => rand(1, 100) > 75 ? $this->generator->numberBetween(1, 99999) : 0,
            'guid' => sprintf('http://%s?p=%d', $this->generator->domainName, $id),
            'menu_order' => $this->generator->numberBetween(0, 100),
            'post_type' => $this->generator->randomElement(['post', 'page']),
            'post_mime_type' => '',
            'comment_count' => '0',
            'filter' =>  $this->generator->randomElement(['raw', null]),
            'ancestors' => [],
            'page_template' => '',
            'post_category' => [],
            'tags_input' => [],
        ];

        $post = \Mockery::mock(\WP_Post::class);
        $post->ID = (int)$id;

        $toArray = ['ID' => (int)$id];
        foreach ($defaults as $key => $value) {
            $hasKey = array_key_exists($key, $properties);
            if (!$hasKey && strpos($key, 'post_') === 0) {
                $noPrefixKey = substr($key, 5);
                $hasKey = array_key_exists($noPrefixKey, $properties);
                $hasKey and $properties[$key] = $properties[$noPrefixKey];
            }

            $field = $hasKey ? $properties[$key] : $value;
            $post->{$key} = $field;
            $toArray[$key] = $field;
        }

        $post->post_content = $content;
        $toArray['post_content'] = $content;
        $post->post_content_filtered = $contentFiltered;
        $toArray['post_content_filtered'] = $contentFiltered;

        if ($post->post_type === 'attachment') {
            $mime = $properties['post_mime_type'] ?? $properties['mime_type'] ?? null;
            $mime === null and $mime = $this->generator->randomElement(self::MIME_TYPES);
            $post->post_mime_type = $mime;
            $toArray['post_mime_type'] = $mime;
        }

        if (!$post->post_status) {
            $dateGmt = \DateTime::createFromFormat('Y-m-d H:i:s', $post->post_date_gmt, $gmt);
            $status = $dateGmt > new \DateTimeImmutable('now', $gmt)
                ? 'future'
                : $this->generator->randomElement(['publish', 'draft']);
            $post->post_status = $status;
            $toArray['post_status'] = $status;
        }

        $post->shouldReceive('to_array')->andReturn($toArray)->byDefault();

        $this->posts[$post->ID] = $toArray;
        $this->mockFunctions();

        return $post;
    }

    private function mockFunctions(): void
    {
        if (!$this->canMockFunctions()) {
            return;
        }

        $this->functionExpectations->mock('get_post')
            ->zeroOrMoreTimes()
            ->with(\Mockery::any())
            ->andReturnUsing(
                function ($post) { // phpcs:ignore
                    $postId = is_object($post) ? $post->ID : $post;
                    if (!$postId || !is_numeric($postId)) {
                        return false;
                    }

                    $data = $this->posts[(int)$postId] ?? null;

                    return $data ? $this->__invoke($data) : false;
                }
            );

        $this->functionExpectations->mock('get_post_field')
            ->zeroOrMoreTimes()
            ->andReturnUsing(
                function ($field = null, $post = null) { // phpcs:ignore
                    $postId = is_object($post) ? $post->ID : $post;
                    if (!$postId || !is_numeric($postId) || !is_string($field)) {
                        return '';
                    }

                    return $this->posts[(int)$postId][$field] ?? '';
                }
            );

        $this->functionExpectations->mock('get_posts')
            ->zeroOrMoreTimes()
            ->with(\Mockery::any())
            ->andReturnUsing($this->getEntityEntries(...));

        $this->stopMockingFunctions();
    }

    /**
     * @return array<int,array<string,mixed>>
     */
    private function getDataEntries(): array
    {
        return $this->posts;
    }

    private function retrieveIDs(array $query): bool
    {
        return ($query['fields'] ?? null) === 'ids';
    }

    /**
     * @param array<string,mixed> $query
     */
    private function getPaginationLimit(array $query): int
    {
        return $query['posts_per_page'] ?? 0;
    }

    /**
     * @return array<int|string,string>
     */
    private function getFilterableProperties(): array
    {
        return [
            'post_type',
            'post_status',
        ];
    }

    /**
     * @param array $properties
     * @param string $randomZone
     * @return array
     * @throws \Exception
     */
    private function setupDateProperties(array $properties, string $randomZone): array
    {
        $dateKeys = [
            'date' => [false, 'date_gmt'],
            'date_gmt' => [true, 'date'],
            'modified' => [false, 'modified_gmt'],
            'modified_gmt' => [true, 'modified'],
        ];

        $original = $properties;
        foreach ($dateKeys as $key => [$isGmt, $altKey]) {
            $hasDateKey = array_key_exists("post_{$key}", $original);
            if (!$hasDateKey && !array_key_exists($key, $original)) {
                continue;
            }

            $dateRaw = $hasDateKey ? $original["post_{$key}"] : $original[$key];
            $date = $this->formatDate($dateRaw, $isGmt ? 'GMT' : $randomZone);

            $properties["post_{$key}"] = $date;

            if (!$hasDateKey) {
                unset($properties[$key]);
            }

            $hasAltDateKey = array_key_exists("post_{$altKey}", $original);
            if ($hasAltDateKey || array_key_exists($altKey, $original)) {
                continue;
            }

            $targetZone = $isGmt ? new \DateTimeZone($randomZone) : new \DateTimeZone('GMT');

            $altDate = \DateTime::createFromFormat(self::DATE_FORMAT, $date)
                ->setTimezone($targetZone)
                ->format(self::DATE_FORMAT);

            $properties["post_{$altKey}"] = $altDate;

            if (!$hasAltDateKey) {
                unset($properties[$key]);
            }
        }

        return $properties;
    }

    /**
     * @param $date
     * @param string|null $zone
     * @return string
     *
     * phpcs:disable Inpsyde.CodeQuality.ArgumentTypeDeclaration
     */
    private function formatDate($date, ?string $zone = null): string
    {
        // phpcs:enable Inpsyde.CodeQuality.ArgumentTypeDeclaration

        if ($date instanceof \DateTimeInterface) {
            return $date->format(self::DATE_FORMAT);
        }

        if (is_int($date)) {
            return (new \DateTime('now', new \DateTimeZone($zone ?? 'UTC')))
                ->setTimestamp($date)
                ->format(self::DATE_FORMAT);
        }

        if (!is_string($date) || strtolower($date) === 'now') {
            return (new \DateTime('now', new \DateTimeZone($zone ?? 'UTC')))
                ->format(self::DATE_FORMAT);
        }

        if (preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$/', $date)) {
            return $date;
        }

        return $this->formatDate((int)(strtotime($date) ?: (int)time()), $zone);
    }

    /**
     * Faker randomHtml is slow for long text and it generates full-page HTML, not fragment like
     * post content is.
     *
     * @return string
     */
    private function generateRandomHtml(): string
    {
        $output = '';
        $max = $this->generator->numberBetween(0, 50);
        if (!$max) {
            return '';
        }

        $listItems = $this->generator->numberBetween(0, 10);
        $list = '';
        if ($listItems) {
            $listTag = $this->generator->randomElement(['ul', 'ol']);
            $list .= "<{$listTag}>";
            for ($listI = 0; $listI < $listItems; $listI++) {
                $list .= "\n<li>";
                $list .= $this->generator->sentence($this->generator->numberBetween(1, 3));
                $list .= "<li>";
            }
            $list .= "\n</{$listTag}>";
        }

        for ($i = 0; $i < $max; $i++) {
            $tag = $this->generator->randomElement(['p', 'div']);
            $output .= "\n<{$tag}>\n";
            $image = $this->generator->randomElement([true, false]);
            if ($image) {
                $output .= sprintf(
                    "<img alt=\"%s\" src=\"%s\" />\n",
                    $this->generator->sentence(1, 3),
                    $this->generator->imageUrl()
                );
            }
            $output .= $this->generator->sentences($this->generator->numberBetween(1, 5), true);
            $output .= "\n";
            $output .= $tag === 'div' ? "{$list}\n</{$tag}>" : "</{$tag}>\n{$list}";
        }

        return trim($output);
    }
}
