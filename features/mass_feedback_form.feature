@api

Feature: Mass Feedback Form
  As a content creator,
  I want anynomous users to be able to leave feedback on all pages,
  so that I can determine if the current content, layout, and design is optimal.

  Scenario: Verify Mass Feedback Form block exists.
    Given I am logged in as a user with the "administrator" role
    When I go to "admin/structure/block/library/mass_theme"
    Then I should see text matching "Mass Feedback Form"

#  This is waiting on a decision of what pattern lab regions will be available for blocks
#  Scenario: Verify Mass Feedback Form shows on pages other than the home.
#    Given default test content exists
#    When I visit the test "subtopic" "Behat Test: Nature & Outdoor Activities"
#    Then I should see text matching "Online Form - Feedback - Multi Page"
#    And I visit the test "topic" "Behat Test: State Parks & Recreation"
#    Then I should see text matching "Online Form - Feedback - Multi Page"
#    And I visit the test "section_landing" "Behat Test: Visiting & Exploring"
#    Then I should see text matching "Online Form - Feedback - Multi Page"

  Scenario: Verify Mass Feedback Form does not show on homepage
    Given I am an anonymous user
    When I am on the homepage
    Then I should not see text matching "Online Form - Feedback - Multi Page"


