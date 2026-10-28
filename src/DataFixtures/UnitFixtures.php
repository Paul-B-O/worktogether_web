<?php

namespace App\DataFixtures;

use App\Entity\Rack;
use App\Entity\Unit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UnitFixtures extends Fixture implements DependentFixtureInterface
{
    private const int UNITS_PER_RACK = 42;

    public function getDependencies(): array
    {
        return [RackFixtures::class];
    }

    public function load(ObjectManager $manager): void
    {
        for ($r = 1; $r <= RackFixtures::RACK_COUNT; ++$r) {
            $rack = $this->getReference(RackFixtures::reference($r), Rack::class);

            for ($u = 1; $u <= self::UNITS_PER_RACK; ++$u) {
                $unit = (new Unit())
                    ->setNumber(\sprintf('%s-U%02d', $rack->getNumber(), $u))
                    ->setState('available');
                $rack->addUnit($unit);
                $manager->persist($unit);
            }
        }

        $manager->flush();
    }
}
