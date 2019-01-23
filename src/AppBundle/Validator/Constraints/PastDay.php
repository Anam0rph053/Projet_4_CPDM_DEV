<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
* Class PastDay
* @package AppBundle\Validator\Constraints
*
* @Annotation
*/
class PastDay extends Constraint
{

    public $message = "Vous ne pouvez pas réserver un jour passé";

}