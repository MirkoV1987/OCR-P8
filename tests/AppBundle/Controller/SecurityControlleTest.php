<?php

namespace Tests\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Test the default controller.
 */
class SecurityControllerTest extends WebTestCase
{
    /**
     * Test the route with an authenticated user.
     */
    public function testLoginAction()
    {
        // Create an authenticated client
        $client = static::createClient();

        // Request the route
        $crawler = $client->request('GET', '/login');

        // Test
        $this->assertEquals(
            1,
            $crawler->filter('form')->count()
        );
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        // Select the form
        $form = $crawler->selectButton('Se connecter')->form();

        // set some values
        $form['_username'] = 'TestUser';
        $form['_password'] = '123456789';

        // submit the form
        //$crawler = $client->submit($form);

        // Test
        $this->assertTrue($client->getResponse()->isRedirect());

        $this->contains('security/login.html.twig');
        $this->assertClassHasAttribute($lastUsername, SecurityController::class);
        $this->assertClassHasAttribute($error, SecurityController::class);
    }

    public function testLoginCheck()
    {
        // Create an authenticated client
        $client = static::createClient();

        // Request the route
        $crawler = $client->request('GET', '/login_check');

        // Test
        $this->assertTrue($client->getResponse()->isRedirect());
    }
}