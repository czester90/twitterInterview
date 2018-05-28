<?php

namespace Packages\Twitter;

use Abraham\TwitterOAuth\TwitterOAuth;
use Abraham\TwitterOAuth\TwitterOAuthException;

class TwitterHandler
{
    private $connection;

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
     * @return bool
     * @throws TwitterOAuthException
     */
    public function verify(): bool
    {
        $accountAuthentication = $this->connection->get("account/verify_credentials");
        if (isset($accountAuthentication->errors)) {
            throw new TwitterOAuthException(
                $accountAuthentication->errors[0]->message,
                $accountAuthentication->errors[0]->code
            );
        }
        return true;
    }

    /**
     * Tweets per day 2400 limit
     *
     * @param string $username
     *
     * @return TweetsCollection
     * @throws UsernameNotFoundException
     */
    public function getTweetsForUsername(string $username)
    {
        $tweets = $this->connection->get('statuses/user_timeline', [
            'screen_name' => $username,
            'include_entities' => true,
            'include_rts' => true,
            'count' => 2400
        ]);

        if (isset($tweets->errors)) {
            throw new UsernameNotFoundException(
                $tweets->errors[0]->message,
                $tweets->errors[0]->code
            );
        }

        return new TweetsCollection($tweets);
    }
}