@api
Feature: Section Landing Content type
  As a MassIT content editor
  I want to update the text and imagery on section landing pages
  So that they the pages stay relevant and accurate.

  Scenario: Verify that the section landing content type has the correct fields
    Given I am logged in as a user with the "administrator" role
    Then the content type "section_landing" has the fields:
      | field                            | tag      | type     | multivalue |
      | field-featured-image             | input    | submit   | false      |
      | field-icon                       | select   |          | false      |
    And "section_landing" content can appear in the "main" menu

  Scenario: Verify that pathauto patterns are applied to section landing nodes.
    Given I am viewing an "section_landing" with the title "Behat Test: Section Landing"
    Then I am at "behat-test-section-landing"

  Scenario: The page banner has correct markup.
    Given I am viewing a "section_landing" with the title "Behat Test: Section Landing"
    Then I should see the correct markup for the page banner

  Scenario: Verify the section links markup is correct
    Given default test content exists
    When I visit the test "section_landing" "Behat Test: Visiting & Exploring"
    Then I should see the correct markup for the section links
