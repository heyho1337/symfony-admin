<?php 

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Factory\EvcProductFactory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        
		EvcProductFactory::createMany(1000);
		
		// $product = new Product();
        // $manager->persist($product);
        $manager->flush();
    }
}