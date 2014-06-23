<?php

namespace spec\SlackBot\SlackBot;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SlackBot\SlackBot\Listener;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class KernelSpec extends ObjectBehavior
{
    function let(Listener $listener)
    {
        $this->beConstructedWith([$listener]);
    }

    function it_is_an_http_kernel()
    {
        $this->shouldHaveType('Symfony\Component\HttpKernel\HttpKernelInterface');
    }

    function it_passes_response_to_listeners(Listener $listener, Request $request)
    {
        $this->handle($request);

        $listener->handle($request)->shouldHaveBeenCalled();
    }

    function it_shows_an_error_if_no_listeners_respond(Listener $listener, Request $request)
    {
        $listener->handle(Argument::any())->willReturn(null);

        $response = $this->handle($request);

        $response->shouldHaveType('Symfony\Component\HttpFoundation\Response');
        $response->shouldBeServerError();
    }

    function it_returns_the_response_when_a_listener_responds(Listener $listener, Request $request, Response $expectedResponse)
    {
        $listener->handle(Argument::any())->willReturn($expectedResponse);

        $actualResponse = $this->handle($request);

        $actualResponse->shouldBeLike($expectedResponse);
    }
}
