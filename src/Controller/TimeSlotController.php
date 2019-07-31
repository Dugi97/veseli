<?php

namespace App\Controller;

use App\Entity\TimeSlot;
use App\Form\TimeSlotType;
use App\Repository\TimeSlotRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/time/slot")
 */
class TimeSlotController extends AbstractController
{
    /**
     * @Route("/", name="time_slot_index", methods={"GET"})
     */
    public function index(TimeSlotRepository $timeSlotRepository): Response
    {
        return $this->render('time_slot/index.html.twig', [
            'time_slots' => $timeSlotRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="time_slot_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $timeSlot = new TimeSlot();
        $form = $this->createForm(TimeSlotType::class, $timeSlot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($timeSlot);
            $entityManager->flush();

            return $this->redirectToRoute('time_slot_index');
        }

        return $this->render('time_slot/new.html.twig', [
            'time_slot' => $timeSlot,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="time_slot_show", methods={"GET"})
     */
    public function show(TimeSlot $timeSlot): Response
    {
        return $this->render('time_slot/show.html.twig', [
            'time_slot' => $timeSlot,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="time_slot_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TimeSlot $timeSlot): Response
    {
        $form = $this->createForm(TimeSlotType::class, $timeSlot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('time_slot_index');
        }

        return $this->render('time_slot/edit.html.twig', [
            'time_slot' => $timeSlot,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="time_slot_delete", methods={"DELETE"})
     */
    public function delete(Request $request, TimeSlot $timeSlot): Response
    {
        if ($this->isCsrfTokenValid('delete'.$timeSlot->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($timeSlot);
            $entityManager->flush();
        }

        return $this->redirectToRoute('time_slot_index');
    }
}
