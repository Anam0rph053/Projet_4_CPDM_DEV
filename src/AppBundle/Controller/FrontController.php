<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Ticket;
use AppBundle\Form\BookingTicketsType;
use AppBundle\Form\BookingType;
use AppBundle\Form\TicketType;
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
    public function homeAction(Request $request, SessionInterface $session)
    {
        $booking = new Booking();
        $ticket = new Ticket();

        $formBooking = $this->createForm(BookingType::class, $booking);

        $formBooking->handleRequest($request);

        if ($formBooking->isSubmitted() && $formBooking->isValid()) {


            // TODO ajouter autant de ticket vide que demandé dans l'objet booking

            for($x = 0; $x < $booking->getTicketNumber(); $x++)

            $booking->addTicket($ticket);
            $session->set('booking', $booking);




            return $this->redirectToRoute('info');
        }
        // replace this example code with whatever you need
        return $this->render('booking\home.html.twig', array(
                'formBooking' => $formBooking->createView(),
            )
        );
    }


    /**
     * @Route("/info", name="info")
     */
    public function infoAction(Request $request, SessionInterface $session, PriceCalculator $calculator)
    {

        $booking = $session->get('booking');
        dump($booking);


        $form = $this->createForm(BookingTicketsType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

// TODO calculer le prix des tickets et du total de la commande
            $calculator->computePrice($booking);

            return $this->redirectToRoute('recap');
        }

        // replace this example code with whatever you need
        return $this->render('booking\info.html.twig', array(
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @Route("/recap", name="recap")
     */
    public function recapAction(SessionInterface $session)
    {
        $booking = $session->get('booking');
        dump($booking);
        return $this->render('booking\recap.html.twig'
        );
    }
}
