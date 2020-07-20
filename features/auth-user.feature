Feature:
  In order to navigate on the application
  As an authenticated user
  I want to access to different pages

  @homepage
  Scenario: An authenicated user can access to homepage page
    Given I'm logged with ROLE_USER role
    Given I'm on "/" page
    Then the page should contain "Bienvenue sur Todo List, l'application vous permettant de gérer l'ensemble de vos tâches sans effort !"

  @add_task
  Scenario: An authenicated user create a new task
    Given I'm logged with ROLE_USER role
    Given I'm on "/" page
    When I click on link "Créer une nouvelle tâche"
    Then the page should contain "Title"
    Then I enter "Faire les courses" in the "Title" field
    Then I enter "café, sel, lait, pates" in the "Content" field
    When I click on button "Ajouter"
    Then the page should contain "Faire les courses"

  @edit_task
  Scenario: An authenicated user edit his own task
    Given I'm logged with ROLE_USER role
    Given I'm on "/tasks" page
    When I click on link "Faire les courses"
    Then the page should contain "Title"
    Then I enter "Faire les courses" in the "Title" field
    Then I enter "sel, poivre" in the "Content" field
    When I click on button "Modifier"
    Then the page should contain "Superbe ! La tâche a bien été modifiée. "

  @mark_task_done
  Scenario: An authenicated user marks his task done
    Given I'm logged with ROLE_USER role
    Given I'm on "/tasks" page
    When I click on button "Marquer comme faite"
    Then the page should contain "Superbe ! La tâche"

  @mark_task_todo
  Scenario: An authenicated user marks his task todo
    Given I'm logged with ROLE_USER role
    Given I'm on "/tasks" page
    When I click on button "Marquer non terminée"
    Then the page should contain "Superbe ! La tâche"

  @delete_task_fail
  Scenario: An authenicated user deletes his task
    Given I'm logged with ROLE_USER role
    Given I'm on "/tasks" page
    When I click on button "Supprimer"
    Then the page should contain "Supprimer"

  @logout
  Scenario: An authenicated user logs out
    Given I'm logged with ROLE_USER role
    Given I'm on "/tasks" page
    When I click on link "Se déconnecter"
    Then the page should contain "Nom d'utilisateur"