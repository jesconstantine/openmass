@api
Feature: Content Management
  As a content team member,
  I want a role to be able to create / edit / delete all content
  so I can create the best content experience for the constituents of Massachusetts.

  Scenario: Verify that content team member can only see content menu item
    Given I am logged in as a user with the "content_team" role
    And I am on "admin/content"
    Then I should see the link "Content"
    And I should not see the link "Structure"
    And I should not see the link "Appearance"
    And I should not see the link "Extend"
    And I should not see the link "Configuration"
    And I should not see the link "People"
    And I should not see the link "Reports"
    And I should not see the link "Help"

  Scenario: Verify that content team user can see 'Add content' button
    Given I am logged in as a user with the "content_team" role
    And I am on "admin/content"
    Then I should see the link "Add content"

  #http response 200 is a successful response
  Scenario: Verify content team user can create action content
    Given I am logged in as a user with the "content_team" role
    When I go to "node/add/action"
    Then the response status code should be 200

  Scenario: Verify content team user can create agency content
    Given I am logged in as a user with the "content_team" role
    When I go to "node/add/agency"
    Then the response status code should be 200

  Scenario: Verify content team user can create basic page content
    Given I am logged in as a user with the "content_team" role
    When I go to "node/add/page"
    Then the response status code should be 200

  Scenario: Verify content team user can create section landing content
    Given I am logged in as a user with the "content_team" role
    When I go to "node/add/section_landing"
    Then the response status code should be 200

  Scenario: Verify content team user can create subtopic content
    Given I am logged in as a user with the "content_team" role
    When I go to "node/add/subtopic"
    Then the response status code should be 200

  Scenario: Verify content team user can create topic content
    Given I am logged in as a user with the "content_team" role
    When I go to "node/add/topic"
    Then the response status code should be 200


