<?php

// use Behat\Behat\Tester\Exception\PendingException;
use Behat\MinkExtension\Context\MinkContext;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext
{
    /**
     * @Given  I delete Mirko user
     */
    public function deleteUser()
    {
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=db_todolist;charset=utf8', 'root');
        } catch (Exception $e) {
            echo 'Erreur : '.$e->getMessage();
        }

        $user = $pdo->prepare("SELECT 1 FROM user WHERE username=?");
        $user->execute(['Mirko']);
        $user->fetchColumn();

        if ($user) {
            $pdo->exec('DELETE FROM user WHERE username = "Mirko"');
        }
    }

    /**
     * @Given I'm on :path page
     */
    public function aUserSendsARequestTo(string $path)
    {
        $this->visit($path);
    }

    /**
     * @Then the page should contain :words
     */
    public function thePageShouldContain($words)
    {
        $this->assertPageContainsText($words);
    }

    /**
     * @Then I enter :entry in the :fieldname field
     */
    public function fillTheForm($entry, $fieldname)
    {
        $this->fillField($fieldname, $entry);
    }

    /**
     * @When I click on button :buttonname
     */
    public function clickOnButton($buttonname)
    {
        $this->pressButton($buttonname);
    }

    /**
     * @When I click on link :linkid
     */
    public function clickOnLink($linkid)
    {
        $this->clickLink($linkid);
    }

    /**
     * @Given I'm logged with ADMIN role
     */
    public function loggedInAsAdmin()
    {
        $this->visit('/login');
        $this->fillField("Nom d'utilisateur :", 'Admin');
        $this->fillField('Mot de passe :', 'Codesecret');
        $this->pressButton('Se connecter');
        $this->assertPageContainsText('Bienvenue sur Todo List');
    }

    /**
     * @Given I'm logged with USER role
     */
    public function loggedInAsUser()
    {
        $this->visit('/login');
        $this->fillField("Nom d'utilisateur :", 'Mirko');
        $this->fillField('Mot de passe :', 'Mysecretecode');
        $this->pressButton('Se connecter');
        $this->assertPageContainsText('Bienvenue sur Todo List');
    }
}
