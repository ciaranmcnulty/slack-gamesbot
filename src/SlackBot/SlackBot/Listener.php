<?php

namespace SlackBot\SlackBot;

use Symfony\Component\HttpFoundation\Request;

interface Listener
{
    public function handle(Request $request);
} 