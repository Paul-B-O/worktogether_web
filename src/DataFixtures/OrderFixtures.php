<?php

namespace App\DataFixtures;

use App\Entity\Assignment;
use App\Entity\Customer;
use App\Entity\Offer;
use App\Entity\Order;
use App\Entity\Unit;
use App\Enum\OrderStatus;
use App\Enum\PaymentType;
use App\Enum\UnitType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class OrderFixtures extends Fixture implements DependentFixtureInterface
{
    public const string WEBAGENCY_STARTUP = 'order_webagency_startup';
    public const string DATASOFT_BASE = 'order_datasoft_base';
    public const string WEBAGENCY_ENDED = 'order_webagency_ended';

    public function getDependencies(): array
    {
        return [CustomerFixtures::class, OfferFixtures::class, UnitFixtures::class];
    }

    public function load(ObjectManager $manager): void
    {
        $thisMonth = new \DateTimeImmutable('first day of this month midnight');

        $this->createOrder($manager,
            reference: self::WEBAGENCY_STARTUP,
            customer: CustomerFixtures::WEBAGENCY,
            offer: 'Start-up',
            paymentType: PaymentType::ANNUAL,
            autoRenewal: true,
            start: $thisMonth->modify('-2 months'),
            status: OrderStatus::ACTIVE,
            totalPrice: '9720.00', // 900 € × 12 mois − 10 %
            rack: 'B01',
        );

        $this->createOrder($manager,
            reference: self::DATASOFT_BASE,
            customer: CustomerFixtures::DATASOFT,
            offer: 'Base',
            paymentType: PaymentType::MONTHLY,
            autoRenewal: true,
            start: $thisMonth,
            status: OrderStatus::ACTIVE,
            totalPrice: '100.00',
            rack: 'B02',
        );

        // Contrat terminé et non renouvelé : l'unité B03-U01 est de nouveau libre (règle n°3)
        $this->createOrder($manager,
            reference: self::WEBAGENCY_ENDED,
            customer: CustomerFixtures::WEBAGENCY,
            offer: 'Base',
            paymentType: PaymentType::MONTHLY,
            autoRenewal: false,
            start: $thisMonth->modify('-3 months'),
            status: OrderStatus::ENDED,
            totalPrice: '100.00',
            rack: 'B03',
        );

        $manager->flush();
    }

    private function createOrder(
        ObjectManager $manager,
        string $reference,
        string $customer,
        string $offer,
        PaymentType $paymentType,
        bool $autoRenewal,
        \DateTimeImmutable $start,
        OrderStatus $status,
        string $totalPrice,
        string $rack,
    ): void {
        $offerEntity = $this->getReference(OfferFixtures::reference($offer), Offer::class);
        $end = $start->modify(\sprintf('+%d months -1 day', $paymentType->months()));

        $order = (new Order())
            ->setCustomer($this->getReference($customer, Customer::class))
            ->setOffer($offerEntity)
            ->setOrderDate($start)
            ->setStartDate($start)
            ->setEndDate($end)
            ->setPaymentType($paymentType)
            ->setAutoRenewal($autoRenewal)
            ->setStatus($status)
            ->setTotalPrice($totalPrice);

        // Règle n°2 : toutes les unités de la commande sont dans le même rack
        for ($position = 1; $position <= $offerEntity->getUnitCount(); ++$position) {
            $unit = $this->getReference(UnitFixtures::reference($rack, $position), Unit::class);

            $assignment = (new Assignment())
                ->setUnit($unit)
                ->setStartDate($start)
                ->setEndDate($end)
                ->setCustomName($unit->getNumber())
                ->setUnitType(UnitType::WEB);

            $order->addAssignment($assignment); // remplit aussi $assignment->customerOrder
            $manager->persist($assignment);
        }

        $manager->persist($order);
        $this->addReference($reference, $order);
    }
}
