<?php
/**
 * Created by PhpStorm.
 * User: noemiecoploimac
 * Date: 19/01/2019
 * Time: 15:36
 */

namespace Tests\AppBundle\Validator\Constraints;


use AppBundle\Manager\BookingManager;
use AppBundle\Repository\BookingRepository;
use AppBundle\Validator\Constraints\OverBooking;
use AppBundle\Validator\Constraints\OverBookingValidator;
use AppBundle\Entity\Booking;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\DocBlock\Tags\Method;
use PHPUnit_Framework_MockObject_MockObject;
use Symfony\Component\Validator\ConstraintValidator;

class OverBookingValidatorTest extends ValidatorTestAbstract
{
//    const OVERBOOKING = 1000;
    /**
     * @var EntityManagerInterface|PHPUnit_Framework_MockObject_MockObject
     */
    private $em;

    /**
     * @var BookingRepository|PHPUnit_Framework_MockObject_MockObject
     */
    private $bookingRepo;


    public function setUp()
    {
        $this->em = $this
            ->getMockBuilder(EntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->bookingRepo = $this->getMockBuilder(BookingRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->em->expects($this->once())->method('getRepository')->willReturn($this->bookingRepo);
    }

    /**
     * Retourne une instance du validateur à tester.
     *
     * @return ConstraintValidator
     */

    protected function getValidatorInstance()
    {
        return new OverBookingValidator($this->em);
    }

    public function testOverBookingValidatorKO()
    {
        $OverBookingConstraint = new OverBooking();
        $booking = new Booking();
        $booking->setVisitDate(new \DateTime());
        $booking->setTicketNumber(501);

        $this->bookingRepo->expects($this->once())->method('overbooking')->willReturn(500);

        $OverBookingValidator = $this->initValidator($OverBookingConstraint->message);
        $OverBookingValidator->validate($booking,$OverBookingConstraint);
    }

    public function testOverBookingValidatorOK()
    {

        $this->bookingRepo->expects($this->once())->method('overbooking')->willReturn(500);

        $OverBookingConstraint = new OverBooking();
        $booking = new Booking();
        $booking->setVisitDate(new \DateTime());
        $booking->setTicketNumber(499);

        $OverBookingValidator = $this->initValidator();
        $OverBookingValidator->validate($booking,$OverBookingConstraint);
    }

}