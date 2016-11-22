@api
Feature: User Security
  As a MassGov manager,
  I want to ensure that the website has secure login,
  so that the website is less likely to be hacked or brought down.

  Scenario: Verify that user names cannot be discovered with password reset messages.
    Given I am an anonymous user
    And I am on "/user/password"
    When I fill in "name" with "foobar test xyz"
    And I press "Submit"
    Then I should see "Further instructions have been sent to your e-mail address"
