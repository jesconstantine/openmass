@api
Feature: REST APIs
  As a MassIT developer or anonymous user,
  I want to be able to reach the available REST exports.

  Scenario: Verify anonymous user can get to the content REST export
    When I go to "/api/v1/content"
    Then the response status code should be 200

  Scenario: Verify anonymous user can get to the topics REST export
    When I go to "/api/v1/topics"
    Then the response status code should be 200

  Scenario: Verify anonymous user can get to the subtopics REST export
    When I go to "/api/v1/subtopics"
    Then the response status code should be 200

  Scenario: Verify anonymous user can get to the right-rail REST export
    When I go to "/api/v1/right-rail"
    Then the response status code should be 200

  Scenario: Verify anonymous user can get to the content-types REST export
    When I go to "/api/v1/content-types"
    Then the response status code should be 200
