<?php

namespace App\Controller\Admin;


use App\Entity\Appointment;
use App\Form\AppointmentType;
use App\Repository\AppointmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/calendar')]
class CalendarController extends AbstractController
{
    #[Route('/', name: 'calendar')]
    public function index(Request $request, AppointmentRepository $appointmentRepository): Response
    {
        $appointment = new Appointment();
        $form = $this->createForm(AppointmentType::class, $appointment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $appointmentRepository->save($appointment, true);

            return $this->redirectToRoute('calendar', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('Admin/calendar/index.html.twig', [
            'appointment' => $appointment,
            'form' => $form->createView(),
        ]);
    }
}
