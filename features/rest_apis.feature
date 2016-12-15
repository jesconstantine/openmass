@api
Feature: REST APIs
  As a MassIT developer or anonymous user,
  I want to be able to reach the available REST API endpoints.

  Scenario: Verify developer / anonymous user can get to the following APIs
    When I go to "/api/v1/content"
    When I go to "/api/v1/subtopics"
    When I go to "/api/v1/topics"
    When I go to "/api/v1/right-rail"
    Then the response status code should be 200
