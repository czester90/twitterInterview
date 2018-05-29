<?php

namespace Tests\Functional;

use Abraham\TwitterOAuth\TwitterOAuth;
use Abraham\TwitterOAuth\TwitterOAuthException;
use Packages\Twitter\Exceptions\UsernameNotFoundException;
use Packages\Twitter\TweetsCollection;
use Packages\Twitter\TwitterService;

class TwitterServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests Success verify twitter api
     */
    public function testSuccessVerify()
    {
        $twitterService = $this->getMockBuilder(TwitterService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $twitterOAuthMock = $this->createMock(TwitterOAuth::class);
        $twitterOAuthMock->method('get')->willReturn([]);

        $twitterService->method('getConnection')->willReturn($twitterOAuthMock);
        $twitterService->method('verify')->willReturn(true);
    }

    /**
     * Tests failed verification from twitter api
     */
    public function testFailedVerify()
    {
        $errorObject = new \stdClass();
        $errorObject->errors = true;

        $twitterService = $this->getMockBuilder(TwitterService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $twitterOAuthMock = $this->createMock(TwitterOAuth::class);
        $twitterOAuthMock->method('get')->willReturn(true);

        $twitterService->method('getConnection')->willReturn($twitterOAuthMock);
        $twitterService->method('verify')->willThrowException(new TwitterOAuthException());
    }

    /**
     * Tests exception if username are wrong
     */
    public function testGetTweetsForUsernameWithWrongUser()
    {
        $errorObject = new \stdClass();
        $errorObject->errors = true;

        $twitterService = $this->getMockBuilder(TwitterService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $twitterOAuthMock = $this->createMock(TwitterOAuth::class);
        $twitterOAuthMock->method('get')->willReturn(true);

        $twitterService->method('getConnection')->willReturn($twitterOAuthMock);
        $twitterService->method('getTweetsForUsername')->willThrowException(new UsernameNotFoundException());
    }

    /**
     * Tests Success get tweets for username from twitter
     */
    public function testGetTweetsForUsername()
    {
        $twitterService = $this->getMockBuilder(TwitterService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $twitterOAuthMock = $this->createMock(TwitterOAuth::class);
        $twitterOAuthMock->method('get')->willReturn(true);

        $twitterService->method('getConnection')->willReturn($twitterOAuthMock);
        $twitterService->method('getTweetsForUsername')->willReturn(new TweetsCollection([]));
    }
}
