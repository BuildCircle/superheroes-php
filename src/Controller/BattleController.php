<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Interface\GetCharactersProviderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BattleController extends AbstractController
{
    public static object $hero;
    public static object $villain;
    public function __construct(private GetCharactersProviderInterface $getCharactersProvider, private RequestStack $request)
    {
    }
    #[Route(path: "battle", name: "battle", methods: ["GET"])]
    function battle(): Response
    {
        $characters = $this->getCharactersProvider->getCharacters();

        $heroName = $this->request->getCurrentRequest()->query->get('heroName');
        $villainName = $this->request->getCurrentRequest()->query->get('villainName');

        foreach ($characters->items as $character) {
            if($character->name == $heroName)
            {
                self::$hero = $character;
            }
            if($character->name == $villainName)
            {
                self::$villain = $character;
            }
        }

        if(self::$hero->score > self::$villain->score)
        {
            return new JsonResponse(self::$hero, 200, ["Content-Type" => "application/json"]);
        }

        return new JsonResponse(self::$villain, 200, ["Content-Type" => "application/json"]);
    }
}    