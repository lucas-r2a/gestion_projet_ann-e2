<?php

namespace App\Controller;

use App\Entity\Assigner;
use App\Entity\Tache;
use App\Form\AssignationType;
use App\Form\TacheType;
use App\Repository\AssignerRepository;
use App\Repository\TacheRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tache')]
final class TacheController extends AbstractController
{
    #[Route(name: 'app_tache_index', methods: ['GET'])]
    public function index(TacheRepository $tacheRepository): Response
    {
        return $this->render('tache/index.html.twig', [
            'taches' => $tacheRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_tache_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tache = new Tache();
        $form = $this->createForm(TacheType::class, $tache);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tache);
            $entityManager->flush();

            return $this->redirectToRoute('app_tache_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tache/new.html.twig', [
            'tache' => $tache,
            'form' => $form,
        ]);
    }

    #[Route('/{tache}', name: 'app_tache_show', methods: ['GET'])]
    public function show(Tache $tache): Response
    {
        return $this->render('tache/show.html.twig', [
            'tache' => $tache,
        ]);
    }

    #[Route('/{tache}/edit', name: 'app_tache_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Tache $tache, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TacheType::class, $tache);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_tache_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tache/edit.html.twig', [
            'tache' => $tache,
            'form' => $form,
        ]);
    }

    #[Route('/{tache}', name: 'app_tache_delete', methods: ['POST'])]
    public function delete(Request $request, Tache $tache, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tache->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($tache);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_tache_index', [], Response::HTTP_SEE_OTHER);
    }

    
     #[Route('/{tache}/assigner', name: 'tache_assigner', methods: ['GET', 'POST'])]
    public function assigner(Tache $tache, Request $request, EntityManagerInterface $em, 
    UserRepository $userRepo): Response {
        $assignation = new Assigner();
        $assignation->setTache($tache);

        $form = $this->createForm(AssignationType::class, $assignation, [
            'user' => $userRepo->findAll()
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($assignation);
            $em->flush();

            return $this->redirectToRoute('tache_show', ['id_tache' => $tache->getId()]);
        }

        return $this->render('tache/assigner.html.twig', [
            'tache' => $tache,
            'form' => $form,
        ]);
    }

    #[Route('/assignation/{id}/remove', name: 'tache_remove_assignation', methods: ['POST'])]
    public function removeAssignation(Assigner $assigner, EntityManagerInterface $em): Response
    {
        $tacheId = $assigner->getTache()->getId();

        $em->remove($assigner);
        $em->flush();

        return $this->redirectToRoute('tache_show', ['id_tache' => $tacheId]);
    }

    
    #MISE À JOUR DU STATUT
    #[Route('/{tache}/statut/{new}', name: 'tache_update_statut', methods: ['GET'])]
    public function updateStatus(Tache $tache, string $new, EntityManagerInterface $em): Response
    {
        $tache->setStatut($new);
        $em->flush();

        return $this->redirectToRoute('tache_show', ['id_tache' => $tache->getId()]);
    }
}
    
