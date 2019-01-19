<?php
/**
 * Created by PhpStorm.
 * User: noemiecoploimac
 * Date: 15/12/2018
 * Time: 18:04
 */

namespace AppBundle\Validator\Constraints;


use AppBundle\Entity\Booking;
use AppBundle\Repository\BookingRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;


class OverBookingValidator extends ConstraintValidator
{
    const OVERBOOKING = 1000;

    /**
     * @var BookingRepository
     */
    private $repo;

    public function __construct(EntityManagerInterface $em)
   {


       $this->repo = $em->getRepository(Booking::class);
   }

    /**
     * Checks if the passed value is valid.
     *
     * @param mixed $value The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function validate($object, Constraint $constraint)
    {
        if(!$object instanceof Booking)
        {
            return;
        }
        $ticketSoldNumber = $this->repo->overbooking($object->getVisitDate());

        if($ticketSoldNumber + $object->getTicketNumber() > self::OVERBOOKING){
            $this->context->buildViolation($constraint->message)
                ->atPath('ticketNumber')
                ->addViolation();
        }


    }

}