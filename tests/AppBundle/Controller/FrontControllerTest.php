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
            ['/fr/', 200],
            ['/fr/info', 404],
            ['/fr/recap', 404],
            ['/fr/confirm', 404],
            ['/fr/infosPratiques', 200],
            ['/fr/confirm_contact', 200],
            ['/fr/contact', 200],
        ];
    }



    public function testWorkFlow()
    {

        //Test VISITE
        $client = static::createClient();

        $crawler = $client->request('GET', '/fr/');

        $form = $crawler->selectButton('Valider')->form();
        $form['appbundle_booking[visitDate]'] = '2019-02-13';
        $form['appbundle_booking[email]'] = 'toto@gmail.fr';
        $form['appbundle_booking[ticketNumber]'] = 1;
        $form['appbundle_booking[ticketType]'] = 'allDay';

        $client->submit($form);

        $client->followRedirect();

        $this->assertSame(1, $crawler->filter('html:contains("Réservation")')->count());

        //TEST INFO
        $crawler = $client->request('GET', '/fr/info');

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
        $crawler = $client->request('GET', '/fr/recap');

        $this->assertSame(1, $crawler->filter('html:contains("Nom")')->count());
        $this->assertSame(1, $crawler->filter('html:contains("Prénom")')->count());
        $this->assertSame(1, $crawler->filter('html:contains("Tarifs")')->count());
        $this->assertSame(1, $crawler->filter('h4:contains("Total à Payer")')->count());


    }

}