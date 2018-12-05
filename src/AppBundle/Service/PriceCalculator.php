<?php
/**
 * Created by PhpStorm.
 * User: noemiecoploimac
 * Date: 28/11/2018
 * Time: 09:52
 */

namespace AppBundle\Service;


use AppBundle\Entity\Booking;
use AppBundle\Entity\Ticket;


class PriceCalculator
{
    const FREE_PRICE = 0;
    const CHILD_PRICE = 8;
    const NORMAL_PRICE = 16;
    const SENIOR_PRICE = 12;
    const REDUCE_PRICE = 10;

    const FREE_AGE = 4;
    const CHILD_AGE = 12;
    const SENIOR_AGE = 60;

    public function getAge(Ticket $ticket){

        $birthDateInterval = $ticket->getBirthDate()->diff(new \DateTime())->y;
        return $birthDateInterval;

    }

    public function computePrice(Booking $booking)
    {
        $totalPrice = 0;
        $tickets = $booking->getTickets();

        foreach($tickets as $ticket){

            $age = $this->getAge($ticket);

            if($age < self::FREE_AGE){
                //billet gratuit
                $price = self::FREE_PRICE;


            }elseif($age < self::CHILD_AGE){
                //billet junior
                $price = self::CHILD_PRICE;

            }elseif($age < self::SENIOR_AGE){
                //billet adult
                if($ticket->getReducePrice()){
                    $price = self::REDUCE_PRICE;
                }else {
                    $price = self::NORMAL_PRICE;
                }

            }else{
                //billet senior
                if($ticket->getReducePrice()){
                    $price = self::REDUCE_PRICE;
                }else {
                    $price = self::SENIOR_PRICE;
                }
            }

            $ticket->setPrice($price);
            $totalPrice += $price;
        }

        $booking->setPrice($totalPrice);


    }
}