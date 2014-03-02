<?php

namespace spec\GameBot\Games;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class GameDescriptionSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Agricola', 'http://agricola.com');
    }

    function it_includes_the_name_in_the_description()
    {
        $this->getDescription()->shouldContainText('Agricola');
    }

    function it_includes_the_url_in_the_description()
    {
        $this->getDescription()->shouldContainText('http://agricola.com');
    }

    function getMatchers()
    {
        return [
            'containText' => function($haystack, $needle) { return strpos($haystack, $needle) !== false; }
        ];
    }
}
