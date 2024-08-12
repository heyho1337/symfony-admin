<?php

namespace App\DataFixtures;

use App\Factory\EvcCategoryFactory;
use App\Factory\EvcLangFactory;
use App\Factory\EvcProductFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        EvcLangFactory::new([
            'lang_code' => 'en',
            'lang_name' => 'English',
        ])->create();

        EvcLangFactory::new([
            'lang_code' => 'de',
            'lang_name' => 'Deutsch',
        ])->create();

        UserFactory::new([
           'email' => 'heyho1337@gmail.com',
            'username' => 'heyho1337',
            'password' => '$2y$13$Y/O8BxyHkaGwdoZKxEPVFujcdEW3Ap.EnJW4z2Ctnb34A/7HL9x8C',
            'roles' => ['ROLE_ADMIN','ROLE_SUPER_ADMIN'],
            'is_verified' => 1,
        ]);
        $manager->flush();
    }
}
