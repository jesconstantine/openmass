@api
Feature: Section Landing Content type
  As a MassIT content editor
  I want to update the text and imagery on section landing pages
  So that they the pages stay relevant and accurate.

  Scenario: Verify that the section landing content type has the correct fields
    Given I am logged in as a user with the "Administrator" role
    Then the content type "section_landing" has the fields:
      | field                            | tag      | type     | multivalue |
      | field-featured-image             | input    | submit   | false      |
      | field-image-credit               | input    | text     | true       |
      | field-icon-term                  | select   |          | false      |
    And "section_landing" content can appear in the "main" menu

  Scenario: Verify that pathauto patterns are applied to section landing nodes.
    Given "icons" terms:
      | name                 | field_sprite_name |
      | Behat Test: Building | building          |
    And I am viewing a "section_landing" content:
      | title           | Behat Test: Section Landing |
      | field_icon_term | Behat Test: Building        |
    Then I am at "behat-test-section-landing"

  Scenario: The page banner has correct markup.
    Given "icons" terms:
      | name                 | field_sprite_name |
      | Behat Test: Building | building          |
    And I am viewing a "section_landing" content:
      | title           | Behat Test: Section Landing |
      | field_icon_term | Behat Test: Building        |
    Then I should see the correct markup for the page banner

  Scenario: Verify custom ordered topics.
    Given I am logged in as a user with the "administrator" role
    And "icons" terms:
      | name                 | field_sprite_name |
      | Behat Test: Building | building          |
    And I am viewing a "section_landing" content:
      | title           | Behat Test: Section Landing |
      | field_icon_term | Behat Test: Building        |
    Then I should see the link "Reorder Topics"

  Scenario: Verify that section links are present with correct markup.
    Given default test content exists
    When I visit the test "section_landing" "Behat Test: Working"
    Then I should see the correct markup for the section links
