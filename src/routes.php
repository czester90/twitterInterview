<?php

use Packages\Error;
use Packages\Twitter;
use Slim\Http\Request;
use Slim\Http\Response;

$app->get('/', function (Request $request, Response $response, array $args) {
    return 'Try​ ​/hello/:name';
});

$app->get('/{name:[A-Za-z]+}', function (Request $request, Response $response, array $args) {
    $name = $args['name'];

    $response->getBody()->write("Hello $name");

    return $response;
});

$app->get('/histogram/{username}', function (Request $request, Response $response, array $args) use ($settings) {
    $twitter = new Twitter\TwitterHandler($settings['twitter']);

    try {
        $twitter->verify();

        $tweets = $twitter->getTweetsForUsername($args['username']);
        $json = json_encode($tweets->getTweetsPerDay(), JSON_PRETTY_PRINT);
    } catch (\Exception $e) {
        $json = Error\ErrorMessage::json($e);
    }

    return $response->write($json)
        ->withHeader('Content-Type', 'application/json;charset=utf-8');
});
