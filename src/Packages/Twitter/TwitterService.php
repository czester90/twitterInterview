<?php

namespace Packages\Twitter;

use Abraham\TwitterOAuth\TwitterOAuth;
use Abraham\TwitterOAuth\TwitterOAuthException;
use Packages\Twitter\Exceptions\UsernameNotFoundException;

/**
 * Service of twitter api requests
 *
 * @package Packages\Twitter
 */
class TwitterService
{
    /** @var TwitterOAuth Connection to twitter api */
    private $connection;

    /**
     * TwitterService constructor.
     *
     * @param string[] $config Twitter credentials
     */
    public function __construct(array $config)
    {
        $this->connection = new TwitterOAuth(
            $config['consumer_key'],
            $config['consumer_secret'],
            $config['access_token'],
            $config['access_token_secret']
        );
    }

    /**
     * Gets Twitter api connection
     *
     * @return TwitterOAuth
     */
    public function getConnection(): TwitterOAuth
    {
        return $this->connection;
    }

    /**
     * Connection verification status
     *
     * @return bool if the verification was successful or not
     * @throws TwitterOAuthException
     */
    public function verify(): bool
    {
        $accountAuthentication = $this->getConnection()->get("account/verify_credentials");

        // Returns error object if verification are failed
        if (isset($accountAuthentication->errors)) {
            throw new TwitterOAuthException(
                $accountAuthentication->errors[0]->message,
                $accountAuthentication->errors[0]->code
            );
        }

        return true;
    }

    /**
     * Returns tweets from user timeline
     *
     * @param string $username Username of twitter user
     *
     * @return TweetsCollection
     * @throws UsernameNotFoundException
     */
    public function getTweetsForUsername(string $username): TweetsCollection
    {
        $tweets = $this->getConnection()->get('statuses/user_timeline', [
            'screen_name' => $username,
            'include_entities' => true,
            'include_rts' => true,
            'count' => 2400 // Limit of tweets per day
        ]);

        // Returns error id user doesn't exist
        if (isset($tweets->errors)) {
            throw new UsernameNotFoundException(
                $tweets->errors[0]->message,
                $tweets->errors[0]->code
            );
        }

        return new TweetsCollection($tweets);
    }
}