<?php

namespace App\DataFixtures;

use App\Factory\EvcCategoryFactory;
use App\Factory\EvcLangFactory;
use App\Factory\EvcProductFactory;
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
        EvcCategoryFactory::createMany(100);
        EvcProductFactory::createMany(100);

        $manager->flush();
    }
}
