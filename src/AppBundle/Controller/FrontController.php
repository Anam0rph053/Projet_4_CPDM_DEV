<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Ticket;
use AppBundle\Form\BookingType;
use AppBundle\Form\TicketType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Booking;



class FrontController extends Controller
{
    /**
     * @Route("/home", name="home")
     */
    public function homeAction(Request $request)
    {
        $booking = new Booking();

        $formBooking = $this->get('form.factory')->create(BookingType::class, $booking);


        if ($request->isMethod('POST') && $formBooking->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($booking);
            $em->flush();

                return $this->redirectToRoute('home');
            }
        // replace this example code with whatever you need
        return $this->render('booking\home.html.twig', array(
            'formBooking'  => $formBooking->createView(),
            )
           );
    }

    /**
     * @Route("/info", name="info")
     */
    public function infoAction(Request $request)
    {
        $ticket = new Ticket();

        $formTicket = $this->get('form.factory')->create(TicketType::class, $ticket);


        if ($request->isMethod('POST') && $formTicket->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ticket);
            $em->flush();

            return $this->redirectToRoute('home');
        }
        // replace this example code with whatever you need
        return $this->render('booking\info.html.twig', array(
                'formTicket'  => $formTicket->createView(),
            )
        );
    }
    /**
     * @Route("/recap", name="recap")
     */
    public function recapAction()
    {
        return $this->render('booking\recap.html.twig'
        );
    }
}
