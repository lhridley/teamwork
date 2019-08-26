<?php

namespace Drupal\Tests\team_work\Functional;

/**
 * Test basic functionality of Team Work.
 *
 * @group team_work
 */
class TeamWorkBasicTestCase extends TeamWorkFunctionalTestBase {

  /**
   * Make sure everything works to this point.
   */
  public function testTheSiteLoads() {
    // Load the front page.
    $this->drupalGet('<front>');

    // Confirm that the site didn't throw a server error or something else.
    $this->assertSession()->statusCodeEquals(200);

  }

}
