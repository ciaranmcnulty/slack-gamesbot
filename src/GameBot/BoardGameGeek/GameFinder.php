<?php

namespace GameBot\BoardGameGeek;

use GameBot\Games\GameDescription;
use Guzzle\Http\Client;

class GameFinder implements \GameBot\Games\GameFinder
{
    const BGG_SEARCH_API = 'http://boardgamegeek.com/xmlapi2/search';

    /**
     * @var \Guzzle\Http\Client
     */
    private $httpClient;

    /**
     * @param Client $httpClient
     */
    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param string
     * @return GameDescription
     */
    public function findByText($searchTerm)
    {
        $this->httpClient->setBaseUrl(self::BGG_SEARCH_API);

        $request = $this->httpClient->get();
        $request->getQuery()->set('query', $searchTerm);
        $request->getQuery()->set('type', 'boardgame');

        $response = $request->send()->xml();

        if ((int)$response['total'] == 0) {
            return false;
        }

        return new GameDescription(
            (string)$response->item->name['value'],
            sprintf('http://boardgamegeek.com/game/%d', $response->item['id'])
        );

    }
}
