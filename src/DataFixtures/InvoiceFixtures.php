<?php

namespace App\DataFixtures;

use App\Entity\Invoice;
use App\Entity\Order;
use App\Entity\Payment;
use App\Enum\InvoiceStatus;
use App\Enum\PaymentMethod;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class InvoiceFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies(): array
    {
        return [OrderFixtures::class];
    }

    public function load(ObjectManager $manager): void
    {
        $invoices = [
            // [commande, statut, moyen de paiement (null = pas encore payée)]
            [OrderFixtures::WEBAGENCY_STARTUP, InvoiceStatus::PAID, PaymentMethod::TRANSFER],
            [OrderFixtures::DATASOFT_BASE, InvoiceStatus::PENDING, null],
            [OrderFixtures::WEBAGENCY_ENDED, InvoiceStatus::PAID, PaymentMethod::CARD],
        ];

        foreach ($invoices as $i => [$orderReference, $status, $paymentMethod]) {
            $order = $this->getReference($orderReference, Order::class);

            $invoice = (new Invoice())
                ->setNumber(\sprintf('FAC-%s-%04d', $order->getStartDate()->format('Ym'), $i + 1))
                ->setIssueDate($order->getStartDate())
                ->setPeriodStart($order->getStartDate())
                ->setPeriodEnd($order->getEndDate())
                ->setAmount($order->getTotalPrice())
                ->setStatus($status);
            $order->addInvoice($invoice);
            $manager->persist($invoice);

            if (null !== $paymentMethod) {
                $payment = (new Payment())
                    ->setPaymentDate($order->getStartDate()->modify('+3 days'))
                    ->setAmount($invoice->getAmount())
                    ->setPaymentMethod($paymentMethod)
                    ->setReference(\sprintf('PAY-%04d', $i + 1));
                $invoice->addPayment($payment);
                $manager->persist($payment);
            }
        }

        $manager->flush();
    }
}
