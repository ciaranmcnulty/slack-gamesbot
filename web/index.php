<?php

use GameBot\BoardGameGeek\GameFinder;
use Guzzle\Http\Client;
use Symfony\Component\HttpFoundation\Request;

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application;
$app['debug'] = true;

$gameFinder = new GameFinder(new Client());

$app->post('/game-search', function(Request $request) use ($app, $gameFinder) {
    $responseText = 'Sorry, I don\'t know that game';

    if ($game = $gameFinder->findByText($request->request->get('text'))) {
        $responseText = $game->getDescription();
    }

    return $app->json(['text' => $responseText]);
});

$app->run();