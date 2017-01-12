@api
Feature: Emergency Alert Content type
  As an alert manager,
  I want to be able to author citizen alerts for the public
  So the public can be warned about current or pending emergencies.

  Scenario: Verify that the emergency alert content type has the correct fields
    Given I am logged in as a user with the "administrator" role
    Then the content type "emergency_alerts" has the fields:
    | field                | tag        | type            | multivalue |
    | field-alert          | paragraphs | emergency-alert | false      |
    | field-action-sidebar | paragraphs | callout-link    | false      |
    | field-action-sidebar | paragraphs | contact-group   | false      |
    | field-action-sidebar | paragraphs | icon-links      | false      |
    | field-action-sidebar | paragraphs | iframe          | false      |
    | field-action-sidebar | paragraphs | quick-action    | false      |
    | field-action-sidebar | paragraphs | related-link    | false      |
    | field-action-sidebar | paragraphs | subhead         | false      |
    | field-action-sidebar | paragraphs | video           | false      |

  Scenario: Verify that these roles cannot create emergency alerts content
    Given I am logged in as a user with the "content_team" role
    When I go to "node/add/emergency_alerts"
    Then the response status code should be 403

  Scenario: Verify Emergency Alert Publisher can create emergency alerts content
    Given I am logged in as a user with the "emergency_alert_publisher" role
    When I go to "node/add/emergency_alerts"
    Then the response status code should be 200

  Scenario: Verify Emergency Alert Landing Page can render
    When I go to "alerts"
    Then the response status code should be 200
