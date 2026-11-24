<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CustomerFixtures extends Fixture
{
    public const string WEBAGENCY = 'customer_webagency';
    public const string DATASOFT = 'customer_datasoft';

    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $customers = [
            [self::WEBAGENCY, 'client1@example.com', 'Leroy', 'Julie', 'Webagency SARL', '0601020304', '12 rue de la Paix, 75002 Paris'],
            [self::DATASOFT, 'client2@example.com', 'Moreau', 'Hugo', 'DataSoft SAS', '0605060708', '8 avenue Foch, 69006 Lyon'],
        ];
        foreach ($customers as [$reference, $email, $lastName, $firstName, $companyName, $phone, $address]) {
            $customer = (new Customer())
                ->setCompanyName($companyName)
                ->setPhone($phone)
                ->setAddress($address)
                ->setEmail($email)
                ->setLastName($lastName)
                ->setFirstName($firstName);
            $customer->setPassword($this->passwordHasher->hashPassword($customer, UserFixtures::PASSWORD));
            $manager->persist($customer);
            $this->addReference($reference, $customer);
        }

        $manager->flush();
    }
}
