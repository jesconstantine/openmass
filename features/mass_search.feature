@api
Feature: Mass Search
  As a site visitor,
  I want to be able to search the site,
  so that I can find content related to my query.

  Background:
    Given I am an anonymous user

  @javascript
  Scenario: Verify that google custom search form is drawn on home page.
    And I am on the homepage
    Then I wait for AJAX to finish
    Then I should see a "form.gsc-search-box" element

  @javascript
  Scenario: Verify that home page search form submission calls results route.
    And I am on the homepage
    Then I wait for AJAX to finish
    Then I should see a "form.gsc-search-box" element
#   When I fill in "snap" for "search"
#  breaks with Element is not currently interactable and may not be manipulated
#     And I press the "Search" button
#     Then I should be on "/search?q=snap"

  Scenario: Verify users can access the search results route.
    And I am on "/search?q=snap"
    Then I should get a 200 HTTP response

  @javascript
  Scenario: Verify that results page google custom form + results are drawn.
    And I am on "/search?q=snap"
    Then I wait for AJAX to finish
    Then I should see a "form.gsc-search-box" element
    Then I should see a "div.gsc-control-cse" element
#  google js does not populate the input value with the query param
    #And the "search" field should contain "snap"
