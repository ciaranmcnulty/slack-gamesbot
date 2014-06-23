<?php

use GameBot\BoardGameGeek\GameFinder;
use GameBot\SlackBot\Listener;
use Guzzle\Http\Client;
use SlackBot\SlackBot\Kernel;
use Symfony\Component\HttpFoundation\Request;

require_once __DIR__.'/../vendor/autoload.php';

$kernel = new Kernel([
    new Listener(new GameFinder(new Client()))
]);

$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
