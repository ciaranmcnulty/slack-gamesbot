<?php
/**
 * Created by PhpStorm.
 * User: cmcnulty
 * Date: 02/03/2014
 * Time: 22:27
 */
namespace GameBot\Games;

interface GameFinder
{
    /**
     * @param string
     * @return GameDescription
     */
    public function findByText($searchTerm);
}