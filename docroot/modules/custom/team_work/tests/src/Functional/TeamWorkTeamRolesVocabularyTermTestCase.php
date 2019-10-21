<?php

namespace Drupal\Tests\team_work\Functional;

/**
 * Test the Team Roles Vocabulary.
 *
 * @group team_work
 */
class TeamWorkTeamRolesVocabularyTermTestCase extends TeamWorkFunctionalTestBase {

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

    $this->vid = 'team_roles';

    $terms = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree($this->vid, 0, NULL, TRUE);

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

    // Check that Team Roles Vocabulary has 10 terms.
    $this->assertCount(10, $terms);

    // Check that Team Roles Vocabulary has the correct terms.
    $this->assertTrue(in_array('Project Manager', $terms));
    $this->assertTrue(in_array('Scrum Master', $terms));
    $this->assertTrue(in_array('Technical Lead', $terms));
    $this->assertTrue(in_array('Architect', $terms));
    $this->assertTrue(in_array('Designer', $terms));
    $this->assertTrue(in_array('Developer', $terms));
    $this->assertTrue(in_array('QA Specialist', $terms));
    $this->assertTrue(in_array('Client Product Owner', $terms));
    $this->assertTrue(in_array('Client Developer', $terms));
    $this->assertTrue(in_array('Client Member', $terms));
  }

}
