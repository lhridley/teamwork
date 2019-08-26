<?php

namespace Drupal\Tests\team_work\Functional;

/**
 * Test the Issue Type Vocabulary.
 *
 * @group team_work
 */
class TeamWorkIssueTypeVocabularyTermTestCase extends TeamWorkFunctionalTestBase {

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

    $this->vid = 'issue_type';

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

    // Check that Issue Type Vocabulary has 5 terms.
    $this->assertCount(5, $terms);

    // Check that Issue Type Vocabulary has the correct terms.
    $this->assertTrue(in_array('Epic', $terms));
    $this->assertTrue(in_array('Story', $terms));
    $this->assertTrue(in_array('Task', $terms));
    $this->assertTrue(in_array('Bugfix', $terms));
    $this->assertTrue(in_array('Asset', $terms));
  }

}
