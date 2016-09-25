@api
Feature: Subtopic page display
  As a visitor
  I want to see all the action links related to a subtopic
  So that I can do something.

  # Scenario: Correct data structures on page
  # Given test subtopics exist
  # And test actions exist
  # And I am viewing an "subtopic" with the title "Behat Test - Nature & Outdoor Activities"
  # # Then I see the subtopic page markup
  # And I see the heading "Behat Test - Nature & Outdoor Activities"
  # And I see the text "Outdoor Lede"
  # And I see the link "Find a State Park" in the "Featured What would you like to do?" region
  # And I see the link "Get a State Park Pass" in the "All Actions & Guides, What Would You Like to Do?" region
  # And I won't see the link "Find a State Park" in the "All Actions & Guides, What Would You Like to Do?" region
  # And I see the background "test.png" on the "What Would You Like to Do?" region
  # And I see the link "MassParks"
  # And I see the link "Department of Fish and Game"

  Scenario: Section Pages
  Given default test content exists
  # And I am viewing a "section_landing" with the title "Behat Test - Vising & Exploring"
  Then I break
