@api
Feature: Interstitial Content type
  As a MassGov alpha content editor,
  I want to be able to add content for interstitial page.

  Scenario: Verify that the action content type has the correct fields
    Given I am logged in as a user with the "administrator" role
    Then the content type "interstitial" has the fields:
    | field                           | tag        | type        | multivalue | required |
    | field-message                   | textarea   | text        | false      | true     |
    | field-interstitial-checkbox-msg | input      | text        | false      | true     |

  Scenario: Verify that pathauto patterns are applied to interstitial nodes.
    Given I am viewing an "interstitial" content with the title "Run the Test Suite"
    Then I am on "run-test-suite"

  Scenario: Verify that these roles cannot create error page content
    Given I am logged in as a user with the "content_team" role
    Given I am logged in as a user with the "content_user" role
    Given I am logged in as a user with the "content_editor" role
    When I go to "node/add/interstitial"
    Then the response status code should be 403

  Scenario: Verify Administrator can create interstitial page content
    Given I am logged in as a user with the "administrator" role
    When I go to "node/add/interstitial"
    Then the response status code should be 200
