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
 * Class NotTuesday
 * @package AppBundle\Validator\Constraints
 *
 * @Annotation
 */
class NotTuesday extends Constraint
{
    public $message = "Vous ne pouvez pas réserver un mardi";



}