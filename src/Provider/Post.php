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

class Post extends Provider
{
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
     * @var bool
     */
    private $functionsMocked = false;

    /**
     * @return void
     */
    public function reset(): void
    {
        $this->posts = [];
        $this->functionsMocked = false;
        parent::reset();
    }

    /**
     * @param array $properties
     * @return \WP_Post
     */
    public function __invoke(array $properties = []): \WP_Post
    {
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
        $content = trim($this->generator->randomHtml(5, 50));

        $defaults = [
            'post_author' => (string)$this->generator->numberBetween(1, 99999),
            'post_date' => $date->format('Y-m-d H:i:s'),
            'post_date_gmt' => $date->setTimezone($gmt)->format('Y-m-d H:i:s'),
            'post_content' => $content,
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
            'post_content_filtered' => trim(strip_tags($content)),
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
        if ($this->functionsMocked) {
            return;
        }

        $this->functionsMocked = true;

        $this->monkeyMockFunction('get_post')
            ->zeroOrMoreTimes()
            ->with(\Mockery::any())
            ->andReturnUsing(
                function ($post) {
                    $postId = is_object($post) ? $post->ID : $post;
                    if (!$postId || !is_numeric($postId)) {
                        return false;
                    }

                    $data = $this->posts[(int)$postId] ?? null;

                    return $data ? $this->__invoke($data) : false;
                }
            );

        $this->monkeyMockFunction('get_post_field')
            ->zeroOrMoreTimes()
            ->andReturnUsing(
                function ($field = null, $post = null) {
                    $postId = is_object($post) ? $post->ID : $post;
                    if (!$postId || !is_numeric($postId) || !is_string($field)) {
                        return '';
                    }

                    return $this->posts[(int)$postId][$field] ?? '';
                }
            );
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
                if (!$hasAltDateKey) {
                    $properties["post_{$altKey}"] = $properties[$altKey];
                    unset($properties[$key]);
                }

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
     * @throws \Exception
     */
    private function formatDate($date, ?string $zone = null): string
    {
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
}