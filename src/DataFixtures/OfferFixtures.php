<?php

namespace App\DataFixtures;

use App\Entity\Offer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OfferFixtures extends Fixture
{
    public static function reference(string $name): string {
        return 'offer_'.$name;
    }

    public function load(ObjectManager $manager): void
    {
        $offers = [
            ['Base', 1, '100.00'],
            ['Start-up', 10, '900.00'],
            ['PME', 21, '1680.00'],
            ['Entreprise', 42, '2940.00'],
        ];

        foreach ($offers as [$name, $unitCount, $monthlyPrice]) {
            $offer = (new Offer())
                ->setName($name)
                ->setUnitCount($unitCount)
                ->setMonthlyPrice($monthlyPrice)
                ->setAnnualDiscount('10.00')
                ->setActive(true);
            $manager->persist($offer);
            $this->addReference(self::reference($name), $offer);
        }

        $manager->flush();
    }
}
