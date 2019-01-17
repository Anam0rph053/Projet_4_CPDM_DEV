<?php
/**
 * Created by PhpStorm.
 * User: noemiecoploimac
 * Date: 08/01/2019
 * Time: 18:22
 */

namespace Tests\AppBundle\Manager;

use AppBundle\Entity\Booking;
use AppBundle\Manager\BookingManager;
use AppBundle\Service\Mailer;
use AppBundle\Service\Payment;
use AppBundle\Service\PriceCalculator;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BookingManagerTest extends TestCase
{
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
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var Mailer
     */
    private $mailer;

    /**
     * @var BookingManager
     */
    private $bookingManager;

    public function setUp()
    {
        $this->session = new Session(new MockArraySessionStorage());


        $this->calculator = $this
            ->getMockBuilder(PriceCalculator::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->payment = $this
            ->getMockBuilder(Payment::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->em = $this
            ->getMockBuilder(EntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mailer = $this
            ->getMockBuilder(Mailer::class)
            ->disableOriginalConstructor()
            ->getMock();



        $this->bookingManager = new BookingManager(
            $this->session,
            $this->calculator,
            $this->payment,
            $this->em,
            $this->mailer
        );
    }


    public function testInitBooking()
    {
        $this->assertInstanceOf(Booking::class, $this->bookingManager->initBooking());
    }


    public function testGetCurrentBookingKO()
    {
        $this->expectException(NotFoundHttpException::class);
        $this->bookingManager->getCurrentBooking();
    }


    public function testGetCurrentBookingOK()
    {
        $this->session->set(BookingManager::SESSION_BOOKING_KEY, new Booking());
        $this->bookingManager->getCurrentBooking();
    }

    public function testPaymentOK(){
        $this->payment->method('doPayment')->willReturn(true);


        $booking = new Booking();

        $this->assertTrue($this->bookingManager->payment($booking));
        $this->assertNotNull($booking->getTransactionNumber());
    }

    public function testPaymentKO(){
        $this->payment->method('doPayment')->willReturn(false);


        $booking = new Booking();

        $this->assertFalse($this->bookingManager->payment($booking));
        $this->assertNull($booking->getTransactionNumber());
    }

}