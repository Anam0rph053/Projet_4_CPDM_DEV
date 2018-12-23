<?php
/**
 * Created by PhpStorm.
 * User: noemiecoploimac
 * Date: 12/12/2018
 * Time: 11:17
 */

namespace AppBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * Class NotSunday
 * @package AppBundle\Validator\Constraints
 *
 * @Annotation
 */
class NotSunday extends Constraint
{
    public $message = "Vous ne pouvez pas réserver un Dimanche";

}