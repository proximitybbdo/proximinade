Feature: Homepage
  In order to have a good starting point
  As a visitor
  I want to see the homepage for /

  Scenario: Visit the homepage
    Given I am on the devphp website "http://devphp.local/"
    When I browse to the homepage /
    Then the title should be "ProximityBBDOWebFramework"
