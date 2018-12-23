<?php
/**
 * Created by PhpStorm.
 * User: noemiecoploimac
 * Date: 15/12/2018
 * Time: 16:58
 */

namespace AppBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * Class HalfDay
 * @package AppBundle\Validator\Constraints
 *
 * @Annotation
 */

class HalfDay extends Constraint
{

    public $message = "Vous ne pouvez pas réserver un billet journée passé 14h";

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

}
