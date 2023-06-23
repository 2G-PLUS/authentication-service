<?php

namespace App\Security;

use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Security\Handler\SecurityHandlerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class SonataAdminSecurityHandler implements SecurityHandlerInterface
{
    private AuthorizationCheckerInterface $authorizationChecker;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    public function isGranted(AdminInterface $admin, $attributes, ?object $object = null): bool
    {
        if (!$object) {
            return $this->authorizationChecker->isGranted($attributes);
        }

        if (!$admin->isGranted($attributes, $object)) {
            throw new AccessDeniedException();
        }

        return true;
    }

    public function getBaseRole(AdminInterface $admin): string
    {
        return $admin->getSecurityHandler()->getBaseRole($admin);
    }

    public function buildSecurityInformation(AdminInterface $admin): array
    {
        return $admin->getSecurityHandler()->buildSecurityInformation($admin);
    }

    public function createObjectSecurity(AdminInterface $admin, object $object): void
    {
        $admin->getSecurityHandler()->createObjectSecurity($admin, $object);
    }

    public function deleteObjectSecurity(AdminInterface $admin, object $object): void
    {
        $admin->getSecurityHandler()->deleteObjectSecurity($admin, $object);
    }
}
