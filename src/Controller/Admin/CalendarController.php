<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/calendar')]
class CalendarController extends AbstractController
{
    #[Route('/', name: 'calendar')]
    public function index(): Response
    {
        return $this->render('Admin/calendar/index.html.twig');
    }
}
