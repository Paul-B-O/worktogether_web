<?php

namespace App\DataFixtures;

use App\Entity\Rack;
use App\Entity\Unit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Enum\UnitState;

class UnitFixtures extends Fixture implements DependentFixtureInterface
{
    private const int UNITS_PER_RACK = 42;

    public static function reference(string $rackNumber, int $position): string
    {
        return \sprintf('unit_%s_%02d', $rackNumber, $position);
    }

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
                    ->setState(UnitState::AVAILABLE);
                $rack->addUnit($unit);
                $manager->persist($unit);
                $this->addReference(self::reference($rack->getNumber(), $u), $unit);
            }
        }

        $manager->flush();
    }
}
