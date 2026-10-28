<?php

namespace App\DataFixtures;

use App\Entity\Rack;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RackFixtures extends Fixture
{
    public const int RACK_COUNT = 30;

    public static function reference(int $number): string
    {
        return 'rack_'.$number;
    }

    public function load(ObjectManager $manager): void
    {
        for ($r = 1; $r <= self::RACK_COUNT; ++$r) {
            $rack = (new Rack())->setNumber(\sprintf('B%02d', $r));
            $manager->persist($rack);
            $this->addReference(self::reference($r), $rack);
        }

        $manager->flush();
    }
}
