<?php

namespace App\DataFixtures;

use App\Entity\Telephones;
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

        for ($i = 0; $i <= 10; $i++) {
            $telephone = new Telephones;
            $telephone
                ->setNom("Iphone $i")
                ->setPrix(256.45)
                ->setQuantity(55)
                ->setMetaTitle("Téléphone Iphone $i")
                ->setMetaDescription("Un téléphone qu'il est bien")
                ->setDescription("Un téléphone qu'il est bien")
                ->setEnable(1)
                ->setMarque("Apple");
            $manager->persist($telephone);
        }
        $manager->flush();
    }
}
