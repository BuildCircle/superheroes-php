<?php

namespace tests;

use PHPUnit\Framework\Attributes\Test;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BattleTest extends WebTestCase
{
    #[Test]
    public function callToBattleControllerShouldReturn200(): void
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/battle?hero=Batman&villain=Joker');

        $this->assertResponseIsSuccessful();
    }
}