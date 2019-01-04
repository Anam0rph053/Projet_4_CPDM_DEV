<?php
/**
 * Created by PhpStorm.
 * User: noemiecoploimac
 * Date: 05/12/2018
 * Time: 11:37
 */

namespace AppBundle\Manager;


use AppBundle\Entity\Booking;
use AppBundle\Entity\Ticket;
use AppBundle\Service\Mailer;
use AppBundle\Service\Payment;
use AppBundle\Service\PriceCalculator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\ORM\EntityManagerInterface;



/**
 * Class BookingManager
 * @package AppBundle\Manager
 */
class BookingManager
{

    const SESSION_BOOKING_KEY = 'booking';
    /**
     * @var SessionInterface
     */
    private $session;
    /**
     * @var PriceCalculator
     */
    private $calculator;

    /**
     * @var Payment
     */
    private $payment;

    /**
     * BookingManager constructor.
     * @param SessionInterface $session
     * @param PriceCalculator $calculator
     * @param Payment $payment
     */
    public function __construct(SessionInterface $session, PriceCalculator $calculator, Payment $payment, EntityManagerInterface $entityManager, Mailer $mailer)
    {
        $this->session = $session;
        $this->calculator = $calculator;
        $this->payment = $payment;
        $this->em = $entityManager;
        $this->mailer = $mailer;

    }

    /**
     * @return Booking
     */
    public function initBooking()
    {
        $booking = new Booking();
        $this->session->set(self::SESSION_BOOKING_KEY, $booking);
        return $booking;
    }

    /**
     * @param Booking $booking
     */
    public function generateTickets(Booking $booking)
    {
        for ($x = 0; $x < $booking->getTicketNumber(); $x++) {
            $ticket = new Ticket();
            $booking->addTicket($ticket);
        }
    }

    public function getCurrentBooking()
    {
        $booking = $this->session->get(self::SESSION_BOOKING_KEY);

        if(!$booking instanceof  Booking){
            throw new NotFoundHttpException();
        }

        return $booking;

    }
    public function computeTotalPrice(Booking $booking)
    {
        $this->calculator->computePrice($booking);

    }

    /**
     * @param Booking $booking
     * @return bool
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function payment(Booking $booking)
    {
        if($this->payment->doPayment($booking->getPrice(),"Votre Commande")){
            $booking->setTransactionNumber(uniqid());
            $this->mailer->sendEmail($booking);
            $this->em->persist($booking);
            $this->em->flush();

            return true;
        }

        return false;

    }

    public function clearFunction()
    {
        $this->session->remove('booking');

    }
}