@api
Feature: Action Content type
  As a MassGov alpha content editor,
  I want to be able to add content for actions (a bedrock of the alpha release) for pre-determined journeys,
  so that I can help Bay Staters get the best information they need to fulfill basic tasks.

  Scenario: Verify that the action content type has the correct fields
    Given I am logged in as a user with the "administrator" role
    Then the content type "action" has the fields:
    | field                            | tag      | type     | multivalue |
    | field-action-parent              | input    | text     | false      |
    | field-lede                       | textarea |          | false      |
    | field-hero-image                 | input    | submit   | false      |
    | field-action-related             | input    | text     | true       |
    # the downloads field is multivalue but has no good way of testing for it.
    | field-action-downloads           | input    | submit   | false      |

    Given I am viewing an "action" with the title "Run the Test Suite"
    Then I am at "actions/run-test-suite"