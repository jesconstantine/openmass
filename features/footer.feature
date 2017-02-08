@api
Feature: Site Footer
  As a site visitor,
  I want access to a footer that has a logo, copyright, and a three link sections,
  so that I can navigate the pilot site.

  Scenario: Verify the footer markup is correct
    Given I am an anonymous user
    And I am on "node/3461"
    Then I should see the correct markup for the footer
