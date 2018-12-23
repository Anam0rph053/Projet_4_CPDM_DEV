<?php
/**
 * Created by PhpStorm.
 * User: noemiecoploimac
 * Date: 15/12/2018
 * Time: 16:58
 */

namespace AppBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use AppBundle\Entity\Booking;

class HalfDayValidator extends ConstraintValidator
{
    const HALF_DAY = 14;

    public function validate($object, Constraint $constraint)
    {
        if (!$object instanceof Booking) {
            return;
        }

        $now = \DateTime::createFromFormat('U',time());

        $hour = $now->format('H');
        $type = $object->getTicketType();

        if ($hour >= self::HALF_DAY &&
            $type == Booking::TYPE_FULL_DAY &&
            $object->getVisitDate()->format('Y-m-d') == $now->format('Y-m-d')
        ) {
            $this->context->buildViolation($constraint->message)
                ->atPath('visitDate')
                ->addViolation();
        }
    }
}
