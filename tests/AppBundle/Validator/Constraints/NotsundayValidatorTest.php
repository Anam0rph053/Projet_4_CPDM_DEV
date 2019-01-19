<?php
/**
 * Created by PhpStorm.
 * User: noemiecoploimac
 * Date: 19/01/2019
 * Time: 12:22
 */

namespace Tests\AppBundle\Validator\Constraints;

use AppBundle\Entity\Booking;
use AppBundle\Validator\Constraints\NotSunday;
use AppBundle\Validator\Constraints\NotSundayValidator;
use Symfony\Component\Validator\ConstraintValidator;

class NotsundayValidatorTest extends ValidatorTestAbstract
{

    /**
     * Retourne une instance du validateur à tester.
     *
     * @return ConstraintValidator
     */
    protected function getValidatorInstance()
    {
        return new NotSundayValidator();
    }

    public function testNotSundayValidatorKO()
    {
        $notSundayConstraint = new NotSunday();
        $notSundayValidator = $this->initValidator();

        $notSundayValidator->validate(new \DateTime('2019-03-18'), $notSundayConstraint);
    }

    public function testNotSundayValidatorOK()
    {
        $notSundayConstraint = new NotSunday();
        $notSundayValidator = $this->initValidator($notSundayConstraint->message);

        $notSundayValidator->validate(new \DateTime('2019-03-24'), $notSundayConstraint);
    }
}
