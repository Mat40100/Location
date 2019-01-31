<?php
/**
 * Created by PhpStorm.
 * User: dolhen
 * Date: 31/01/19
 * Time: 10:25
 */

namespace App\Service;


use App\Entity\User;
use Symfony\Component\Security\Core\Security;

class AllowService
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function allowAccess(User $logged, User $owner)
    {
        if ($this->security->isGranted("ROLE_ADMIN")) {

            return true;
        }

        if ($logged === $owner) {

            return true;
        }

        return false;
    }
}