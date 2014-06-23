<?php

namespace GameBot\SlackBot;

use GameBot\Games\GameFinder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class WebHookHandler implements \SlackBot\SlackBot\Listener
{
    private $gameFinder;

    const BOT_USERNAME = 'gamebot';

    public function __construct(GameFinder $gameFinder)
    {
        $this->gameFinder = $gameFinder;
    }

    public function handle(Request $request)
    {
        $text = $this->extractSearchTermFromRequest($request);

        if ($description = $this->gameFinder->findByText($text)) {
            return $this->buildResponseWithMessage($description->getDescription());
        }

        return $this->buildResponseWithMessage('Sorry, I don\'t know that game');
    }

    private function buildResponseWithMessage($message)
    {
        return new JsonResponse([
            'username' => self::BOT_USERNAME,
            'text' => $message
        ]);
    }

    private function extractSearchTermFromRequest(Request $request)
    {
        return trim(preg_replace('/^boardgame/', '', $request->request->get('text')));
    }
}
