@api
Feature: Emergency Alert Content type
  As an alert manager,
  I want to be able to author citizen alerts for the public
  So the public can be warned about current or pending emergencies.

  Scenario: Verify that the emergency alert content type has the correct fields
    Given I am logged in as a user with the "administrator" role
    Then the content type "emergency_alerts" has the fields:
    | field         | tag        | type            | multivalue |
    | field-alert   | paragraphs | emergency-alert | false      |

  Scenario: Verify that these roles cannot create error page content
    Given I am logged in as a user with the "content_team" role
    Given I am logged in as a user with the "content_user" role
    Given I am logged in as a user with the "content_editor" role
    When I go to "node/add/emergency_alerts"
    Then the response status code should be 403

  Scenario: Verify Emergency Alert Publisher can create error page content
    Given I am logged in as a user with the "emergency_alert_publisher" role
    When I go to "node/add/emergency_alerts"
    Then the response status code should be 200

  Scenario: Verify Administrator can create error page content
    Given I am logged in as a user with the "administrator" role
    When I go to "node/add/emergency_alerts"
    Then the response status code should be 200
