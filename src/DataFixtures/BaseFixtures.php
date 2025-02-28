<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker;

abstract class BaseFixture extends Fixture {
    private const SEED = "BIzZQ9ryZCuRbLMRk2fTAQ==";

    protected Faker\Generator $faker;

    public function __construct()
    {
        $this->faker = Faker\Factory::create();
        $this->faker->seed(self::SEED);
    }
}