<?php

use Packages\Twitter;
use Slim\Http\Request;
use Slim\Http\Response;
use Utils\Converter;

$app->get('/', function (Request $request, Response $response, array $args) {
    $response->getBody()->write('Try​ ​/hello/:name');

    return $response;
});

$app->get('/{name:[A-Za-z]+}', function (Request $request, Response $response, array $args) {
    $name = $args['name'];

    $response->getBody()->write("Hello $name");

    return $response;
});

$app->get('/histogram/{username}', function (Request $request, Response $response, array $args) use ($settings) {
    // Connection to Twitter Api
    $twitter = new Twitter\TwitterService($settings['twitter']);

    try {
        // Verification of the connection
        $twitter->verify();
        // Tweets Collection
        $tweets = $twitter->getTweetsForUsername($args['username']);
        $json = Converter::toJson([
            'username' => $args['username'],
            'tweets' => $tweets->getNumberOfTweetsPerDay(),
            'total' => $tweets->getTotalNumberOfTweets(),
            'most_active_hour' => $tweets->getMostActiveHour()
        ]);
    } catch (\Exception $e) {
        // Generate error message in the event of an error
        $json = Converter::toJson([
            'error' => [
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ]
        ]);
    }

    // Display data in json format
    return $response->write($json)->withHeader('Content-Type', 'application/json;charset=utf-8');
});
