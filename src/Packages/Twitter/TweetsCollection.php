<?php

namespace Packages\Twitter;

class TweetsCollection
{
    /** @var array Tweets Collection */
    protected $tweets;

    /**
     * TweetsCollection constructor.
     *
     * @param array $tweets Tweets objects
     */
    public function __construct(array $tweets)
    {
        $this->tweets = $this->convertToArray($tweets);
    }

    /**
     * @return array
     */
    public function getTweetsPerDay(): array
    {
        $tweetsPerHour = $this->createArrayOfHours();

        foreach ($this->tweets as $tweet) {
            if ($this->isFromToday($tweet['created_at'])) {
                $hour = date('H', strtotime($tweet['created_at']));
                ++$tweetsPerHour["$hour:00"];
            }
        }

        return $tweetsPerHour;
    }

    /**
     * @param string $date
     *
     * @return bool
     */
    private function isFromToday(string $date): bool
    {
        return date('Ymd', strtotime('today')) === date('Ymd', strtotime($date));
    }

    /**
     * @param array $tweets
     *
     * @return array
     */
    private function convertToArray(array $tweets): array
    {
        return json_decode(json_encode($tweets), true);
    }

    /**
     * @return array
     */
    private function createArrayOfHours(): array
    {
        $times = [];
        foreach (range(0,86400,3600 ) as $timestamp) {
            $hour_mins = gmdate( 'H:i', $timestamp );
            $times[$hour_mins] = 0;
        }
        return $times;
    }
}