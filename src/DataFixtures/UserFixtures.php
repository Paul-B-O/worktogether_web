<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Enum\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public const string PASSWORD = 'password';

    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $staff = [
            ['admin@worktogether.fr', 'Martin', 'Alice', Role::ADMINISTRATOR],
            ['comptable@worktogether.fr', 'Bernard', 'Paul', Role::ACCOUNTANT],
            ['technicien@worktogether.fr', 'Petit', 'Lucas', Role::TECHNICIAN],
            ['commercial@worktogether.fr', 'Durand', 'Emma', Role::SALES],
        ];

        foreach ($staff as [$email, $lastName, $firstName, $role]) {
            $user = (new User())
                ->setEmail($email)
                ->setLastName($lastName)
                ->setFirstName($firstName)
                ->setRole($role);
            $user->setPassword($this->passwordHasher->hashPassword($user, self::PASSWORD));
            $manager->persist($user);
        }

        $manager->flush();
    }
}
