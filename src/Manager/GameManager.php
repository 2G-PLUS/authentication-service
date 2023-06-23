<?php

namespace App\Manager;

use App\Entity\Game;
use Doctrine\ORM\EntityManagerInterface;

class GameManager
{
    /** @var EntityManagerInterface $entityManager */
    private EntityManagerInterface $entityManager;


    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }



    /**
     * @param Game $game
     * @param string $name
     * @param string $description
     * @param string $image
     * @param string $link
     *
     * @return void
     */

    public function updateGame(Game $game, string $name, string $description, string $image, string $link): void
    {
        $game->setName($name);
        $game->setDescription($description);
        $game->setImage($image);
        $game->setLink($link);
        $game->setUpdatedAt(new \DateTime());

        $this->entityManager->flush();
    }

    /**
     * @param Game $game
     *
     * @return void
     */

    public function deleteGame(Game $game): void
    {
        $this->entityManager->remove($game);
        $this->entityManager->flush();
    }

    /**
     * @param Game $game
     * @return void
     */
    public function addGame(Game $game)
    {
        $game->setCreatedAt(new \DateTime());
        $game->setUpdatedAt(new \DateTime());
        $this->entityManager->persist($game);
        $this->entityManager->flush();
    }


}
