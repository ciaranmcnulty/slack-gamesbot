<?php

namespace spec\GameBot\SlackBot;

use GameBot\Games\GameDescription;
use GameBot\Games\GameFinder;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

class ListenerSpec extends ObjectBehavior
{
    function let(GameFinder $finder, Request $request, ParameterBag $params)
    {
        $this->beConstructedWith($finder);

        $request->request = $params;
    }

    function it_is_a_slackbot_listener()
    {
        $this->shouldHaveType('SlackBot\SlackBot\Listener');
    }

    function it_returns_an_error_when_a_game_cannot_be_found(GameFinder $finder, Request $request)
    {
        $finder->findByText(Argument::any())->willReturn(null);

        $response = $this->handle($request);

        $response->shouldHaveType('Symfony\Component\HttpFoundation\JsonResponse');
        $response->shouldHaveJsonKey('text', 'Sorry, I don\'t know that game');
        $response->shouldHaveJsonKey('username', 'gamebot');
    }

    function it_returns_game_details_when_a_game_is_found(GameFinder $finder, Request $request, ParameterBag $params)
    {
        $params->get('text')->willReturn('boardgame Agricola');

        $description = new GameDescription('Agricola', 'http://agricola');
        $finder->findByText('Agricola')->willReturn($description);

        $response = $this->handle($request);

        $response->shouldHaveType('Symfony\Component\HttpFoundation\JsonResponse');
        $response->shouldHaveJsonKey('text', 'Agricola: http://agricola');
        $response->shouldHaveJsonKey('username', 'gamebot');
    }

    public function getMatchers()
    {
        return [
            'haveJsonKey' => function(JsonResponse $response, $key, $value) {
                $data = json_decode($response->getContent());
                return isset($data->$key) && ($data->$key == $value);
            }
        ];
    }
}
