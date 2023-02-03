<?php

namespace App\DataFixtures;

use App\Entity\Anime;
use App\Entity\Character;
use App\Entity\Studio;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher
    )
    {
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $anime = new Anime();
            $anime->setTitle('Anime ' . $i);
            $anime->setGenres(["shonen"]);
            $anime->setImage("https://cdn.shopify.com/s/files/1/0670/0041/t/130/assets/jjkmobile1-1664937901765.png?v=1664937903");

            $manager->persist($anime);
        }
        for ($i = 1; $i <= 10; $i++) {
            $character = new Character();
            $character->setName('Character ' . $i);
            $character->setAbout("Satoru Gojô est l'exorciste le plus puissant du Japon et probablement l'un des plus puissants en exercice. Ses capacités lui valent d'ailleurs le respect et l'admiration de ses pairs. Son attitude, elle, suscite plus généralement l'agacement, puisqu'il a tendance à se montrer insouciant et à ne pas trop prendre les choses au sérieux. Il a également tendance à être en retard à ses rendez-vous.");
            $character->setImg("https://www.serieously.com/app/uploads/2021/06/jjk-gojo-film-min.png");

            $manager->persist($character);
        }
        for ($i = 1; $i <= 10; $i++) {
            $studio = new Studio();
            $studio->setName('Studio ' . $i);

            $manager->persist($studio);
        }

        for ($i = 1; $i <= 10; $i++) {
            $user = new User();
            $user->setEmail('user' . $i . '@mail.com');
            $user->setPassword($this->passwordHasher->hashPassword($user, 'password'));

            $manager->persist($user);
        }

        $admin = new User();
        $admin->setEmail('admin@mail.com');
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'admin'));
        $admin->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);


        $manager->flush();
    }
}