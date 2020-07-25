<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{

    private $client;

    /**
     * Création client HTTP
     */
    public function setUp()
    {
        $this->client = static::createClient();
    }

    /**
     * Test d'affichage de la liste des utilisateurs par un administrateur ROLE_ADMIN
     */
    public function testListAsAdmin()
    {
        $crawler = $this->client->request('GET', '/login');
        $buttonCrawlerForm = $crawler->selectButton('Se connecter');
        $form = $buttonCrawlerForm->form();
        $this->client->submit($form, [
            '_username' => 'Mirko Venturi',
            '_password' => 'Mirko87'
        ]);
        $this->client->request('GET', '/users');
        static::assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Test d'affichage de la liste des utilisateurs par un utilisateur ROLE_USER
     */
    public function testListAsUser()
    {
        $crawler = $this->client->request('GET', '/login');
        $buttonCrawlerForm = $crawler->selectButton('Se connecter');
        $form = $buttonCrawlerForm->form();
        $this->client->submit($form, [
            '_username' => 'User Test',
            '_password' => 'user'
        ]);
        $this->client->request('GET', '/users');
        static::assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Test d'affichage de la page d'ajout d'un utilisateur par un administrateur ROLE_ADMIN
     */
    public function testCreateActionAsAdmin()
    {
        $crawler = $this->client->request('GET', '/login');
        $buttonCrawlerForm = $crawler->selectButton('Se connecter');
        $form = $buttonCrawlerForm->form();
        $this->client->submit($form, [
            '_username' => 'Mirko Venturi',
            '_password' => 'Mirko87'
        ]);
        $this->client->request('GET', '/users/create');
        static::assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Test d'affichage de la page d'ajout d'un utilisateur par un utilisateur ROLE_USER
     */
    public function testCreateActionAsUser()
    {
        $crawler = $this->client->request('GET', '/login');
        $buttonCrawlerForm = $crawler->selectButton('Se connecter');
        $form = $buttonCrawlerForm->form();
        $this->client->submit($form, [
            '_username' => 'user',
            '_password' => 'user'
        ]);
        $this->client->request('GET', '/users/create');
        static::assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Test d'ajout d'un utilisateur par un administrateur ROLE_AMIN
     */
    public function testCreateAction()
    {
        $crawler = $this->client->request('GET', '/login');
        $buttonCrawlerForm = $crawler->selectButton('Se connecter');
        $form = $buttonCrawlerForm->form();
        $this->client->submit($form, [
            '_username' => 'Mirko Venturi',
            '_password' => 'Mirko87'
        ]);
        $crawler = $this->client->request('GET', '/users/create');
        $buttonCrawlerAddUser = $crawler->selectButton('Ajouter');
        $formUser = $buttonCrawlerAddUser->form();
        $this->client->submit($formUser, [
            'user[username]' => 'username'.rand(0, 10000),
            'user[password][first]' => 'password',
            'user[password][second]' => 'password',
            'user[email]' => rand(0, 10000).'email@gmail.com',
        ]);
        static::assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Test de modification d'un utilisateur par un administrateur ROLE_ADMIN
     */
    public function testEditUserByAdmin()
    {
        $crawler = $this->client->request('GET', '/login');
        $buttonCrawlerForm = $crawler->selectButton('Se connecter');
        $form = $buttonCrawlerForm->form();
        $this->client->submit($form, [
            '_username' => 'Mirko Venturi',
            '_password' => 'Mirko87'
        ]);
        $crawler = $this->client->request('GET', '/users/42/edit');
        static::assertEquals(200, $this->client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Modifier')->form();
        $form['user[username]'] = 'user';
        $form['user[password][first]'] = 'userpassword';
        $form['user[password][second]'] = 'userpassword';
        $form['user[email]'] = 'test@test.com';
        $this->client->submit($form);
        $crawler = $this->client->followRedirect();
        $this->assertSame(1, $crawler->filter('div.alert.alert-success:contains("modifié")')->count());
    }

    /**
     * Test de suppression d'un utilisateur par un user ROLE_ADMIN
     */
    public function testDeleteUserAction(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $buttonCrawlerForm = $crawler->selectButton('Se connecter');
        $form = $buttonCrawlerForm->form();
        $this->client->submit($form, [
            '_username' => 'Mirko Venturi',
            '_password' => 'Mirko87'
        ]);
        
        $this->client->request('GET', '/users/32/delete');

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
    }

    public function tearDown()
    {
        $this->client = null;
    }
}
