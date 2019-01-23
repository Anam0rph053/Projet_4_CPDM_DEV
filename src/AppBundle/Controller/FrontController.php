<?php

namespace AppBundle\Controller;


use AppBundle\Form\BookingTicketsType;
use AppBundle\Form\BookingType;
use AppBundle\Form\ContactType;
use AppBundle\Manager\BookingManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class FrontController extends Controller
{
    /**
     * @Route("/", name="home")
     * @param Request $request
     * @param BookingManager $bookingManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
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
     * @param Request $request
     * @param BookingManager $bookingManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function infoAction(Request $request, BookingManager $bookingManager)
    {

        $booking = $bookingManager->getCurrentBooking(['booking_init']);

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
     * @param Request $request
     * @param BookingManager $bookingManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function recapAction(Request $request, BookingManager $bookingManager)
    {

        $booking = $bookingManager->getCurrentBooking(['tickets_filled']);
        if ($request->isMethod('POST')) {

            try {
                if ($bookingManager->payment($booking)) {
                    return $this->redirectToRoute('confirm');

                } else {
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
            } catch (\Twig_Error_Loader $e) {
            } catch (\Twig_Error_Runtime $e) {
            } catch (\Twig_Error_Syntax $e) {
            }
        }

        return $this->render('/booking/recap.html.twig', array(
                'booking' => $booking,)
        );

    }

    /**
     * @Route("/confirm", name="confirm")
     * @param BookingManager $bookingManager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function confirmAction(BookingManager $bookingManager)
    {

        $booking = $bookingManager->getCurrentBooking(['tickets_filled']);

        $bookingManager->clearFunction();

        return $this->render('/booking/confirm.html.twig', array(
            'booking' => $booking));
    }

    /**
     * @Route("/infosPratiques", name="infosPratiques")
     */
    public function infosPratiquesAction()
    {
        return $this->render('infoPratiques/infosPratiques.html.twig');
    }


    /**
     * @Route("/confirm_contact", name="confirmContact")
     * @param BookingManager $bookingManager
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function confirmContactAction(BookingManager $bookingManager)
    {
        $bookingManager->clearFunction();

        return $this->render('contact/confirmContact.html.twig');
    }

    /**
     * @Route("/contact", name="contact")
     * @param Request $request
     * @param BookingManager $bookingManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function contactAction(Request $request, BookingManager $bookingManager)
    {

        $formContact = $this->createForm(ContactType::class);
        $formContact->handleRequest($request);

        if ($formContact->isSubmitted() && $formContact->isValid()) {
            try {
                $bookingManager->contact($formContact->getData());
            } catch (\Twig_Error_Loader $e) {
            } catch (\Twig_Error_Runtime $e) {
            } catch (\Twig_Error_Syntax $e) {
            }
            $this->addFlash(
                'success',
                'votre message nous a bien été transmis'
            );
             return $this->redirectToRoute('confirmContact');
            }else {
                $this->addFlash(
                    'notice',
                    'Une erreur s\'est produite lors de l\'envoi de votre message, Merci de réessayer'
                );
            }

        return $this->render('contact/contactForm.html.twig', array(
            'formContact' => $formContact->createView()
        ));
    }

}


