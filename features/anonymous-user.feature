Feature:
  In order to navigate on the application
  As a anonymous user
  I want to access to different pages

  @login_page
  Scenario: A anonymous user can access to login page
    Given I'm on "http://localhost/p8-todolist/web/login" page
    Then the page should contain "Nom d'utilisateur"

  @register
  Scenario: A anonymous user register to the website
    Given I'm on "http://localhost/p8-todolist/web/users/create" page
    Then the page should contain "Créer un utilisateur"
    Then I enter "TestUsers" in the "Nom d'utilisateur" field
    Then I enter "123@456" in the "Mot de passe" field
    Then I enter "123@456" in the "Tapez le mot de passe à nouveau" field
    Then I enter "user@test.com" in the "Adresse email" field
    When I click on button "Ajouter"
    Then the page should contain "Superbe ! L'utilisateur a bien été ajouté."

  @register_fail
  Scenario: A anonymous user tries to register to the website and miss confirmation password
    Given I'm on "http://localhost/p8-todolist/web/users/create" page
    Then the page should contain "Créer un utilisateur"
    Then I enter "TestUsers" in the "Nom d'utilisateur" field
    Then I enter "123@456" in the "Mot de passe" field
    Then I enter "123@486" in the "Tapez le mot de passe à nouveau" field
    Then I enter "user@test.com" in the "Adresse email" field
    When I click on button "Ajouter"
    Then the page should contain "Les deux mots de passe doivent correspondre."

  @login
  Scenario: A anonymous user login to the website
    Given I'm on "http://localhost/p8-todolist/web" page
    Then I enter "TestUsers" in the "Nom d'utilisateur :" field
    Then I enter "123@456" in the "Mot de passe :" field
    When I click on button "Se connecter"
    Then the page should contain "Bienvenue sur Todo List, l'application vous permettant de gérer l'ensemble de vos tâches sans effort !"

  @login_fail
  Scenario: A anonymous user tries to login to the website and enter a wrong password
    Given I'm on "http://localhost/p8-todolist/web/login" page
    Then I enter "TestUsers" in the "Nom d'utilisateur :" field
    Then I enter "wrongpsw" in the "Mot de passe :" field
    When I click on button "Se connecter"
    Then the page should contain "Invalid credentials."

 @User_delete
  Scenario: Reset BDD User
    Given I delete Mirko user