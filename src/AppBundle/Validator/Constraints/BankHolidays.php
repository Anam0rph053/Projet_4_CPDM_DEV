<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class BankHolidays
 * @package AppBundle\Validator\Constraints
 *
 * @Annotation
 */
class BankHolidays extends Constraint
{
    public $message = "Vous ne pouvez pas réserver un jour férié";

}