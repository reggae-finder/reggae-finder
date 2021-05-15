Feature: Make sur the API is alive

  In order to verify the API status
  As an API client
  I need a succresponse

  Scenario: Basic API healthcheck
    Given I request "/ping" using HTTP GET
    Then the response code is 200
    And the response body is:
    """
    "pong"
    """
