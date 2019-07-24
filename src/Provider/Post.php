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

use Brain\Monkey;

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
            : $this->uniqueGenerator->numberBetween(1, 99999999);

        $publish = ($properties['post_status'] ?? null) === 'publish';

        $gmt =  new \DateTimeZone('GMT');

        $date = $this->generator->dateTimeThisCentury($publish ? '-1 hour' : '+10 years', $zone);
        $dateMod = $this->generator->dateTimeThisCentury('now', $zone);

        $title = $this->generator->sentence($this->generator->numberBetween(1, 10));
        $content = $this->generator->randomHtml(5, 50);

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
            'post_content_filtered' => strip_tags($content),
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

        $post->shouldReceive('to_array')->andReturn($toArray);

        Monkey\Functions\expect('get_post')
            ->zeroOrMoreTimes()
            ->with(\Mockery::anyOf($post->ID, (string)$post->ID))
            ->andReturn($post);

        return $post;
    }

    /**
     * @param array $properties
     * @param string $zoneName
     * @return array
     * @throws \Exception
     */
    private function setupDateProperties(array $properties, string $zoneName): array
    {
        $dateKeys = [
            'date' => [false, 'date_gmt'],
            'date_gmt' => [true, 'date'],
            'modified' => [false, 'modified_gmt'],
            'modified_gmt' => [true, 'modified'],
        ];

        $gmt = new \DateTimeZone('GMT');
        $randomZone = new \DateTimeZone($zoneName);

        $original = $properties;
        foreach ($dateKeys as $key => [$isGmt, $altKey]) {
            $hasDateKey = array_key_exists("post_{$key}", $original);
            if (!$hasDateKey && !array_key_exists($key, $original)) {
                continue;
            }

            $dateRaw = $hasDateKey ? $original["post_{$key}"] : $original[$key];
            $date = $this->formatDate($dateRaw, $isGmt, $isGmt ? $gmt : $randomZone);

            $properties["post_{$key}"] = $date;

            if (!$hasDateKey) {
                unset($properties[$key]);
            }

            $hasAltDateKey = array_key_exists("post_{$altKey}", $original);
            if ($hasAltDateKey || array_key_exists($altKey, $original)) {
                continue;
            }

            if ($isGmt) {
                $altDate = \DateTime::createFromFormat(self::DATE_FORMAT, $date, $gmt)
                    ->setTimezone($randomZone)
                    ->format(self::DATE_FORMAT);

                $properties["post_{$altKey}"] = $altDate;
                continue;
            }

            $properties["post_{$altKey}"] = $this->formatDate($date, true, $gmt);
        }

        return $properties;
    }

    /**
     * @param $date
     * @param bool $forceGmt
     * @param \DateTimeZone $zone
     * @return string
     */
    private function formatDate($date, bool $forceGmt, \DateTimeZone $zone): string
    {
        if ($date instanceof \DateTimeInterface) {
            if (!$forceGmt) {
                return $date->format(self::DATE_FORMAT);
            }

            $dateString = $date->format(self::DATE_FORMAT);

            return \DateTime::createFromFormat(self::DATE_FORMAT, $dateString, $zone)
                ->format(self::DATE_FORMAT);
        }

        if (is_int($date)) {
            return (new \DateTime('now'))
                ->setTimestamp($date)
                ->setTimezone($zone)
                ->format(self::DATE_FORMAT);
        }

        if (!is_string($date) || strtolower($date) === 'now') {
            return (new \DateTime('now'))->setTimezone($zone)->format(self::DATE_FORMAT);
        }

        return $this->formatDate((int)(strtotime($date) ?: time()), $forceGmt, $zone);
    }
}