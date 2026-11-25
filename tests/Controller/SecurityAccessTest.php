<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class SecurityAccessTest extends WebTestCase
{
    public function testAnonymousIsRedirectedToLogin(): void
    {
        $client = static::createClient();
        $client->request('GET', '/customer/units');

        self::assertResponseRedirects('/login');
    }

    /**
     * @return iterable<string, array{string, string}>
     */
    public static function provideForbiddenPages(): iterable
    {
        yield 'technicien sur une page client' => ['technicien@worktogether.fr', '/customer/units'];
        yield 'client sur l\'administration' => ['client1@example.com', '/admin/rack'];
        yield 'commercial sur l\'administration' => ['commercial@worktogether.fr', '/admin/rack'];
    }

    #[DataProvider('provideForbiddenPages')]
    public function testForbiddenPages(string $email, string $url): void
    {
        $client = static::createClient();
        $this->logIn($client, $email);

        $client->request('GET', $url);

        self::assertResponseStatusCodeSame(403);
    }

    public function testCustomerSeesOnlyOwnCurrentUnits(): void
    {
        $client = static::createClient();
        $this->logIn($client, 'client1@example.com');

        $client->request('GET', '/customer/units');

        self::assertResponseIsSuccessful();
        self::assertSelectorCount(10, 'tbody tr');
        self::assertSelectorTextContains('tbody', 'B01-U01');
        self::assertSelectorTextNotContains('tbody', 'B02-U01'); // unité de DataSoft
        self::assertSelectorTextNotContains('tbody', 'B03-U01'); // contrat terminé (règle n°3)
    }

    private function logIn(KernelBrowser $client, string $email): void
    {
        $user = static::getContainer()->get(UserRepository::class)->findOneBy(['email' => $email]);
        $client->loginUser($user);
    }
}
