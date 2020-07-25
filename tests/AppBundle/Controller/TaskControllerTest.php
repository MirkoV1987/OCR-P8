<?php

namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    private $client;

    protected function setUp(): void
    {
        $this->client = self::createClient();
    }

    public function loginWithAdmin(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form();
        $this->client->submit($form, ['username' => 'Mirko Venturi', 'password' => 'Mirko87']);
    }

    public function loginWithUser(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form();
        $this->client->submit($form, ['username' => 'user', 'password' => 'root']);
    }

    public function testListAction(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $buttonCrawlerForm = $crawler->selectButton('Se connecter');
        $form = $buttonCrawlerForm->form();
        $this->client->submit($form, [
            '_username' => 'Mirko Venturi',
            '_password' => 'Mirko87'
        ]);
        $this->client->request('GET', '/tasks');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testListDoneAction(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $buttonCrawlerForm = $crawler->selectButton('Se connecter');
        $form = $buttonCrawlerForm->form();
        $this->client->submit($form, [
            '_username' => 'Mirko Venturi',
            '_password' => 'Mirko87'
        ]);
        $this->client->request('GET', '/tasksdone');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testCreateAction(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $buttonCrawlerForm = $crawler->selectButton('Se connecter');
        $form = $buttonCrawlerForm->form();
        $this->client->submit($form, [
            '_username' => 'Mirko Venturi',
            '_password' => 'Mirko87'
        ]);
        $crawler = $this->client->request('GET', '/tasks/todo');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->assertSame('Titre', $crawler->filter('label[for="task_title"]')->text());
        $this->assertEquals(1, $crawler->filter('input[name="task[title]"]')->count());
        $this->assertSame('Contenu', $crawler->filter('label[for="task_content"]')->text());
        $this->assertEquals(1, $crawler->filter('textarea[name="task[content]"]')->count());

        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = 'Test Super titre de tache';
        $form['task[content]'] = 'Test Contenu de la supertache blablabla.';
        $this->client->submit($form);

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());

    }

    public function testEditAction(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $buttonCrawlerForm = $crawler->selectButton('Se connecter');
        $form = $buttonCrawlerForm->form();
        $this->client->submit($form, [
            '_username' => 'Mirko Venturi',
            '_password' => 'Mirko87'
        ]);
        $crawler = $this->client->request('GET', '/tasks/27/edit');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->assertSame('Titre', $crawler->filter('label[for="task_title"]')->text());
        $this->assertEquals(1, $crawler->filter('input[name="task[title]"]')->count());
        $this->assertSame('Contenu', $crawler->filter('label[for="task_content"]')->text());
        $this->assertEquals(1, $crawler->filter('textarea[name="task[content]"]')->count());

        $form = $crawler->selectButton('Modifier')->form();
        $form['task[title]'] = 'Test modification du Super titre de tache';
        $form['task[content]'] = 'Test modification du contenu de la supertache blablabla.';
        $this->client->submit($form);

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());

    }

    public function testToggleTaskAction(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $buttonCrawlerForm = $crawler->selectButton('Se connecter');
        $form = $buttonCrawlerForm->form();
        $this->client->submit($form, [
            '_username' => 'Mirko Venturi',
            '_password' => 'Mirko87'
        ]);
        $this->client->request('GET', '/tasks/17/toggle');

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());

    }

    public function testDeleteTaskAction(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $buttonCrawlerForm = $crawler->selectButton('Se connecter');
        $form = $buttonCrawlerForm->form();
        $this->client->submit($form, [
            '_username' => 'Mirko Venturi',
            '_password' => 'Mirko87'
        ]);
        $this->client->request('GET', '/tasks/105/delete');

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());

    }

    public function tearDown(): void
    {
        $this->client = null;
        $crawler = null;
        $form = null;
    }
}
