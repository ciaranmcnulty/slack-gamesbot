<?php

use GameBot\BoardGameGeek\GameFinder;
use Guzzle\Http\Client;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

require_once __DIR__.'/../vendor/autoload.php';

$gameFinder = new GameFinder(new Client());

$request = Request::createFromGlobals();

$responseText = 'Sorry, I don\'t know that game';
$gameName = trim(preg_replace('/^boardgame/','', $request->request->get('text')));

if ($game = $gameFinder->findByText($gameName)) {
    $responseText = $game->getDescription();
}

$response = new JsonResponse(['username'=>'gamebot','text' => $responseText]);

$response->send();
