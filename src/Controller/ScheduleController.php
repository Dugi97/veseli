<?php

namespace App\Controller;

use App\Entity\Boat;
use App\Entity\Lunch;
use App\Entity\Schedule;
use App\Entity\TimeSlot;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ScheduleController extends AbstractController
{
    /**
     * @Route("/", name="schedule")
     */
    public function index(Request $request, EntityManagerInterface $em)
    {
        $em = $this->getDoctrine()->getManager();
        $ts = $em->getRepository(TimeSlot::class)->findAll();
        $boats = $em->getRepository(Boat::class)->findAll();
        $lunches = $em->getRepository(Lunch::class)->findAll();
        $schedules= $em->getRepository(Schedule::class)->findAll();
        $allSchedules = $em->getRepository(Schedule::class)->findAll();



        if (isset( $_POST['send']) )
        {
            if (!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['phone']))
            {
                if (is_numeric($_POST['phone']))
                {

                    foreach ($schedules as $sch)
                    {
                        if ($sch->getPhone() != $_POST['phone'])
                        {
                            $phone = $_POST['phone'];

                        }
                        else {
                            $phone= "";
                            break;
                        }
                    }
                    if (!empty($phone))
                    {
                        $email = $_POST['email'];

                        if (filter_var($email, FILTER_VALIDATE_EMAIL))
                        {

                            $boat = $em->getRepository(Boat::class)->findOneBy(['type' => $_POST['boat']]);
                            $lunch = $em->getRepository(Lunch::class)->findOneBy(['type' => $_POST['lunch']]);
                            $timeSlot = $em->getRepository(TimeSlot::class)->findOneBy(['period'  => $_POST['timeSlot']]);
                            $schedule = new Schedule($_POST['username'],$email,$phone,$boat,$lunch,$timeSlot);
                            $schedulesByTimeSlot = $em->getRepository(Schedule::class)->findBy(['timeSlot' => $timeSlot->getId()]);

                            if (count($schedulesByTimeSlot) < $timeSlot->getCapacity())
                            {

                                $em->persist($schedule);
                                $em->flush();

                                return $this->render('schedule/show.html.twig',
                                    [
                                        'schedules' => $schedule,
                                        'allSchedules' => $allSchedules
                                    ]
                                );

                            }
                            else
                            {
                                echo "There is no more free spaces in this slot !";
                            }


                        }
                        else
                            {
                                echo "Email in not in valid format !";
                            }

                    }
                    else
                    {
                        echo "This phone already exist in our schedules!";
                    }
                }


                else
                {
                    echo "Phone number must be numeric!";

                }
            }
            else
            {
                echo "You have to fill in every field!!!";
            }

        }

        return $this->render('schedule/index.html.twig', [
            'timeSlots' => $ts,
            'schedules' =>  $schedules,
            'boats' => $boats,
            'lunches' => $lunches,
        ]);
    }

    /**
     * @Route("/showall", name="showall")
     */
    public function showall()
    {
        $em = $this->getDoctrine()->getManager();
        $allSchedules = $em->getRepository(Schedule::class)->findAll();


        return $this->render('schedule/show.html.twig',
            [
                'allSchedules' => $allSchedules
            ]
        );
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(Request $request,Schedule $schedule)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($schedule);
        $em->flush();


        return $this->redirectToRoute('showall');
    }
}
