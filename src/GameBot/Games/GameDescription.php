<?php

namespace GameBot\Games;

class GameDescription
{
    private $name;
    private $url;

    public function __construct($name, $url)
    {
        $this->name = $name;
        $this->url = $url;
    }

    public function getDescription()
    {
        return sprintf('%s (%s)', $this->name, $this->url);
    }

}
