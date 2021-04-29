<?php

namespace App\Controller;

use App\Entity\Team;
use App\Form\TeamType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/team", name="team_")
 */
class TeamController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $teams = $em->getRepository(Team::class)->findAll();
        return $this->render('team/index.html.twig', [
            'teams' => $teams,
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
        $team = new Team();
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        # Comprobar el envio del form y que sea válido
        if ( $form->isSubmitted() && $form->isValid() ) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($team);
            $em->flush();
            $this->addFlash('success', Team::MSG_CREATED_SUCCESS);
            return $this->redirectToRoute('team_index');
        }

        return $this->render('team/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    
    /**
     * @param Request $request                      # Para manejar el formulario
     * @param int $id                               # ID para encontrar el team
     * @Route("/{id}/edit", name="edit")
     */
    public function edit(int $id, Request $request): Response
    {
        
        $em = $this->getDoctrine()->getManager();
        $team = $em->getRepository(Team::class)->findOneBy(['id'=>$id]);
        if ( is_null($team) ) {
            $this->addFlash('error', Team::MSG_NOT_FOUND);
            return $this->redirectToRoute('team_index');
        }

        /**
         * @var Team $team
         */
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);
        if ( $form->isSubmitted() && $form->isValid() ) {
            $team->setName($form['name']->getData());
            $team->setHexColor($form['hexColor']->getData());
            $em->persist($team);
            $em->flush();
            $this->addFlash('error', Team::MSG_MODIFIED_SUCCESS);
        }

        return $this->render('team/edit.html.twig', [
            'form' => $form->createView(),
            'team' => $team,
        ]);
    }


    
    /**
     * @param int $id                               # ID para encontrar el team
     * @Route("/{id}/delete", name="delete")
     */
    public function delete(int $id): Response
    {
        
        $em = $this->getDoctrine()->getManager();
        $team = $em->getRepository(Team::class)->findOneBy(['id'=>$id]);
        if ( is_null($team) ) {
            $this->addFlash('error', Team::MSG_NOT_FOUND);
            return $this->redirectToRoute('team_index');
        }
        
        $em->remove($team);
        $em->flush();

        $this->addFlash('error', Team::MSG_DELETED_SUCCESS);
        return $this->redirectToRoute('team_index');
    }
}
