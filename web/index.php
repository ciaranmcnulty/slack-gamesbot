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
    $gameName = trim(preg_replace('/^boardgame/','', $request->request->get('text')));

    if ($game = $gameFinder->findByText($gameName)) {
        $responseText = $game->getDescription();
    }

    return $app->json(['username'=>'gamebot','text' => $responseText]);
});

$app->run();