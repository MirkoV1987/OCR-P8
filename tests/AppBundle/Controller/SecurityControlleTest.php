<?php

namespace Tests\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Test the default controller.
 */
class SecurityControllerTest extends WebTestCase
{
    private $client;

    protected function setUp(): void
    {
        $this->client = self::createClient();
    }

    public function testLogin(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $buttonCrawlerForm = $crawler->selectButton('Se connecter');
        $form = $buttonCrawlerForm->form();
        $this->client->submit($form, [
            '_username' => 'Mirko Venturi',
            '_password' => 'Mirko87'
        ]);
        
        $crawler = $this->client->request('GET', '/');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame('Se déconnecter', $crawler->filter('a.pull-right.btn.btn-danger')->text());
    }
}
