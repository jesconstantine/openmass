@api
Feature: Topic Content type
  As a MassGov content editor,
  I want to be able to add content for topics,
  so that I can help Bay Staters get the best information they need to fulfill basic tasks.

  Scenario: Verify that the topic content type has the correct fields
    Given I am logged in as a user with the "administrator" role
    Then the content type "topic" has the fields:
    | field                  | tag      | type   | multivalue |  required |
    | field-featured-image   | input    | submit | false      |  false     |
    # Required. Hero image; use file browser modal widget. Due to widget, cannot check required status.
    | field-lede             | textarea |        | false      |  false    |
    | field-node-icon        | select   |        | false      |  true     |
    # Required. Provide machine names for each of the SVG icons from the styleguide.
    | field-section          | select   |        | false      |  true     |
    # Required. Entity ref to section content. Use a select widget, single value.
    | field-common-content   | input    |  text  | false      |  false    |
    # # Optional. Allows 4 items. Autocomplete entity ref to actions. Autocomplete should be limited to actions that reference subtopics that reference this topic.

  Scenario: Verify that pathauto patterns are applied to topic nodes.
    Given I am viewing a "topic" with the title "Run the Test Suite"
    Then I am at "topics/run-test-suite"
