<?php

namespace Tests\Functional;

class RoutesTest extends BaseTestCase
{
    /**
     * Test that the index route returns a rendered response containing the text 'SlimFramework' but not a greeting
     */
    public function testGetHomepageWithoutName()
    {
        $response = $this->runApp('GET', '/');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('Try​ ​/hello/:name', (string) $response->getBody());
        $this->assertNotContains('Hello', (string) $response->getBody());
    }

    /**
     * Test that the index route with optional name argument
     */
    public function testGetHomepageWithName()
    {
        $response = $this->runApp('GET', '/twitterInterview');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('Hello twitterInterview', (string) $response->getBody());
    }

    /**
     * Test that the index route won't accept a post request
     */
    public function testPostHomepageNotAllowed()
    {
        $response = $this->runApp('POST', '/', ['test']);

        $this->assertEquals(405, $response->getStatusCode());
        $this->assertContains('Method not allowed', (string) $response->getBody());
    }

    /**
     * Test histogram when :username doesn't exist
     */
    public function testGetHistogramApiTwitter()
    {
        $response = $this->runApp('GET', '/histogram/hmmIdontexist');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('{
    "error": {
        "code": 34,
        "message": "Sorry, that page does not exist."
    }
}', (string) $response->getBody());
    }
}