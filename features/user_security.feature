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

  Scenario: Verify anonymous_user cannot create content of these types
    When I go to "node/add/1up_stacked_band"
    When I go to "node/add/2up_stacked_band"
    When I go to "node/add/action"
    When I go to "node/add/agency"
    When I go to "node/add/emergency_alerts"
    When I go to "node/add/error_page"
    When I go to "node/add/interstitial"
    When I go to "node/add/page"
    When I go to "node/add/section_landing"
    When I go to "node/add/stacked_layout"
    When I go to "node/add/subtopic"
    When I go to "node/add/topic"
    Then the response status code should be 403
