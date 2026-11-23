<?php

namespace App\Controller;

use App\Repository\UnitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class UnitController extends AbstractController
{
    #[Route('/unit', name: 'app_unit')]
    #[IsGranted('ROLE_CUSTOMER')]
    public function index(UnitRepository $ur): Response
    {
        $user = $this->getUser();
        $units = $ur->findByUser($user);
        return $this->render('unit/index.html.twig', [
            'controller_name' => 'UnitController',
            "units" => $units,
        ]);
    }
}
