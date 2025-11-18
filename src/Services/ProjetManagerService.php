<?php

namespace App\Service;

use App\Entity\Projet;
use App\Entity\Team;
use App\Entity\Tache;
use App\Entity\Lier;
use Doctrine\ORM\EntityManagerInterface;

class ProjetManagerService
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    #AJOUTER / RETIRER DES ÉQUIPES AU PROJET
    #Ajouter
    public function addTeamToProjet(Projet $projet, Team $team): bool
    {
        // Vérifier doublon
        foreach ($projet->getLiers() as $lien) {
            if ($lien->getTeam() === $team) {
                return false; // déjà présent
            }
        }

        $lier = new Lier();
        $lier->setProjet($projet);
        $lier->setTeam($team);

        $this->em->persist($lier);
        $this->em->flush();

        return true;
    }
    #Retirer
    public function removeTeamFromProjet(Lier $lier): void
    {
        $this->em->remove($lier);
        $this->em->flush();
    }

    
    # AJOUTER UNE TÂCHE AU PROJET
    public function addTaskToProjet(Projet $projet, Tache $tache): void
    {
        $tache->setIdProjet($projet);

        $this->em->persist($tache);
        $this->em->flush();

        // Optionnel : mettre à jour les dates du projet
        $this->updateDates($projet);
    }

    
    #MISE À JOUR AUTOMATIQUE DES DATES DU PROJET
    public function updateDates(Projet $projet): void
    {
        $taches = $projet->getTaches();

        if ($taches->count() === 0) {
            return;
        }

        $datesDebut = [];
        $datesFinPrevues = [];
        $datesFinReelles = [];

        foreach ($taches as $tache) {
            if ($tache->getDateDebut()) {
                $datesDebut[] = $tache->getDateDebut();
            }
            if ($tache->getDateFinPrevue()) {
                $datesFinPrevues[] = $tache->getDateFinPrevue();
            }
            if ($tache->getDateFinReelle()) {
                $datesFinReelles[] = $tache->getDateFinReelle();
            }
        }

        if (!empty($datesDebut)) {
            $projet->setDateDebut(min($datesDebut));
        }

        if (!empty($datesFinPrevues)) {
            $projet->setDateFinPrevue(max($datesFinPrevues));
        }

        if (!empty($datesFinReelles)) {
            $projet->setDateFinReelle(max($datesFinReelles));
        }

        $this->em->flush();
    }

    #CALCULER L’AVANCEMENT DU PROJET
    public function calculateProgress(Projet $projet): float
    {
        $taches = $projet->getTaches();
        $total = $taches->count();

        if ($total === 0) {
            return 0;
        }

        $done = 0;

        foreach ($taches as $tache) {
            if (strtolower($tache->getStatut()) === 'terminée' ||
                strtolower($tache->getStatut()) === 'terminee') {
                $done++;
            }
        }

        return round($done / $total * 100, 2);
    }

    
    #CLÔTURER UN PROJET
    public function closeProjet(Projet $projet): void
    {
        $projet->setDateFinReelle(new \DateTime('now'));

        // marquer toutes les tâches non terminées comme "annulée" ou "terminée"
        foreach ($projet->getTaches() as $tache) {
            if ($tache->getStatut() !== 'terminée') {
                $tache->setStatut('annulée');
            }
        }

        $this->em->flush();
    }
}
