<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\User;

class TaskControllerTest extends WebTestCase
{
    private $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function testListAction()
    {
        //$this->loginUser();
        $this->client->request('GET', '/tasks');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

    // public function testListAction()
    // {
    //     //$client = static::createClient();

    //     // Go to task list
    //     $crawler = $this->client->request('GET', '/tasks');
    //     $form = $crawler->selectButton('Connexion')->form();
    //     static::assertResponseIsSuccessful();
    //     static::assertRouteSame('task_list');

    //     // Assert there are tasks
    //     $links = $crawler->filter('a')->extract(['_text']);
    //     static::assertContains('Tâche_1', $links);
    //     static::assertContains('Tâche_2', $links);
    // }
}