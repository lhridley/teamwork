<?php

namespace Drupal\Tests\team_work\Functional;

use Drupal\field\Entity\FieldConfig;

/**
 * Test that proper node types exist.
 *
 * @group team_work
 */
class TeamWorkParagraphTypesTestCase extends TeamWorkFunctionalTestBase {

  /**
   * Stores a list of node types, keyed by ID.
   *
   * @var array
   */
  public $types;

  /**
   * Stores a list of fields, keyed by ID.
   *
   * @var array
   */
  public $fields;

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    // Make sure to complete the normal setup steps first.
    parent::setUp();

    $this->types = \Drupal::service('entity_type.manager')
      ->getStorage('paragraphs_type')
      ->loadMultiple();
    $this->fields = \Drupal::service('entity_field.manager')
      ->getFieldDefinitions('paragraph', 'team_member');
  }

  /**
   * Make sure node types are present.
   */
  public function testParagraphsTypesArePresent() {
    // Checks that there are 1 paragraph types.
    $this->assertCount(1, $this->types);
    $this->assertArrayHasKey('team_member', $this->types);

    // Checks for the existence of the correct paragraph types.
    $paragraph_type = $this->types['team_member'];
    $this->assertEquals($paragraph_type->label(), 'Team Member');
    $this->assertEquals($paragraph_type->getDescription(), "Team Member");
    $this->assertEquals($paragraph_type->status(), TRUE);

  }

  /**
   * Check for fields on Team Member Paragrfaph type.
   */
  public function testTeamMemberParagraphTypeFields() {
    $fields = $this->fields;

    // Getting info on added fields.
    $field_ids = [];
    foreach ($fields as $key => $field) {
      if ($field instanceof FieldConfig) {
        $field_ids[] = $key;
      }
    }
    // Verify count of added fields.
    $this->assertCount(2, $field_ids);

    // Assertsions on field_role field.
    $this->assertEquals($fields['field_role']->get('field_type'), 'entity_reference');
    $this->assertEquals($fields['field_role']->isRequired(), TRUE);
    $this->assertEquals($fields['field_role']->getFieldStorageDefinition()->getCardinality(), 1);

    $handler = $fields['field_role']->getSetting('handler');
    $this->assertEquals($handler, 'default:taxonomy_term');

    $handler_settings = $fields['field_role']->getSetting('handler_settings');
    $this->assertArrayHasKey('team_roles', $handler_settings['target_bundles']);
    $this->assertEquals($handler_settings['sort']['field'], 'name');
    $this->assertEquals($handler_settings['sort']['direction'], 'asc');
    $this->assertEquals($handler_settings['auto_create'], FALSE);
    $this->assertEquals($handler_settings['auto_create_bundle'], '');

    $this->assertEquals($fields['field_team_member']->get('field_type'), 'entity_reference');
    $this->assertEquals($fields['field_team_member']->isRequired(), FALSE);
    $this->assertEquals($fields['field_team_member']->getFieldStorageDefinition()->getCardinality(), 1);

    $handler = $fields['field_team_member']->getSetting('handler');
    $this->assertEquals($handler, 'default:user');

    $handler_settings = $fields['field_team_member']->getSetting('handler_settings');

    $this->assertNull($handler_settings['target_bundles']);
    $this->assertEquals($handler_settings['sort']['field'], 'name');
    $this->assertEquals($handler_settings['sort']['direction'], 'ASC');
    $this->assertEquals($handler_settings['auto_create'], FALSE);
  }

}
