Feature: Log debug information
  In orde to follow application flow
  Developers should be able to
  log their objects and strings to the console
  rather then var_dump-ing it and messing up output

  Scenario: log a string
    Given I visit any page
    When I _log "test"
    Then the console should contain "test"
