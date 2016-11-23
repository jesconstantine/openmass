@api
Feature: Content Management
  As a security minded individual,
  I want a developer role to do everything an admin can do except: manage users, themes, modules, and update the site
  so I can have granular roles and permissions.

  #http response 403 is access denied
  Scenario: Verify developer user cannot add modules
    Given I am logged in as a user with the "developer" role
    When I go to "admin/modules"
    Then the response status code should be 403

  Scenario: Verify developer user cannot change the theme
    Given I am logged in as a user with the "developer" role
    When I go to "admin/appearance"
    Then the response status code should be 403

  Scenario: Verify developer user cannot create / edit / delete users
    Given I am logged in as a user with the "developer" role
    When I go to "admin/people"
    Then the response status code should be 403

  Scenario: Verify developer user cannot run update.php
    Given I am logged in as a user with the "developer" role
    When I go to "/update.php"
    Then the response status code should be 403

  Scenario: Verify that developer user does not have permission to change site code or administer users
    Given I am logged in as a user with the "developer" role
    Then I should not have the "administer modules, administer software updates, administer themes, administer users" permissions

  Scenario: Verify that developer user can administer security settings and checks
    Given I am logged in as a user with the "developer" role
    Then I should have the "access security review list, run security checks, administer restrict by ip, administer seckit" permissions
