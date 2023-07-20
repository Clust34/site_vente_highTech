<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $hacher
    ) {
    }
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $user = new User;

        $user
            ->setEmail('nico@test.com')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($this->hacher->hashPassword(new User, 'az'))
            ->setNom('Chapuis')
            ->setPrenom('Nicolas');

        $manager->persist($user);
        $manager->flush();
    }
}
