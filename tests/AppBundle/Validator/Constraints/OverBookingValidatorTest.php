<?php
/**
 * Created by PhpStorm.
 * User: noemiecoploimac
 * Date: 19/01/2019
 * Time: 15:36
 */

namespace Tests\AppBundle\Validator\Constraints;


use AppBundle\Manager\BookingManager;
use AppBundle\Validator\Constraints\OverBooking;
use AppBundle\Validator\Constraints\OverBookingValidator;
use AppBundle\Entity\Booking;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\ConstraintValidator;

class OverBookingValidatorTest extends ValidatorTestAbstract
{
//    const OVERBOOKING = 1000;
    /**
     * @var EntityManagerInterface
     */
    private $em;


    public function setUp()
    {
        $this->em = $this
            ->getMockBuilder(EntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
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

        $OverBookingValidator = $this->initValidator();
        $OverBookingValidator->validate(4,$OverBookingConstraint);
    }

//    public function testOverBookingValidatorOK()
//    {
//        $OverBookingConstraint = new OverBooking();
//
//        $OverBookingValidator = $this->initValidator($OverBookingConstraint->message);
//        $OverBookingValidator->validate(1004,$OverBookingConstraint);
//    }

}