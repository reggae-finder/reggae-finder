Feature: Provide a JSON API for artists interactions

  In order to display artists
  As an API client
  I need to get artists collections and their details

  Background:
    Given there are artists with the following details:
      |name            |
      |John Holt       |
      |Freddy McGreggor|
      |Dennis Brown    |

    Scenario: Get details about an artist
      Given I request "/artist/1" using HTTP GET
      Then the response code is 200
      And the response body contains JSON:
      """
      {
        "name": "John Holt"
      }
      """

    Scenario: Get a collection of artists
      Given I request "/artist" using HTTP GET
      Then the response code is 200
      And the response body contains JSON:
      """
      [
        {
          "name": "John Holt"
        },
        {
          "name": "Freddy McGreggor"
        },
        {
          "name": "Dennis Brown"
        }
      ]
      """

