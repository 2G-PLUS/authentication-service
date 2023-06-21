<?php

namespace App\Manager;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserManager
{
    /** @var EntityManagerInterface $entityManager */
    private EntityManagerInterface $entityManager;

    /** @var UserPasswordHasherInterface $passwordEncoder */
    private UserPasswordHasherInterface $passwordEncoder;

    /**
     * @param EntityManagerInterface      $entityManager
     * @param UserPasswordHasherInterface $passwordEncoder
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordEncoder
    ) {
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function createUser(string $username, string $password): User
    {
        $user = new User();
        $user->setUsername($username);
        $user->setPassword($this->passwordEncoder->hashPassword($user, $password));
        $user->setCreatedAt(new \DateTime());
        $user->setUpdatedAt(new \DateTime());

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    public function updateUser(User $user, string $password): User
    {
        $user->setPassword($this->passwordEncoder->hashPassword($user, $password));
        $user->setUpdatedAt(new \DateTime());

        $this->entityManager->flush();

        return $user;
    }

    public function deleteUser(User $user)
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }

    public function findUserByUsername($username)
    {
        return $this->entityManager->getRepository(User::class)->findOneBy(['username' => $username]);
    }
}
