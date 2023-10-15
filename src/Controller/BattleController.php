<?php

namespace App\Controller;

use App\Interface\GetCharactersProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BattleController extends AbstractController
{
    public static ?object $hero = null;
    public static ?object $villain = null;

    public function __construct(
        private readonly GetCharactersProviderInterface $getCharactersProvider,
        private readonly RequestStack $request
    ) {
    }

    #[Route(path: "battle", name: "battle", methods: ["GET"])]
    public function battle(): Response
    {
        $characters = $this->getCharactersProvider->getCharacters();

        $heroName = $this->request->getCurrentRequest()->query->get('hero');
        $villainName = $this->request->getCurrentRequest()->query->get('villain');

        foreach ($characters->items as $character) {
            if ($character->name == $heroName) {
                self::$hero = $character;
            }
            if ($character->name == $villainName) {
                self::$villain = $character;
            }
        }

        if (self::$hero->score > self::$villain->score) {
            return new JsonResponse(self::$hero, 200, ["Content-Type" => "application/json"]);
        }

        return new JsonResponse(self::$villain, 200, ["Content-Type" => "application/json"]);
    }
}