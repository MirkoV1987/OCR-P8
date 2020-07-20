Feature:
  In order to navigate on the application
  As a anonymous user
  I want to access to different pages

  @login_page
  Scenario: A anonymous user can access to login page
    Given I'm on "/login" page
    Then the page should contain "Nom d'utilisateur"

  @login
  Scenario: A anonymous user login to the website
    Given I'm on "/login" page
    Then I enter "TestUsers" in the "Nom d'utilisateur :" field
    Then I enter "123@456" in the "Mot de passe :" field
    When I click on button "Se connecter"
    Then the page should contain "Bienvenue sur Todo List, l'application vous permettant de gérer l'ensemble de vos tâches sans effort !"

  @login_fail
  Scenario: A anonymous user tries to login to the website and enter a wrong password
    Given I'm on "/login" page
    Then I enter "TestUsers" in the "Nom d'utilisateur :" field
    Then I enter "wrongpsw" in the "Mot de passe :" field
    When I click on button "Se connecter"
    Then the page should contain "Invalid credentials."

 @User_delete
  Scenario: Reset BDD User
    Given I delete Mirko user