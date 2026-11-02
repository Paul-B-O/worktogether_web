<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RackController extends AbstractController
{
    #[Route('/admin/rack', name: 'app_admin_rack')]
    public function index(): Response
    {
        return $this->render('admin/rack/index.html.twig', [
            'controller_name' => 'RackController',
        ]);
    }
}
