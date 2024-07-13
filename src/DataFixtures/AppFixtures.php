<?php 

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Factory\EvcProductFactory;
use App\Factory\EvcCategoryFactory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        
		EvcProductFactory::createMany(100);
		//EvcCategoryFactory::createMany(30);
		
		// $product = new Product();
        // $manager->persist($product);
        $manager->flush();
    }
}