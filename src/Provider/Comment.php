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

use DateTime;
use DateTimeZone;

class Comment extends FunctionMockerProvider
{
    use CountableFunctionMockerProviderTrait;
    
    public const STATUSES = [
        'hold',
        '0',
        'approve',
        '1',
        'spam',
        'trash',
    ];

    /**
     * @var array[]
     */
    private $comments = [];

    /**
     * @param \WP_Comment $comment
     * @return callable
     */
    public static function withSame(\WP_Comment $comment): callable
    {
        return function (\WP_Comment $theComment) use ($comment): bool {
            return (int)$theComment->ID === (int)$comment->comment_ID;
        };
    }

    /**
     * @return void
     */
    public function reset(): void
    {
        $this->comments = [];
        parent::reset();
    }

    /**
     * @param array $properties
     * @return \WP_Comment
     */
    public function __invoke(array $properties = []): \WP_Comment
    {
        $keysMap = [
            'comment_post_id' => 'comment_post_ID',
            'comment_author_ip' => 'comment_author_IP',
        ];

        /** @var array $properties */
        $properties = array_change_key_case($properties, CASE_LOWER);

        $hasCommentId = array_key_exists('comment_id', $properties);
        $id = $hasCommentId || array_key_exists('id', $properties)
            ? ($hasCommentId ? $properties['comment_id'] : $properties['id'])
            : $this->uniqueGenerator->numberBetween(1, 99999999);

        $date = $this->generator->dateTime('now', $this->generator->timezone);
        $gmt = new \DateTimeZone('GMT');

        $type = $this->generator->randomElement(['comment', 'trackback', 'pingback']);

        $defaults = [
            'comment_post_id' => $this->generator->randomNumber(),
            'comment_author' => $this->generator->name,
            'comment_author_email' => $this->generator->email,
            'comment_author_url' => $this->generator->url,
            'comment_author_ip' => $this->generator->ipv4,
            'comment_date' => $date->format('Y-m-d H:i:s'),
            'comment_date_gmt' => $date->setTimezone($gmt)->format('Y-m-d H:i:s'),
            'comment_content' => $this->generator->randomHtml(4, 8),
            'comment_karma' => 0,
            'comment_approved' => $this->generator->randomElement(self::STATUSES),
            'comment_agent' => $this->generator->userAgent,
            'comment_type' => $type,
            'comment_parent' => rand(1, 100) > 75 ? 0 : $this->generator->numberBetween(1, 999999),
            'user_id' => $this->generator->numberBetween(0, 999999),
        ];

        $comment = \Mockery::mock(\WP_Comment::class);
        $comment->comment_ID = (int)$id;

        $toArray = ['comment_ID' => (int)$id];
        foreach ($defaults as $key => $value) {
            $hasKey = array_key_exists($key, $properties);
            if (!$hasKey && strpos($key, 'comment_') === 0) {
                $noPrefixKey = substr($key, 8);
                $hasKey = array_key_exists($noPrefixKey, $properties);
                $hasKey and $properties[$key] = $properties[$noPrefixKey];
            }

            $mappedKey = $keysMap[$key] ?? $key;
            $field = $hasKey ? $properties[$key] : $value;
            $toArray[$mappedKey] = $field;
            $comment->{$mappedKey} = $field;
        }

        $comment->shouldReceive('to_array')->andReturn($toArray)->byDefault();
        
        $this->comments[$comment->comment_ID] = $toArray;
        $this->mockFunctions();

        return $comment;
    }

    /**
     * @return void
     *
     * phpcs:disable Inpsyde.CodeQuality.FunctionLength.TooLong
     * phpcs:disable Generic.Metrics.NestingLevel
     */
    private function mockFunctions(): void
    {
        // phpcs:enable Inpsyde.CodeQuality.FunctionLength.TooLong
        // phpcs:enable Generic.Metrics.NestingLevel

        if (!$this->canMockFunctions()) {
            return;
        }

        $this->functionExpectations->mock('get_comments')
            ->zeroOrMoreTimes()
            ->with(\Mockery::any())
            ->andReturnUsing($this->getCountableEntityEntries(...));

        $this->functionExpectations->mock('wp_insert_comment')
            ->zeroOrMoreTimes()
            ->with(\Mockery::any())
            ->andReturnUsing($this->insertComment(...));

        $this->stopMockingFunctions();
    }

    /**
     * @param array<string,mixed> $query
     */
    private function countEntityEntries(array $query): bool
    {
        return $query['count'] ?? false;
    }

    /**
     * @return array<int,array<string,mixed>>
     */
    private function getDataEntries(): array
    {
        return $this->comments;
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
        return $query['number'] ?? 0;
    }

    /**
     * @return array<int|string,string>
     */
    private function getFilterableProperties(): array
    {
        return [
            'post_id' => 'comment_post_ID',
            'parent' => 'comment_parent',
            'comment_type',
        ];
    }

    /**
     * @return array<string,mixed>
     */
    private function insertComment(array $commentData): int
    {
        $date = new DateTime();
        $gmt = new DateTimeZone('GMT');
        $commentData['comment_date'] = $date->format('Y-m-d H:i:s');
        $commentData['comment_date_gmt'] = $date->setTimezone($gmt)->format('Y-m-d H:i:s');
        $comment = $this->__invoke($commentData);
        return (int)$comment->comment_ID;
    }
}
