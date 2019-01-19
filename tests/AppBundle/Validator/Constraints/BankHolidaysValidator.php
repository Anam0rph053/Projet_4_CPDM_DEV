<?php
/**
 * Created by PhpStorm.
 * User: noemiecoploimac
 * Date: 19/01/2019
 * Time: 16:27
 */

namespace Tests\AppBundle\Validator\Constraints;


use AppBundle\Validator\Constraints\BankHolidays;

class BankHolidaysValidator extends ValidatorTestAbstract
{
  protected function getValidatorInstance()
  {
     return new BankHolidaysValidator();
  }
    public function testBankHolidaysValidatorKO()
    {
        $BankHolidaysConstraint = new BankHolidays();

        $BankHolidaysValidator = $this->initValidator();
        $BankHolidaysValidator->validate(new \DateTime('2019-04-13'),$BankHolidaysConstraint);
    }

    public function testBankHolidaysValidatorOK()
    {
        $BankHolidaysConstraint = new BankHolidays();

        $BankHolidaysValidator = $this->initValidator($BankHolidaysConstraint->message);
        $BankHolidaysValidator->validate(new \DateTime('2019-12-25'),$BankHolidaysConstraint);
    }


}
