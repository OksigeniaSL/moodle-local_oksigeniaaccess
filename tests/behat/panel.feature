@local @local_oksigeniaaccess
Feature: Accessibility panel on Moodle pages
  In order to adapt how Moodle looks and reads to my needs
  As a visitor or a student
  I need the accessibility panel on the pages I use

  Background:
    Given the following "users" exist:
      | username | firstname | lastname | email                |
      | student1 | Student   | One      | student1@example.com |
    And the following "courses" exist:
      | fullname | shortname |
      | Course 1 | C1        |
    And the following "course enrolments" exist:
      | user     | course | role    |
      | student1 | C1     | student |

  Scenario: A visitor who is not logged in gets the panel on the front page
    Given the following config values are set as admin:
      | enabled | 1 | local_oksigeniaaccess |
    When I am on site homepage
    Then "oksigenia-access-panel" "css_element" should exist

  Scenario: A student gets the panel inside a course
    Given the following config values are set as admin:
      | enabled | 1 | local_oksigeniaaccess |
    When I am on the "C1" "Course" page logged in as "student1"
    Then "oksigenia-access-panel" "css_element" should exist

  Scenario: The panel is gone when the plugin is disabled
    Given the following config values are set as admin:
      | enabled | 0 | local_oksigeniaaccess |
    When I am on the "C1" "Course" page logged in as "student1"
    Then "oksigenia-access-panel" "css_element" should not exist
    And I am on site homepage
    And "oksigenia-access-panel" "css_element" should not exist

  @javascript
  Scenario: The panel loads in a real browser
    Given the following config values are set as admin:
      | enabled | 1 | local_oksigeniaaccess |
    When I am on the "C1" "Course" page logged in as "student1"
    Then "oksigenia-access-panel" "css_element" should exist
