<?php

namespace tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BattleTest extends WebTestCase
{
    public function testItReturns200Ok(): void
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/battle?hero=Batman&villain=Joker');

        $this->assertResponseIsSuccessful();
    }
}