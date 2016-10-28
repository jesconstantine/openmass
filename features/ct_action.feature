@api
Feature: Action Content type
  As a MassGov alpha content editor,
  I want to be able to add content for actions (a bedrock of the alpha release) for pre-determined journeys,
  so that I can help Bay Staters get the best information they need to fulfill basic tasks.

  Scenario: Verify that the action content type has the correct fields
    Given I am logged in as a user with the "administrator" role
    Then the content type "action" has the fields:
    | field                        | tag        | type                       | multivalue |
    | field-action-parent          | input      | text                       | true       |
    | field-lede                   | textarea   |                            | false      |
    | field-external-url           | input      | url                        | false      |
    | field-alert-dropdown         | select     |                            | false      |
    | field-alert-text             | textarea   |                            | false      |
    | field-alert-link             | input      | text                       | false      |
    | field-action-downloads       | input      | submit                     | false      |
    | field-action-details         | paragraphs | action-step                | false      |
    | field-action-details         | paragraphs | action-step-numbered-list  | false      |
    | field-action-details         | paragraphs | callout-link               | false      |
    | field-action-details         | paragraphs | file-download              | false      |
    | field-action-details         | paragraphs | iframe                     | false      |
    | field-action-details         | paragraphs | rich-text                  | false      |
    | field-action-details         | paragraphs | stat                       | false      |
    | field-action-details         | paragraphs | subhead                    | false      |
    | field-action-details         | paragraphs | map                        | false      |
    | field-contact-group          | paragraphs | contact-group              | false      |
    | field-action-sidebar         | paragraphs | contact-group              | false      |

  Scenario: Verify that pathauto patterns are applied to action nodes.
    Given I am viewing an "action" with the title "Run the Test Suite"
    Then I am at "actions/run-test-suite"
