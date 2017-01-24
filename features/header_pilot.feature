@api
Feature: Pilot Header
  As a site visitor,
  I want access to a header that has a logo and a menu with dropdowns,
  so that I can navigate the pilot site.

  Scenario: Verify users can navigate the pilot site.
    Given I am an anonymous user
    And I am on the homepage
    Then the "header" region contains the following links:

    | link                    |
    | Go to classic Mass.gov  |

  Scenario: Verify the header markup is correct
    Given I am an anonymous user
    And I am on the homepage
    Then I should see the correct markup for the header
    
