<?php

namespace Packages\Twitter;

use Utils\Converter;

/**
 * Holding and processing tweet collections
 *
 * @package Packages\Twitter
 */
class TweetsCollection
{
    /** @var array Number of tweets per hour (0-24) */
    protected $tweetsPerHour;

    /** @var int Number of tweets per day */
    protected $total = 0;

    /** @var string Most Active hour in day */
    protected $mostActiveHour;

    /**
     * TweetsCollection constructor.
     *
     * @param array $tweets Tweets objects
     */
    public function __construct(array $tweets)
    {
        // Convert array of tweets objects to array
        $tweets = Converter::toArray($tweets);
        $this->countTweetsToday($tweets);
    }

    /**
     * Return total number of tweets per day
     *
     * @return int
     */
    public function getTotalNumberOfTweets(): int
    {
        return $this->total;
    }

    /**
     * Return most active hour in day
     *
     * @return string
     */
    public function getMostActiveHour(): string
    {
        return $this->mostActiveHour;
    }

    /**
     * Returns a list of hours and the corresponding number of tweets
     *
     * @return array
     */
    public function getNumberOfTweetsPerDay(): array
    {
        return $this->tweetsPerHour;
    }

    /**
     * Counts the number of tweets today and adjust to specific hours
     *
     * @param array $tweets Tweets collection
     *
     * @return void
     */
    private function countTweetsToday(array $tweets)
    {
        // Array of hours
        $tweetsPerHour = $this->createArrayOfHours();

        foreach ($tweets as $tweet) {
            // Only tweets from today should be added
            if ($this->isFromToday($tweet['created_at'])) {
                // Creation hour of tweet
                $hour = date('H', strtotime($tweet['created_at']));
                $tweetsPerHour["$hour:00"]++;
                $this->total++;
            }
        }

        // Searching for hour with the most tweets
        $this->mostActiveHour = array_search(max($tweetsPerHour), $tweetsPerHour);
        $this->tweetsPerHour = $tweetsPerHour;
    }

    /**
     * Checks if tweet is from current day
     *
     * @param string $date Date of created tweet
     *
     * @return bool
     */
    private function isFromToday(string $date): bool
    {
        return date('Ymd', strtotime('today')) === date('Ymd', strtotime($date));
    }

    /**
     * Creates a list of hours
     *
     * @return array
     */
    private function createArrayOfHours(): array
    {
        $times = [];
        // 24 hours = 86400 seconds, create hours in timestamp format every 3600 seconds
        $range = range(0,86400,3600 );

        foreach ($range as $timestamp) {
            // Convert timestamp to hours and minutes
            $hour = gmdate( 'H:i', $timestamp );
            $times[$hour] = 0;
        }

        return $times;
    }
}