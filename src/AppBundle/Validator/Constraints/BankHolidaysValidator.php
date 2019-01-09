<?php
/**
 * Created by PhpStorm.
 * User: noemiecoploimac
 * Date: 12/12/2018
 * Time: 18:32
 */

namespace AppBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class BankHolidaysValidator extends ConstraintValidator
{
    /**
     * Checks if the passed value is valid.
     *
     * @param mixed $value The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     */

    public function validate($value, Constraint $constraint)
    {
        if($value !== null){ //si pas null on récupére la methode get Holidays et l'année
            $bankHolidays = $this->getHolidays($value->format('Y'));

            foreach ($bankHolidays as $holiday){ // on boucle sur la methode get holidays

                if ($value->format('U') == $holiday) { //on récupére le timestamp

                    $this->context->buildViolation($constraint->message) //si date selectionné est dans le tableau on affiche l'érreur
                         ->addViolation();
                }
            }
        }
    }

    function getHolidays($year = null)
    {
        if ($year === null)
        {
            $year = intval(date('Y'));
        }

        $easterDate  = easter_date($year);
        $easterDay   = date('j', $easterDate);
        $easterMonth = date('n', $easterDate);
        $easterYear   = date('Y', $easterDate);
        $BankHolidays = array(
            // Dates fixes
            mktime(0, 0, 0, 1,  1,  $year),  // 1er janvier
            mktime(0, 0, 0, 5,  1,  $year),  // Fête du travail
            mktime(0, 0, 0, 5,  8,  $year),  // Victoire des alliés
            mktime(0, 0, 0, 7,  14, $year),  // Fête nationale
            mktime(0, 0, 0, 8,  15, $year),  // Assomption
            mktime(0, 0, 0, 11, 1,  $year),  // Toussaint
            mktime(0, 0, 0, 11, 11, $year),  // Armistice
            mktime(0, 0, 0, 12, 25, $year),  // Noel

            // Dates variables
            mktime(0, 0, 0, $easterMonth, $easterDay + 1,  $easterYear),
            mktime(0, 0, 0, $easterMonth, $easterDay + 39, $easterYear),
            mktime(0, 0, 0, $easterMonth, $easterDay + 50, $easterYear),
        );

        return $BankHolidays;
    }
}
