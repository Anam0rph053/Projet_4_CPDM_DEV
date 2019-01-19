<?php
/**
 * Created by PhpStorm.
 * User: noemiecoploimac
 * Date: 19/01/2019
 * Time: 14:52
 */

namespace Tests\AppBundle\Validator\Constraints;


use AppBundle\Validator\Constraints\NotTuesday;
use AppBundle\Validator\Constraints\NotTuesdayValidator;
use Symfony\Component\Validator\ConstraintValidator;

class NotTuesdayValidatorTest extends ValidatorTestAbstract
{

    /**
     * Retourne une instance du validateur à tester.
     *
     * @return ConstraintValidator
     */
    protected function getValidatorInstance()
    {
        return new NotTuesdayValidator();
    }

    public function testNotTuesdayValidatorKO()
    {
        $notTuesdayConstraint= new NotTuesday();
        $notTuesdayValidator = $this->initValidator();

        $notTuesdayValidator->validate(new \DateTime('2019-03-22'), $notTuesdayConstraint);
    }

    public function testNotTuesdayValidatorOK()
    {
        $notTuesdayConstraint= new NotTuesday();
        $notTuesdayValidator = $this->initValidator($notTuesdayConstraint->message);

        $notTuesdayValidator->validate(new \DateTime('2019-03-19'), $notTuesdayConstraint);
    }


}