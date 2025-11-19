<?php

namespace App\Controller;

use App\Entity\Composer;
use App\Entity\Lier;
use App\Entity\Team;
use App\Form\ComposerType;
use App\Form\LierType;
use App\Form\TeamType;
use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/team')]
final class TeamController extends AbstractController
{
    #[Route(name: 'app_team_index', methods: ['GET'])]
    public function index(TeamRepository $teamRepository): Response
    {
        return $this->render('team/index.html.twig', [
            'teams' => $teamRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_team_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $team = new Team();
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($team);
            $entityManager->flush();

            return $this->redirectToRoute('app_team_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('team/new.html.twig', [
            'team' => $team,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_team_show', methods: ['GET'])]
    public function show(Team $team): Response
    {
        return $this->render('team/show.html.twig', [
            'team' => $team,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_team_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Team $team, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_team_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('team/edit.html.twig', [
            'team' => $team,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_team_delete', methods: ['POST'])]
    public function delete(Request $request, Team $team, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$team->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($team);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_team_index', [], Response::HTTP_SEE_OTHER);
    }


    #Ajouter des membres
    #[Route('/{idEquipe}/add-member', name: 'team_add_member', methods: ['GET', 'POST'])]
    public function addMember(Request $request, Team $team, EntityManagerInterface $em): Response
    {
        $composer = new Composer();
        $composer->setTeam($team);

        $form = $this->createForm(ComposerType::class, $composer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($composer);
            $em->flush();

            $this->addFlash('success', 'Membre ajouté à l’équipe.');
            return $this->redirectToRoute('team_show', ['idTeam' => $team->getId()]);
        }

        return $this->render('team/add_member.html.twig', [
            'team' => $team,
            'form' => $form->createView(),
        ]);
    }

    #supprimer des membres 
    #[Route('/remove-member/{id}', name: 'team_remove_member', methods: ['POST'])]
    public function removeMember(Request $request, Composer $composer, EntityManagerInterface $em): Response
    {
        $teamId = $composer->getTeam()->getId();

        if ($this->isCsrfTokenValid('remove_member'.$composer->getId(), $request->request->get('_token'))) {
            $em->remove($composer);
            $em->flush();

            $this->addFlash('success', 'Membre retiré de l’équipe.');
        }

        return $this->redirectToRoute('team_show', ['idEquipe' => $teamId]);
    }

    
    // ajouter equipe au projets 
    #[Route('/{idEquipe}/add-project', name: 'team_add_project', methods: ['GET', 'POST'])]
    public function addProject(Request $request, Team $team, EntityManagerInterface $em): Response
    {
        $lier = new Lier();
        $lier->setTeam($team);

        $form = $this->createForm(LierType::class, $lier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($lier);
            $em->flush();

            $this->addFlash('success', 'Projet ajouté à l’équipe.');
            return $this->redirectToRoute('team_show', ['idTeam' => $team->getId()]);
        }

        return $this->render('team/add_project.html.twig', [
            'team' => $team,
            'form' => $form->createView(),
        ]);
    }

    #supprimer equipe au projet
    #[Route('/remove-project/{id}', name: 'team_remove_project', methods: ['POST'])]
    public function removeProject(Request $request, Lier $lier, EntityManagerInterface $em): Response
    {
        $teamId = $lier->getTeam()->getId();

        if ($this->isCsrfTokenValid('remove_project'.$lier->getId(), $request->request->get('_token'))) {
            $em->remove($lier);
            $em->flush();

            $this->addFlash('success', 'Projet retiré de l’équipe.');
        }

        return $this->redirectToRoute('team_show', ['idEquipe' => $teamId]);
    }
}
