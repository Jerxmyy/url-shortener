<?php

namespace App\DataFixtures;

use App\DataFixtures\ShortUrlFixtures;
use App\DataFixtures\TagFixtures;
use App\Entity\ShortUrl;
use App\Entity\Tag;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ShortLinkTagFixtures extends BaseFixture implements DependentFixtureInterface {
    public function load(ObjectManager $manager): void
    {
        /**
         * @var ShortUrl[]
         */
        $links = $manager->getRepository(ShortUrl::class)->findAll();
        /**
         * @var Tag[]
         */
        $tags = $manager->getRepository(Tag::class)->findAll();

        foreach ($links as $link) {
            $tagCount = $this->faker->numberBetween(0, 3);
            $selectedTags = $this->faker->randomElements($tags, $tagCount);
            foreach ($selectedTags as $tag) {
                $link->addTag($tag);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ShortUrlFixtures::class,
            TagFixtures::class,
        ];
    }
}