<?php

namespace App\Controller;

use App\Entity\Player;
use App\Form\GameType;
use App\Services\TextManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/game", name="game_")
 */
class GameController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $form = $this->createForm(GameType::class);
        return $this->render('game/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    
    /**
     * @Route("/ajax-random-players/", name="get_players")
     */
    public function ajaxGetPlayers(
        TextManager $textManager
    ): Response
    {
        $em = $this->getDoctrine()->getManager();
        $players = $em->getRepository(Player::class)->find10Random();
        foreach ( $players as $i => $pl ) {
            $name = $textManager->parseFullName( $pl->getName() );
            $pl->setName($name);
        }
        return new JsonResponse($players);
    }
}
