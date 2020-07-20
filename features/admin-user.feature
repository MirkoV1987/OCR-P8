Feature:
  In order to manage users
  As an authenticated admin user
  I want to access to different pages

  @users_list
  Scenario: An authenicated admin user can access to users page
    Given I'm logged with ROLE_ADMIN role
    Given I'm on "/" page
    When I click on link "Liste des utilisateurs"
    Then the page should contain "LISTE DES UTILISATEURS"

  @users_list_fail
  Scenario: An authenicated user wants to access to users page with as a user
    Given I'm logged with ROLE_USER role
    Given I'm on "/users" page
    Then the page should contain "Access Denied"
  
  @users_edit
  Scenario: An authenicated admin user edit a user
    Given I'm logged with ROLE_ADMIN role
    Given I'm on "/users" page
    When I click on link "Modifier"
    Then I enter "admin" in the "Mot de passe" field
    Then I enter "admin" in the "Tapez le mot de passe à nouveau" field
    When I click on button "Modifier"
    Then the page should contain "Superbe ! L'utilisateur a bien été modifié"

  @users_edit_fail
  Scenario: An authenicated admin user edits a user but enters differents passwords
    Given I'm logged with ROLE_ADMIN role
    Given I'm on "/users" page
    When I click on link "Modifier"
    Then I enter "Mon mot de passe" in the "Mot de passe" field
    Then I enter "Mon mot de passeLLL" in the "Tapez le mot de passe à nouveau" field
    When I click on button "Modifier"
    Then the page should contain "Les deux mots de passe doivent correspondre"