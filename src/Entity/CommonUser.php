<?php

namespace App\Entity;

use App\Entity\User;
use App\Repository\CommonUserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CommonUserRepository::class)]
class CommonUser extends User
{
    //
}
