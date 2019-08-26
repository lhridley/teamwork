<?php

namespace Drupal\Tests\team_work\Functional;

/**
 * Test the Issue Priority Vocabulary.
 *
 * @group team_work
 */
class TeamWorkIssuePriorityVocabularyTermTestCase extends TeamWorkFunctionalTestBase {

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

    $this->vid = 'issue_priority';

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

    // Check that Issue Priority Vocabulary has 5 terms.
    $this->assertCount(5, $terms);

    // Check that Issue Priority Vocabulary has the correct terms.
    $this->assertTrue(in_array('Immediate', $terms));
    $this->assertTrue(in_array('Urgent', $terms));
    $this->assertTrue(in_array('High', $terms));
    $this->assertTrue(in_array('Normal', $terms));
    $this->assertTrue(in_array('Low', $terms));

  }

}
