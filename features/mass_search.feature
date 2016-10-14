@api
Feature: Mass Search
  As a site visitor,
  I want to be able to search the site,
  so that I can find content related to my query.

  Background:
    Given I am an anonymous user
  Scenario: Verify users can access the search results route.
    And I am on "/search?q=snap"
    Then I should get a 200 HTTP response
