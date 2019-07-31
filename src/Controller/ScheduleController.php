<?php

namespace App\Controller;

use App\Entity\Boat;
use App\Entity\Lunch;
use App\Entity\Schedule;
use App\Entity\TimeSlot;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ScheduleController extends AbstractController
{
    /**
     * @Route("/schedule/", name="schedule")
     */
    public function index(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $ts = $entityManager->getRepository(TimeSlot::class)->findAll();
        $boats = $entityManager->getRepository(Boat::class)->findAll();
        $lunches = $entityManager->getRepository(Lunch::class)->findAll();
        $schedules= $entityManager->getRepository(Schedule::class)->findAll();

        if (isset( $_POST['send'] ))
        {
            
            $boat = $entityManager->getRepository(Boat::class)->findOneBy(['type' => $_POST['boat']]);
            $lunch = $entityManager->getRepository(Lunch::class)->findOneBy(['type' => $_POST['lunch']]);
            $timeSlot = $entityManager->getRepository(TimeSlot::class)->findOneBy(['period'  => $_POST['timeSlot']]);
            $schedule = new Schedule($_POST['username'],$_POST['email'],$_POST['phone'],$boat,$lunch,$timeSlot);
            $entityManager->persist($schedule);
            $entityManager->flush();

            return $this->render('schedule/show.html.twig',
                [
                    'schedules' => $schedules
                ]
                );

        }

        return $this->render('schedule/index.html.twig', [
            'timeSlots' => $ts,
            'schedules' => count($schedules),
            'boats' => $boats,
            'lunches' => $lunches
        ]);
    }
}
