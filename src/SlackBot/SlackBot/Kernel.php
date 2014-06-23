<?php

namespace SlackBot\SlackBot;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class Kernel implements HttpKernelInterface
{
    private $listeners;

    public function __construct(array $listeners)
    {
        $this->listeners = $listeners;
    }

    public function handle(Request $request, $type = self::MASTER_REQUEST, $catch = true)
    {
        foreach ($this->listeners as $listener) {
            if ($response = $listener->handle($request)) {
                return $response;
            }
        }

        return new Response('No listener could handle the request', 500);
    }
}
