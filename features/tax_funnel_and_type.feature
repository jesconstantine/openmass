@api
Feature: Funnel and Type taxonomies
  As a MassIT site editor and administrator,
  I want easy access to information about my Right Rail and Stacked Content Types,
  so I can surface that information later and sort by it possibly.

  Scenario: Verify that the vocabularies exist
    Given I am logged in as a user with the "administrator" role
    When I am at "admin/structure/taxonomy"
    Then I should see "Vocabulary name"
    And I should see "Funnel or Endpoint"
    And I should see "Type"

  Scenario: Verify Meta Info tab is in Right Rail content type
    Given I am logged in as a user with the "administrator" role
    When I go to "node/add/action"
    Then I should see "Meta Info"
    And I should see "Funnel or Endpoint"
    And I should see "Type"

  Scenario: Verify Meta Info tab is in Stacked Layout content type
    Given I am logged in as a user with the "administrator" role
    When I go to "node/add/stacked_layout"
    Then I should see "Meta Info"
    And I should see "Funnel or Endpoint"
    And I should see "Type"
