<?php

namespace App\Provider;

use App\Interface\GetCharactersProviderInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GetCharactersProvider implements GetCharactersProviderInterface
{
    private string $url;

    public function __construct(private HttpClientInterface $client
    )
    {
        $this->url = 'https://s3.eu-west-2.amazonaws.com/build-circle/characters.json';
    }
    function getCharacters(): object
    {
        $response = $this->client->request(
            'GET',
            $this->url
        );

        $content = $response->getContent();

        $characters = json_decode($content);

        return $characters;
    }
}