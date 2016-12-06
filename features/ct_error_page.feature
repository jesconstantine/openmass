@api
Feature: Error Page Content type
  As a MassGov alpha content editor,
  I want to be able to add content for error page.

  Scenario: Verify that the error page content type has the correct fields
    Given I am logged in as a user with the "administrator" role
    Then the content type "error_page" has the fields:
    | field                   | tag        | type          | multivalue | required |
    | field-error-code        | input      | text          | false      | false    |
    | field-error-label       | input      | text          | false      | true     |
    | field-error-title       | input      | text          | false      | true     |
    | field-error-message     | textarea   | text          | false      | true     |
    | field-include-search    | input      | checkbox      | false      | false    |
    | field-helpful-links     | input      | text          | true       | false    |

  Scenario: Verify that pathauto patterns are applied to error page nodes.
    Given I am viewing an "error_page" content with the title "Run the Test Suite"
    Then I am on "run-test-suite"

  Scenario: Verify Developer role/user can create error page content
    Given I am logged in as a user with the "content_team" role
    Given I am logged in as a user with the "content_user" role
    Given I am logged in as a user with the "content_editor" role
    When I go to "node/add/error_page"
    Then the response status code should be 403

  Scenario: Verify Developer role/user can create error page content
    Given I am logged in as a user with the "administrator" role
    Given I am logged in as a user with the "developer" role
    When I go to "node/add/error_page"
    Then the response status code should be 200

 Scenario: Verify anonymous_user cannot create error_page
    When I go to "node/add/error_page"
    Then the response status code should be 403
