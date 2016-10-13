@api
Feature: Mass Search
  As a site visitor,
  I want to be able to search the site,
  so that I can find content related to my query.

  Scenario: Verify users can access the search page.
    Given I am an anonymous user
    And I am on "/search"
    Then I should get a 200 HTTP response
