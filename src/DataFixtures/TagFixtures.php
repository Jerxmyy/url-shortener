<?php

namespace App\DataFixtures;

use App\Entity\Tag;
use Doctrine\Persistence\ObjectManager;

class TagFixtures extends BaseFixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i += 1) {
            $tag = new Tag();
            $tag
                ->setName($this->faker->domainWord)
                ->setColor($this->faker->hexColor());
            $manager->persist($tag);
        }

        $manager->flush();
    }
}