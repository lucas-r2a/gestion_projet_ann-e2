<?php

namespace App\Controller;

use App\Entity\Lier;
use App\Entity\Projet;
use App\Form\ProjetType;
use App\Form\TeamType;
use App\Repository\ProjetRepository;
use App\Repository\TacheRepository;
use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/projet')]
final class ProjetController extends AbstractController
{
    #[Route(name: 'app_projet_index', methods: ['GET'])]
    public function index(ProjetRepository $projetRepository): Response
    {
        return $this->render('projet/index.html.twig', [
            'projets' => $projetRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_projet_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $projet = new Projet();
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($projet);
            $entityManager->flush();

            return $this->redirectToRoute('app_projet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('projet/new.html.twig', [
            'projet' => $projet,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_projet_show', methods: ['GET'])]
    public function show(Projet $projet): Response
    {
        return $this->render('projet/show.html.twig', [
            'projet' => $projet,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_projet_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Projet $projet, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_projet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('projet/edit.html.twig', [
            'projet' => $projet,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_projet_delete', methods: ['POST'])]
    public function delete(Request $request, Projet $projet, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$projet->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($projet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_projet_index', [], Response::HTTP_SEE_OTHER);
    }

    #Voir les equipe associe au projet
    #[Route('/{projet}/teams', name: 'projet_teams', methods: ['GET', 'POST'])]
    public function teams(Projet $projet,Request $request,TeamRepository $teamRepo,EntityManagerInterface $em): Response {

        $form = $this->createForm(TeamType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $team = $form->get('team')->getData();

            // si equipe deja lie?
            foreach ($projet->getLiers() as $lien) {
                if ($lien->getTeam() === $team) {
                    $this->addFlash('warning', 'Cette équipe est déjà liée à ce projet.');
                    return $this->redirectToRoute('projet_teams', ['projet' => $projet->getId()]);
                }
            }

            $lier = new Lier();
            $lier->setProjet($projet);
            $lier->setTeam($team);

            $em->persist($lier);
            $em->flush();

            $this->addFlash('success', 'Équipe ajoutée au projet.');
            return $this->redirectToRoute('projet_teams', ['projet' => $projet->getId()]);
        }
        //dd( $projet->getLiers());
        return $this->render('projet/teams.html.twig', [
            'projet' => $projet,
            'form' => $form->createView()
        ]);
    }

    #[Route('/{projet}/team/{id}/remove', name: 'projet_team_remove')]
    public function removeTeam(Projet $projet, Lier $lier, EntityManagerInterface $em): Response
    {
        $em->remove($lier);
        $em->flush();

        $this->addFlash('success', 'Équipe retirée du projet.');

        return $this->redirectToRoute('projet_teams', ['projet' => $projet->getId()]);
    }

    #recuperation des taches associées
    #[Route('/{projet}/taches', name: 'app_projet_taches', methods: ['GET'])]
    public function taches(Projet $projet, TacheRepository $tacheRepository): Response
    {
        $taches = $tacheRepository->findBy(['projet' => $projet]);

        return $this->render('projet/taches.html.twig', [
            'projet' => $projet,
            'taches' => $taches,
        ]);
    }

    #Lier des équipes au projet
    #[Route('/{projet}/add-equipe', name: 'app_projet_add_team', methods: ['POST'])]
    public function addEquipe(Projet $projet, Request $request, EntityManagerInterface $em, TeamRepository $teamRepo): Response
    {
        $teamId = $request->request->get('team_id');
        if (!$teamId) {
            $this->addFlash('error', 'Aucune équipe sélectionnée.');
            return $this->redirectToRoute('projet_teams', ['projet' => $projet->getId()]);
        }

        $team = $teamRepo->find($teamId);
        if (!$team) {
            $this->addFlash('error', 'Équipe non trouvée.');
            return $this->redirectToRoute('projet_teams', ['projet' => $projet->getId()]);
        }

        // Vérifier si déjà lié
        foreach ($projet->getLiers() as $lien) {
            if ($lien->getTeam() === $team) {
                $this->addFlash('warning', 'Cette équipe est déjà liée à ce projet.');
                return $this->redirectToRoute('projet_teams', ['projet' => $projet->getId()]);
            }
        }

        // Création de la relation LIER
        $lier = new Lier();
        $lier->setProjet($projet);
        $lier->setTeam($team);

        $em->persist($lier);
        $em->flush();

        $this->addFlash('success', 'Équipe ajoutée au projet.');

        return $this->redirectToRoute('projet_teams', ['projet' => $projet->getId()]);

    }
}
