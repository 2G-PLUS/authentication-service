<?php

namespace App\Controller;

use App\Entity\Game;
use App\Manager\GameManager;
use App\Repository\GameRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class GameController
 *
 * @package App\Controller
 * @Rest\Route("/api")
 * @Rest\View(serializerGroups={"game"})
 */
class GameController extends AbstractFOSRestController
{

    /** @var GameManager $gameManager */
    protected GameManager $gameManager;

    /** @var GameRepository $gameRepository */
    protected GameRepository $gameRepository;

    public function __construct(GameManager $gameManager, GameRepository $gameRepository)
    {
        $this->gameManager = $gameManager;
        $this->gameRepository = $gameRepository;
    }

    /**
     * @Rest\Get("/games", name="get_games")
     * @return Response
     */
    public function getGames(): Response
    {
        $games = $this->gameRepository->findAll();

        return $this->handleView($this->view($games));
    }


    /**
     * @Rest\Post("/games", name="create_game")
     * @param Request $request
     *
     * @return Response
     */
    public function createGame(Request $request): Response
    {
        $game = new Game();

        $game->setName($request->get('name'));
        $game->setDescription($request->get('description'));
        $game->setImage($request->get('image'));
        $game->setLink($request->get('link'));

        $this->gameManager->addGame($game);

        return $this->handleView($this->view($game));
    }

    /**
     * @Rest\Get("/games/{id}", name="get_game")
     * @param $id
     * @return Response
     */

    public function getGame($id): Response
    {
        $game = $this->gameRepository->find($id);

        return $this->handleView($this->view($game));
    }


    /**
     * @Rest\Put("/games/{id}", name="update_game")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function updateGame(Request $request, $id): Response
    {
        $game = $this->gameRepository->find($id);

        $game->setName($request->get('name'));
        $game->setDescription($request->get('description'));
        $game->setImage($request->get('image'));
        $game->setLink($request->get('link'));

        $this->gameManager->save($game);

        return $this->handleView($this->view($game));
    }


    /**
     * @Rest\Delete("/games/{id}", name="delete_game")
     * @param $id
     * @return Response
     */
    public function deleteGame($id): Response
    {
        $game = $this->gameRepository->find($id);

        $this->gameManager->deleteGame($game);

        return $this->handleView($this->view($game));
    }
}