<?php
/**
 * Created by PhpStorm.
 * User: noemiecoploimac
 * Date: 08/01/2019
 * Time: 18:17
 */

namespace tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HTTPFoundation\Response;



class FrontControllerTest extends WebTestCase
{


    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url, $expectedStatus)
    {
        $client = static::createClient();
        $client->request('GET', $url);

        $this->assertSame($expectedStatus, $client->getResponse()->getStatusCode());
    }

    public function urlProvider()
    {
        return [
            ['/', 200],
            ['/info', 404],
            ['/recap', 404],
            ['/confirm', 404],
            ['/infosPratiques', 200],
            ['/confirm_contact', 200],
            ['/contact', 200],
        ];
    }



    public function testWorkFlow()
    {

        //Test VISITE
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $form = $crawler->selectButton('Valider')->form();
        $form['appbundle_booking[visitDate]'] = '2019-02-13';
        $form['appbundle_booking[email]'] = 'toto@gmail.fr';
        $form['appbundle_booking[ticketNumber]'] = 1;
        $form['appbundle_booking[ticketType]'] = 'allDay';

        $client->submit($form);

        $client->followRedirect();

        $this->assertSame(1, $crawler->filter('html:contains("Réservation")')->count());


        //TEST INFO
        $crawler = $client->request('GET', '/info');

        $form = $crawler->selectButton('Valider')->form();
        $form['appbundle_booking_tickets[tickets][0][lastName]'] = 'toto';
        $form['appbundle_booking_tickets[tickets][0][firstName]'] = 'tata';
        $form['appbundle_booking_tickets[tickets][0][birthDate]'] = '1984-09-23';
        $form['appbundle_booking_tickets[tickets][0][country]'] ='FR';

        $client->submit($form);

        $client->followRedirect();

        $this->assertSame(1, $crawler->filter('label:contains("Prénom")')->count());
        $this->assertSame(1, $crawler->filter('label:contains("Nom")')->count());
        $this->assertSame(1, $crawler->filter('label:contains("Date de naissance")')->count());
        $this->assertSame(1, $crawler->filter('label:contains("Pays")')->count());

        //TEST RECAP
        $crawler = $client->request('GET', '/recap');

        $link = $crawler->selectLink('Modifier')->link();
        $crawler = $this->client->click($link);



    }

}