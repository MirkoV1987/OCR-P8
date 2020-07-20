<?php

// namespace App\Tests\Controller;


// use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

// class TaskControllerTest extends WebTestCase
// {
//     private $client;

//     public function setUp(): void
//     {
//         $this->client = static::createClient();
//     }

//     public function loginUser(): void
//     {
//         $crawler = $this->client->request('GET', 'http://localhost/P8-ToDoList/web/login');
//         $form = $crawler->selectButton('Connexion')->form();
//         $this->client->submit($form, ['Nom d\'utilisateur' => 'Admin1', 'Mot de passe' => 'admin']);
//     }

//     public function testListAction()
//     {
//         $this->loginUser();
//         $this->client->request('GET', 'http://P8-ToDoList/web/tasks');
//         $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
//     }

//     public function testCreateAction()
//     {
//         $this->loginUser();

//         $crawler = $this->client->request('GET', 'http://localhost/P8-ToDoList/web/tasks/create');
//         $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

//         $form = $crawler->selectButton('Ajouter')->form();
//         $form['task[title]'] = 'title';
//         $form['task[content]'] = 'content';
//         $this->client->submit($form);

//         $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

//         $crawler = $this->client->followRedirect();

//         $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
//         $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
//     }

//     public function testEditAction()
//     {
//         $this->loginUser();

//         $crawler = $this->client->request('GET', 'http://localhost/P8-ToDoList/web/tasks/11/edit');
//         $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

//         $form = $crawler->selectButton('Modifier')->form();
//         $form['task[title]'] = 'title';
//         $form['task[content]'] = 'content';
//         $this->client->submit($form);

//         $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

//         $crawler = $this->client->followRedirect();

//         $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
//         $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
//     }

//     public function testToggleTaskAction(): void
//     {
//         $this->loginUser();

//         $this->client->request('GET', 'http://localhost/P8-ToDoList/web/tasks/11/toggle');

//         $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

//         $crawler = $this->client->followRedirect();

//         $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
//         $this->assertEquals(1, $crawler->filter('div.alert-success')->count());

//     }

//     public function testDeleteAction()
//     {
//         $this->loginUser();

//         $this->client->request('GET', 'http://localhost/P8-ToDoList/web/tasks/11/delete');

//         $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

//         $crawler = $this->client->followRedirect();

//         $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
//         $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
//     }
// }
