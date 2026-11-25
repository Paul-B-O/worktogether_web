<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Repository\AssignmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Clock\ClockInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_CUSTOMER')]
final class UnitController extends AbstractController
{
    #[Route('/customer/units', name: 'app_customer_units', methods: ['GET'])]
    public function index(
        #[CurrentUser] Customer $customer,
        AssignmentRepository $assignmentRepository,
        ClockInterface $clock,
    ): Response {
        return $this->render('unit/index.html.twig', [
            'assignments' => $assignmentRepository->findActiveByCustomer($customer, $clock->now()),
        ]);
    }
}
