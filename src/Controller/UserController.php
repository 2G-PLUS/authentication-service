<?php

namespace App\Controller;

use App\Entity\User;
use App\Manager\UserManager;
use App\Repository\UserRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UserController
 *
 * @package App\Controller
 * @Rest\Route("/api")
 * @Rest\View(serializerGroups={"user"})
 */
class UserController extends AbstractFOSRestController
{
    /** @var UserManager $userManager */
    protected UserManager $userManager;
    /** @var UserRepository $userRepository */
    protected UserRepository $userRepository;

    /**
     * @param UserManager    $userManager
     * @param UserRepository $userRepository
     */
    public function __construct(UserManager $userManager, UserRepository $userRepository)
    {
        $this->userManager = $userManager;
        $this->userRepository = $userRepository;
    }

    /**
     * @Rest\Get("/users", name="get_users")
     *
     * @return Response
     */
    public function getUsers(): Response
    {
        $users = $this->userRepository->findAll();

        return $this->handleView($this->view($users));
    }

    /**
     * @Rest\Post("/users", name="create_user")
     * @param Request $request
     *
     * @return Response
     */
    public function createUser(Request $request): Response
    {
        $user = new User();

        $user->setUsername($request->get('username'));
        $user->setPassword($request->get('password'));

        $this
            ->userManager
            ->createUser($user->getUsername(), $user->getPassword());

        return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
    }

    /**
     * @Rest\Put("/users/{id}", name="update_user")
     * @param Request $request
     *
     * @return Response
     */
    public function updateUser(Request $request): Response
    {
        $user = $this->userRepository->find($request->get('id'));

        $user->setUsername($request->get('username'));
        $user->setPassword($request->get('password'));

        $this
            ->userManager
            ->updateUser($user, $user->getPassword());

        return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_OK));
    }

    /**
     * @Rest\Delete("/users/{id}", name="delete_user")
     * @param Request $request
     *
     * @return Response
     */
    public function deleteUser(Request $request): Response
    {
        $user = $this->userRepository->find($request->get('id'));

        $this
            ->userManager
            ->deleteUser($user);

        return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_OK));
    }


}
