<?php
/**
 * Created by PhpStorm.
 * User: noemiecoploimac
 * Date: 15/12/2018
 * Time: 18:04
 */

namespace AppBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;


/**
 * Class OverBooking
 * @package AppBundle\Validator\Constraints
 *
 * @Annotation
 */
class OverBooking extends Constraint
{
    public $message = "billets épuisés";

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}