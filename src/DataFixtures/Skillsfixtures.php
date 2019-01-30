<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Skills;

class Skillsfixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 10; $i++){
            $skill = new skills();
            $skill->setTitle("Titre de la compétence n$i")
                  ->setContent("<p>Détail de la compétence<p>");
            $manager->persist($skill);
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
