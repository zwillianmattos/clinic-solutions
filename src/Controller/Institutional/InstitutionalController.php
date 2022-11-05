<?php

namespace App\Controller\Institutional;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InstitutionalController extends AbstractController
{
    #[Route('/', name: 'app_institutional')]
    public function index(): Response
    {
        return $this->render('Institutional/index.html.twig');
    }
}
