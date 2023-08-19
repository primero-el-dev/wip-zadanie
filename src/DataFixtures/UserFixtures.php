<?php

namespace App\DataFixtures;

use App\Entity\CommonUser;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher) {}

    public function load(ObjectManager $manager): void
    {
        $admin = (new CommonUser())
            ->setName('Jan')
            ->setSurname('Kowalski')
            ->setRoles(['ROLE_ADMIN'])
            ->setLogin('admin')
            ->setEmail('admin@mail.com');
        $plainPassword = 'password';
        $hashedPassword = $this->passwordHasher->hashPassword($admin, $plainPassword);
        $admin->setPassword($hashedPassword);
        
        $manager->persist($admin);
        $manager->flush();
    }
}
