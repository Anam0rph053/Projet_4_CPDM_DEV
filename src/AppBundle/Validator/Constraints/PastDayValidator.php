<?php
/**
 * Created by PhpStorm.
 * User: noemiecoploimac
 * Date: 21/01/2019
 * Time: 19:52
 */

namespace AppBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PastDayValidator extends ConstraintValidator
{



    /**
     * Checks if the passed value is valid.
     *
     * @param $day
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($day, Constraint $constraint)
    {
        $pastDay = date_format($day,"d-m-Y");
        $nowDate = date_format(new \DateTime(), "d-m-Y");

        if(new \DateTime($pastDay) < new\DateTime($nowDate))
        {
            $this->context->buildViolation($constraint->message)
                 ->addViolation();
        }

    }
}