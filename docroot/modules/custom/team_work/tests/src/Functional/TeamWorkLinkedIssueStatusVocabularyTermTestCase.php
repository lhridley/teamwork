<?php

namespace Drupal\Tests\team_work\Functional;

/**
 * Test the Linked Issue Status Vocabulary.
 *
 * @group team_work
 */
class TeamWorkLinkedIssueStatusVocabularyTermTestCase extends TeamWorkFunctionalTestBase {

  /**
   * Stores a list of terms, keyed by term ID.
   *
   * @var array
   */
  public $terms;

  /**
   * Vocabulary ID to check.
   *
   * @var string
   */
  public $vid;

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    // Make sure to complete the normal setup steps first.
    parent::setUp();

    $this->vid = 'linked_issue_status';

    $terms = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree($this->vid,0,NULL,TRUE);

    foreach ($terms as $term) {
      $this->terms[$term->id()] = $term->getName();
    }

  }

  /**
   * Make sure everything works to this point.
   */
  public function testTermsArePresent() {
    // Load the front page.
    $terms = array_values($this->terms);

    // Check that Linked Issue Status Vocabulary has 5 terms.
    $this->assertCount(4, $terms);

    // Check that Linked Issue Status Vocabulary has the correct terms.
    $this->assertTrue(in_array('Blocked by', $terms));
    $this->assertTrue(in_array('Blocks', $terms));
    $this->assertTrue(in_array('Relates to', $terms));
    $this->assertTrue(in_array('Duplicate', $terms));
  }

}
