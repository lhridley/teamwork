<?php

namespace Drupal\Tests\team_work\Functional;

use Drupal\taxonomy\Entity\Vocabulary;

/**
 * Test that proper vocabularies exist.
 *
 * @group team_work
 */
class TeamWorkVocabulariesTestCase extends TeamWorkFunctionalTestBase {

  /**
   * Make sure everything works to this point.
   */
  public function testVocabulariesArePresent() {
    // Get list of vocabularies on the site.
    $vocabularies = Vocabulary::loadMultiple();

    // Checks that there are 7 vocabularies.
    $this->assertCount(7, $vocabularies);

    // Checks for the existence of the correct vocabularies.
    $vocabulary_ids = array_keys($vocabularies);

    $this->assertTrue(in_array('issue_priority', $vocabulary_ids));
    $this->assertTrue(in_array('issue_status', $vocabulary_ids));
    $this->assertTrue(in_array('issue_type', $vocabulary_ids));
    $this->assertTrue(in_array('linked_issue_status', $vocabulary_ids));
    $this->assertTrue(in_array('project_keys', $vocabulary_ids));
    $this->assertTrue(in_array('sprint', $vocabulary_ids));
    $this->assertTrue(in_array('team_roles', $vocabulary_ids));
  }

}
