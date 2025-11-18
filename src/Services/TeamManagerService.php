<?php

namespace App\Service;

use App\Entity\Team;
use App\Entity\User;
use App\Entity\Composer;
use Doctrine\ORM\EntityManagerInterface;

class TeamManagerService
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    
    #AJOUTER UN UTILISATEUR À UNE ÉQUIPE (AVEC ROLE)
    public function addUserToTeam(Team $equipe, User $utilisateur, string $role): bool
    {
        // Vérifier si déjà membre
        foreach ($equipe->getComposers() as $composer) {
            if ($composer->getUser() === $utilisateur) {
                return false; // Déjà dans l'équipe
            }
        }

        $composer = new Composer();
        $composer->setTeam($equipe);
        $composer->setUser($utilisateur);
        $composer->setRole($role);

        $this->em->persist($composer);
        $this->em->flush();

        return true;
    }

    #MODIFIER LE RÔLE D’UN MEMBRE
    public function updateUserRole(Composer $composer, string $newRole): void
    {
        $composer->setRole($newRole);
        $this->em->flush();
    }

    #RETIRER UN UTILISATEUR DE L’ÉQUIPE
    public function removeUserFromTeam(Composer $composer): void
    {
        $this->em->remove($composer);
        $this->em->flush();
    }

    #VÉRIFIER SI UN UTILISATEUR EST DANS L’ÉQUIPE
    public function userInTeam(Team $equipe, User $utilisateur): bool
    {
        foreach ($equipe->getComposers() as $composer) {
            if ($composer->getUser() === $utilisateur) {
                return true;
            }
        }
        return false;
    }

    #RÉCUPÉRER LE RÔLE D’UN UTILISATEUR DANS L’ÉQUIPE
    public function getUserRole(Team $equipe, User $utilisateur): ?string
    {
        foreach ($equipe->getComposers() as $composer) {
            if ($composer->getUser() === $utilisateur) {
                return $composer->getRole();
            }
        }
        return null;
    }

    #OBTENIR LISTE DES MEMBRES + ROLES
    public function getMembersWithRoles(Team $equipe): array
    {
        $data = [];

        foreach ($equipe->getComposers() as $composer) {
            $data[] = [
                'utilisateur' => $composer->getUser(),
                'role' => $composer->getRole(),
            ];
        }

        return $data;
    }

    
    #COMPTER LE NOMBRE DE MEMBRES
    public function getMemberCount(Team $equipe): int
    {
        return count($equipe->getComposers());
    }
}
