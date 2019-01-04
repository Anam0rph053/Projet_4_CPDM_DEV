<?php
/**
 * Created by PhpStorm.
 * User: noemiecoploimac
 * Date: 31/12/2018
 * Time: 18:08
 */

namespace AppBundle\Service;
use AppBundle\Entity\Booking;
use Twig_Environment;


class Mailer
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    private $twig_Environment;

    public function __construct(\Swift_Mailer $mailer, Twig_Environment $twig_Environment)
    {
        $this->mailer = $mailer;
        $this->twig_Environment = $twig_Environment;
    }


    /**
     * @param Booking $booking
     * @return int
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function sendEmail(Booking $booking)
    {



        $message = new \Swift_Message('Vous avez reçu la commande N° : '. $booking->getTransactionNumber());

        $cid = $message->embed(\Swift_Image::fromPath('media/entete.png'));


        $message
            ->setFrom(['louvre_resa@louvre.fr' => 'Billetterie'])
            ->setTo([$booking->getEmail()])
            ->setBody(
                $this->twig_Environment->render('booking/mailer_template.html.twig',
                    array('booking' => $booking, 'imgUrl'=> $cid)
                ),
                'text/html'
            );
        return $this->mailer->send($message);
    }
}