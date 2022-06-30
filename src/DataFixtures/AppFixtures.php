<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $hasher
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $admin = (new User())
            ->setPrenom("admin")
            ->setPseudo("admin")
            ->setEmail("admin@admin.com")
            ->setCivilite("M")
            ->setDateEnregistrement(new \DateTimeImmutable())
            ->setStatus(1)
            ->setRoles(["ROLE_ADMIN"]);
        $admin->setPassword($this->hasher->hashPassword($admin, '000000'));

        $user = (new User())
            ->setPrenom("user")
            ->setPseudo("user")
            ->setEmail("user@user.com")
            ->setCivilite("M")
            ->setDateEnregistrement(new \DateTimeImmutable())
            ->setStatus(1)
            ->setRoles(["ROLE_USER"]);
        $user->setPassword($this->hasher->hashPassword($user, '000000'));

        $manager->persist($user);
        $manager->persist($admin);
        $manager->flush();
    }
}
