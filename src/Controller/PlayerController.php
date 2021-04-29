<?php

namespace App\Controller;

use App\Entity\Player;
use App\Form\PlayerType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/player", name="player_")
 */
class PlayerController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $teams = $em->getRepository(Player::class)->findAll();
        return $this->render('player/index.html.twig', [
            'players' => $teams,
        ]);
    }



    /**
     * @param Request $request                      # Para manejar el formulario
     * @Route("/new", name="new")
     */
    public function new(
        Request $request
    ): Response
    {
        $player = new Player();
        $form = $this->createForm(PlayerType::class, $player);
        $form->handleRequest($request);

        # Comprobar el envio del form y que sea válido
        if ( $form->isSubmitted() && $form->isValid() ) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($player);
            $em->flush();
            $this->addFlash('success', Player::MSG_CREATED_SUCCESS);
            return $this->redirectToRoute('player_index');
        }

        return $this->render('player/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    
    /**
     * @param int $id                               # ID para encontrar el team
     * @param Request $request                      # Para manejar el formulario
     * @Route("/{id}/edit", name="edit")
     */
    public function edit(int $id, Request $request): Response
    {
        
        $em = $this->getDoctrine()->getManager();
        $player = $em->getRepository(Player::class)->findOneBy(['id'=>$id]);
        if ( is_null($player) ) {
            $this->addFlash('error', Player::MSG_NOT_FOUND);
            return $this->redirectToRoute('player_index');
        }

        /**
         * @var Player $player
         */
        $form = $this->createForm(PlayerType::class, $player);
        $form->handleRequest($request);
        if ( $form->isSubmitted() && $form->isValid() ) {
            $player->setName($form['name']->getData());
            $player->setPosition($form['position']->getData());
            $player->setTeam($form['team']->getData());
            $em->persist($player);
            $em->flush();
            $this->addFlash('error', Player::MSG_MODIFIED_SUCCESS);
        }

        return $this->render('player/edit.html.twig', [
            'form' => $form->createView(),
            'player' => $player,
        ]);
    }


    
    /**
     * @param int $id                               # ID para encontrar el team
     * @Route("/{id}/delete", name="delete")
     */
    public function delete(int $id): Response
    {
        
        $em = $this->getDoctrine()->getManager();
        $player = $em->getRepository(Player::class)->findOneBy(['id'=>$id]);
        if ( is_null($player) ) {
            $this->addFlash('error', Player::MSG_NOT_FOUND);
            return $this->redirectToRoute('player_index');
        }
        
        $em->remove($player);
        $em->flush();

        $this->addFlash('error', Player::MSG_DELETED_SUCCESS);
        return $this->redirectToRoute('player_index');
    }
}
