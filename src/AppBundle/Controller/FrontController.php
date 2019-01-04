<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Ticket;
use AppBundle\Form\BookingTicketsType;
use AppBundle\Form\BookingType;
use AppBundle\Form\TicketType;
use AppBundle\Manager\BookingManager;
use AppBundle\Service\Mailer;
use AppBundle\Service\PriceCalculator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Booking;


class FrontController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function homeAction(Request $request, BookingManager $bookingManager)
    {

        $booking = $bookingManager->initBooking();

        $formBooking = $this->createForm(BookingType::class, $booking);
        $formBooking->handleRequest($request);

        if ($formBooking->isSubmitted() && $formBooking->isValid()) {

            $bookingManager->generateTickets($booking);

            return $this->redirectToRoute('info');
        }

        return $this->render('booking\home.html.twig', array(
                'formBooking' => $formBooking->createView(),
            )
        );
    }


    /**
     * @Route("/info", name="info")
     */
    public function infoAction(Request $request, BookingManager $bookingManager)
    {

        $booking = $bookingManager->getCurrentBooking();

        $form = $this->createForm(BookingTicketsType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $bookingManager->computeTotalPrice($booking);

            return $this->redirectToRoute('recap');
        }

        return $this->render('/booking/info.html.twig', array(
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @Route("/recap", name="recap")
     *
     */
    public function recapAction(Request $request, BookingManager $bookingManager)
    {

        $booking = $bookingManager->getCurrentBooking();
        if ($request->isMethod('POST')) {

           if($bookingManager->payment($booking)){
               return $this->redirectToRoute('confirm');

           }else {
               $this->addFlash(
                   'notice',
                   'Une erreur s\'est produite lors de la transaction, Merci de réessayer'
               );
               return $this->render('/booking/recap.html.twig', array(
                       'booking' => $booking,
                       'stripe_public' => $this->getParameter('stripe_public')
                   )
               );
           }
        }

        return $this->render('/booking/recap.html.twig', array(
                'booking' => $booking,)
        );

    }

    /**
     * @Route("/confirm", name="confirm")
     */
    public function confirmAction(BookingManager $bookingManager)
    {

        $booking = $bookingManager->getCurrentBooking();

        $bookingManager->clearFunction();

        return $this->render('/booking/confirm.html.twig', array(
            'booking' => $booking));
    }

}


