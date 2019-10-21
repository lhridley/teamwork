<?php

namespace Drupal\Tests\team_work\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Base Functional Test Class.
 *
 * @group team_work
 */
class TeamWorkFunctionalTestBase extends BrowserTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = [
    // Modules for core functionality.
    'config',
    'content_moderation',
    'field_layout',
    'taxonomy',
    'layout_discovery',
    'node',
    'user',
    'views',
    'workflows',
    // Contrib modules.
    'entity_reference_revisions',
    'paragraphs',
    'pathauto',
    'token',
    // This custom module.
    'team_work',
  ];

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    // Make sure to complete the normal setup steps first.
    parent::setUp();

    // Set the front page to "/node".
    \Drupal::configFactory()
      ->getEditable('system.site')
      ->set('page.front', '/node')
      ->save(TRUE);
  }

}
