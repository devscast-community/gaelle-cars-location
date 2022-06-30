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
        $user = (new User())
            ->setPrenom("admin")
            ->setPseudo("admin")
            ->setEmail("admin@admin.com")
            ->setCivilite("M")
            ->setDateEnregistrement(new \DateTimeImmutable())
            ->setStatus(1)
            ->setRoles(["ROLE_ADMIN"]);

        $user->setPassword(
            $this->hasher->hashPassword($user, '000000')
        );

        $manager->persist($user);
        $manager->flush();
    }
}
