<?php
/**
 * Created by PhpStorm.
 * User: noemiecoploimac
 * Date: 12/12/2018
 * Time: 14:52
 */

namespace AppBundle\Service;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;



class Payment
{
    private $stripePrivate;

    /** @var Request  */
    private $request;

    public function __construct(RequestStack $requestStack, $stripePrivate)
    {
        $this->stripePrivate = $stripePrivate;
        $this->request = $requestStack->getCurrentRequest();
    }

    public function doPayment($price, $desc )
    {

        $token = $this->request->get('stripeToken');
        \Stripe\Stripe::setApiKey($this->stripePrivate);
        try{
            $charge = \Stripe\Charge::create(array(
                "amount" => $price * 100,
                "currency" => "eur",
                "source" => $token,
                "description" => $desc
            ));

            return $charge['id'];

        }catch(\Stripe\Error\Card $e) {
            return false;
        }

    }
}