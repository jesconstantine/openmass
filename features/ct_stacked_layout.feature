@api
Feature: Stacked Layout Content type
  As a MassIT editor,
  I want to create a page with banded content in a prototyping tool,
  so I can test how banded content can and should be used. This can used to start prototyping guides, for example.


  Scenario: Verify that the Stacked Layout content type has the correct fields
    Given I am logged in as a user with the "administrator" role
    Then the content type "stacked_layout" has the fields:
    | field                 | tag        | type         | multivalue |
    | field-related-content | input      | text         | true       |
    | field-lede            | textarea   |              | false      |
    | field-label           | input      | text         | false      |
    | field-photo           | input      | submit       | false      |
    | field-bands           | paragraphs | stacked-band | false      |


  Scenario: The stacked layout has correct markup.
    Given "stacked_layout" content:
      | title                              |
      | Behat Test: Related stacked layout |
    And I am viewing a "stacked_layout" content:
      | title                 | Behat Test: Stacked layout  |
      | field_lede            | Lede: lorem ipsum           |
      | field_related_content | Behat Test: Related stacked layout |
    Then I should see the correct markup for the illustrated header
    And I should see the correct markup for the related guides
