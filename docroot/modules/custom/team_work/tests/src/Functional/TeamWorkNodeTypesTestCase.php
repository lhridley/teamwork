<?php

namespace Drupal\Tests\team_work\Functional;

use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\field\Entity\FieldConfig;

/**
 * Test that proper node types exist.
 *
 * @group team_work
 */
class TeamWorkNodeTypesTestCase extends TeamWorkFunctionalTestBase {

  /**
   * Stores a list of node types, keyed by term ID.
   *
   * @var array
   */
  public $types;

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    // Make sure to complete the normal setup steps first.
    parent::setUp();

    $this->types = \Drupal::service('entity_type.manager')
      ->getStorage('node_type')
      ->loadMultiple();
  }

  /**
   * Make sure node types are present.
   */
  public function testNodeTypesArePresent() {
    // Checks that there are 4 node types.
    $this->assertCount(4, $this->types);

    // Checks for the existence of the correct vocabularies.
    $node_type_ids = array_keys($this->types);

    $this->assertTrue(in_array('company', $node_type_ids));
    $this->assertTrue(in_array('company_team', $node_type_ids));
    $this->assertTrue(in_array('project', $node_type_ids));
    $this->assertTrue(in_array('project_team', $node_type_ids));
  }

  /**
   * Check for fields on Company content type.
   */
  public function testCompanyNodeTypeFields() {
    $node_type = $this->types['company'];
    $fields = \Drupal::service('entity_field.manager')->getFieldDefinitions('node', 'company');

    // Verify node configuration settings.
    $this->assertEquals($node_type->status(), TRUE);
    $this->assertEquals($node_type->getPreviewMode(), DRUPAL_OPTIONAL);
    $this->assertEquals($node_type->isNewRevision(), TRUE);
    $this->assertEquals($node_type->displaySubmitted(), FALSE);
    $this->assertEquals($node_type->get('name'), 'Company');
    $this->assertEquals($node_type->getDescription(), "Company Profile");
    $this->assertEquals($fields['title']->getLabel(), 'Name');
    $this->assertEquals($fields['promote']->getDefaultValueLiteral(), [['value' => FALSE]]);
    $this->assertEquals($fields['sticky']->getDefaultValueLiteral(), [['value' => FALSE]]);

    // Getting info on added fields.
    $field_ids = [];
    foreach ($fields as $key => $field) {
      if ($field instanceof FieldConfig) {
        $field_ids[] = $key;
      }
    }
    // Verify count of added fields.
    $this->assertCount(1, $field_ids);

    // Verify added fields settings.
    $this->assertEquals($fields['field_primary_team']->get('field_type'), 'boolean');
    $this->assertEquals($fields['field_primary_team']->getFieldStorageDefinition()->getCardinality(), 1);

  }

  /**
   * Check for fields on Company Team conteent type.
   */
  public function testCompanyTeamNodeTypeFields() {
    $node_type = $this->types['company_team'];
    $fields = \Drupal::service('entity_field.manager')->getFieldDefinitions('node', 'company_team');

    // Verify node configuration settings.
    $this->assertEquals($node_type->status(), TRUE);
    $this->assertEquals($node_type->getPreviewMode(), DRUPAL_OPTIONAL);
    $this->assertEquals($node_type->isNewRevision(), TRUE);
    $this->assertEquals($node_type->displaySubmitted(), FALSE);
    $this->assertEquals($node_type->get('name'), 'Company Team');
    $this->assertEquals($node_type->getDescription(), "Company Teams are groups of users for a particular company that make up a team.  Companies can have more than one team, and users can belong to more than one team.  Company Teams are associated with Projects.");

    $this->assertEquals($fields['title']->getLabel(), 'Team Name');
    $this->assertEquals($fields['promote']->getDefaultValueLiteral(), [['value' => FALSE]]);
    $this->assertEquals($fields['sticky']->getDefaultValueLiteral(), [['value' => FALSE]]);

    // Getting info on added fields.
    $field_ids = [];
    foreach ($fields as $key => $field) {
      if ($field instanceof FieldConfig) {
        $field_ids[] = $key;
      }
    }
    // Verify count of added fields.
    $this->assertCount(2, $field_ids);

    // Verify field_company field settings.
    $this->assertEquals($fields['field_company']->get('field_type'), 'entity_reference');
    $this->assertEquals($fields['field_company']->isRequired(), TRUE);
    $this->assertEquals($fields['field_company']->getFieldStorageDefinition()->getCardinality(), 1);

    $handler_settings = $fields['field_company']->getSetting('handler_settings');
    $this->assertArrayHasKey('company', $handler_settings['target_bundles']);
    $this->assertEquals($handler_settings['sort']['field'], 'title');
    $this->assertEquals($handler_settings['sort']['direction'], 'ASC');

    $handler = $fields['field_company']->getSetting('handler');
    $this->assertEquals($handler, 'default:node');

    // Verify field_team_member field settings.
    $this->assertEquals($fields['field_team_member']->get('field_type'), 'entity_reference_revisions');
    $this->assertEquals($fields['field_team_member']->isRequired(), TRUE);
    $this->assertEquals($fields['field_team_member']->getFieldStorageDefinition()->getCardinality(), FieldStorageDefinitionInterface::CARDINALITY_UNLIMITED);

    $handler_settings = $fields['field_team_member']->getSetting('handler_settings');
    $this->assertCount(1, $handler_settings['target_bundles']);
    $this->assertArrayHasKey('team_member', $handler_settings['target_bundles']);

    $this->assertCount(2, $handler_settings['target_bundles_drag_drop']);
    $this->assertEquals($handler_settings['target_bundles_drag_drop']['from_library']['enabled'], FALSE);
    $this->assertEquals($handler_settings['target_bundles_drag_drop']['team_member']['enabled'], TRUE);

    $handler = $fields['field_team_member']->getSetting('handler');
    $this->assertEquals($handler, 'default:paragraph');
  }

  /**
   * Check for fields on Project conteent type.
   */
  public function testProjectNodeTypeFields() {
    $node_type = $this->types['project'];
    $fields = \Drupal::service('entity_field.manager')->getFieldDefinitions('node', 'project');

    // Verify node configuration settings.
    $this->assertEquals($node_type->status(), TRUE);
    $this->assertEquals($node_type->getPreviewMode(), DRUPAL_OPTIONAL);
    $this->assertEquals($node_type->isNewRevision(), TRUE);
    $this->assertEquals($node_type->displaySubmitted(), FALSE);
    $this->assertEquals($node_type->get('name'), 'Project');
    $this->assertEquals($node_type->getDescription(), "Company Projects");
    $this->assertEquals($fields['title']->getLabel(), 'Name');
    $this->assertEquals($fields['promote']->getDefaultValueLiteral(), [['value' => FALSE]]);
    $this->assertEquals($fields['sticky']->getDefaultValueLiteral(), [['value' => FALSE]]);

    // Getting info on added fields.
    $field_ids = [];
    foreach ($fields as $key => $field) {
      if ($field instanceof FieldConfig) {
        $field_ids[] = $key;
      }
    }
    // Verify count of added fields.
    $this->assertCount(5, $field_ids);

    // Verify field_company field settings.
    $this->assertEquals($fields['field_company']->get('field_type'), 'entity_reference');
    $this->assertEquals($fields['field_company']->isRequired(), TRUE);
    $this->assertEquals($fields['field_company']->getFieldStorageDefinition()->getCardinality(), 1);

    $handler_settings = $fields['field_company']->getSetting('handler_settings');
    $this->assertArrayHasKey('company', $handler_settings['target_bundles']);
    $this->assertEquals($handler_settings['sort']['field'], 'title');
    $this->assertEquals($handler_settings['sort']['direction'], 'ASC');

    $handler = $fields['field_company']->getSetting('handler');
    $this->assertEquals($handler, 'default:node');

    // Verify field_default_assignee field settings.
    $this->assertEquals($fields['field_default_assignee']->get('field_type'), 'entity_reference');
    $this->assertEquals($fields['field_default_assignee']->isRequired(), FALSE);
    $this->assertEquals($fields['field_default_assignee']->getFieldStorageDefinition()->getCardinality(), 1);

    $handler_settings = $fields['field_default_assignee']->getSetting('handler_settings');
    $this->assertEquals($handler_settings['include_anonymous'], FALSE);
    $this->assertEquals($handler_settings['sort']['field'], 'field_last_name');
    $this->assertEquals($handler_settings['sort']['direction'], 'ASC');
    $this->assertEquals($handler_settings['auto_create'], FALSE);

    $handler = $fields['field_default_assignee']->getSetting('handler');
    $this->assertEquals($handler, 'default:user');

    // Verify field_project_key field settings.
    $this->assertEquals($fields['field_project_key']->get('field_type'), 'entity_reference');
    $this->assertEquals($fields['field_project_key']->isRequired(), TRUE);
    $this->assertEquals($fields['field_project_key']->getFieldStorageDefinition()->getCardinality(), 1);

    $handler_settings = $fields['field_project_key']->getSetting('handler_settings');
    $this->assertArrayHasKey('project_keys', $handler_settings['target_bundles']);

    $handler = $fields['field_project_key']->getSetting('handler');
    $this->assertEquals($handler, 'default:taxonomy_term');

    // Verify field_project_lead field settings.
    $this->assertEquals($fields['field_project_lead']->get('field_type'), 'entity_reference');
    $this->assertEquals($fields['field_project_lead']->isRequired(), TRUE);
    $this->assertEquals($fields['field_project_lead']->getFieldStorageDefinition()->getCardinality(), 1);

    $handler_settings = $fields['field_project_lead']->getSetting('handler_settings');

    $this->assertEquals($handler_settings['include_anonymous'], FALSE);
    $this->assertEquals($handler_settings['sort']['field'], 'field_last_name');
    $this->assertEquals($handler_settings['sort']['direction'], 'ASC');
    $this->assertEquals($handler_settings['auto_create'], FALSE);

    $handler = $fields['field_project_lead']->getSetting('handler');
    $this->assertEquals($handler, 'default:user');
  }

  /**
   * Check for fields on Project Team conteent type.
   */
  public function testProjectTeamNodeTypeFields() {
    $node_type = $this->types['project_team'];
    $fields = \Drupal::service('entity_field.manager')->getFieldDefinitions('node', 'project_team');

    // Verify node configuration settings.
    $this->assertEquals($node_type->status(), TRUE);
    $this->assertEquals($node_type->getPreviewMode(), DRUPAL_OPTIONAL);
    $this->assertEquals($node_type->isNewRevision(), TRUE);
    $this->assertEquals($node_type->displaySubmitted(), FALSE);
    $this->assertEquals($node_type->get('name'), 'Project Team');
    $this->assertEquals($node_type->getDescription(), "Project Teams are groups of users for the primary company that make up a team. Companies can have more than one Project Team, and users can belong to more than one team. Project Teams are associated with Projects.");
    $this->assertEquals($fields['title']->getLabel(), 'Team Name');
    $this->assertEquals($fields['promote']->getDefaultValueLiteral(), [['value' => FALSE]]);
    $this->assertEquals($fields['sticky']->getDefaultValueLiteral(), [['value' => FALSE]]);

    // Getting info on added fields.
    $field_ids = [];
    foreach ($fields as $key => $field) {
      if ($field instanceof FieldConfig) {
        $field_ids[] = $key;
      }
    }

    // Verify count of added fields.
    $this->assertCount(3, $field_ids);

    // Verify field_company field settings.
    $this->assertEquals($fields['field_company']->get('field_type'), 'entity_reference');
    $this->assertEquals($fields['field_company']->isRequired(), TRUE);
    $this->assertEquals($fields['field_company']->getFieldStorageDefinition()->getCardinality(), 1);

    $handler = $fields['field_company']->getSetting('handler');
    $this->assertEquals($handler, 'views');

    $target_type = $fields['field_company']->getSetting('target_type');
    $this->assertEquals($target_type, 'node');

    $handler_settings = $fields['field_company']->getSetting('handler_settings');

    $this->assertCount(1, $handler_settings);
    $this->assertArrayHasKey('view', $handler_settings);

    $this->assertCount(3, $handler_settings['view']);

    $this->assertEquals($handler_settings['view']['view_name'], 'primary_company');
    $this->assertEquals($handler_settings['view']['display_name'], 'primary_company');

    $this->assertEmpty($handler_settings['view']['arguments']);

    // Verify field_project field settings.
    $this->assertEquals($fields['field_project']->get('field_type'), 'entity_reference');
    $this->assertEquals($fields['field_project']->isRequired(), TRUE);
    $this->assertEquals($fields['field_project']->getFieldStorageDefinition()->getCardinality(), 1);

    $handler_settings = $fields['field_project']->getSetting('handler_settings');

    $this->assertCount(4, $handler_settings);

    $this->assertArrayHasKey('project', $handler_settings['target_bundles']);
    $this->assertEquals($handler_settings['sort']['field'], 'field_project');
    $this->assertEquals($handler_settings['sort']['direction'], 'ASC');
    $this->assertEquals($handler_settings['auto_create'], '');
    $this->assertEquals($handler_settings['auto_create_bundle'], '');

    $handler = $fields['field_project']->getSetting('handler');
    $this->assertEquals($handler, 'default:node');

    // Verify field_team_member field settings.
    $this->assertEquals($fields['field_team_member']->get('field_type'), 'entity_reference_revisions');
    $this->assertEquals($fields['field_company']->isRequired(), TRUE);
    $this->assertEquals($fields['field_team_member']->getFieldStorageDefinition()->getCardinality(), FieldStorageDefinitionInterface::CARDINALITY_UNLIMITED);

    $handler_settings = $fields['field_team_member']->getSetting('handler_settings');
    $this->assertCount(1, $handler_settings['target_bundles']);
    $this->assertArrayHasKey('team_member', $handler_settings['target_bundles']);

    $this->assertCount(2, $handler_settings['target_bundles_drag_drop']);
    $this->assertEquals($handler_settings['target_bundles_drag_drop']['from_library']['enabled'], FALSE);
    $this->assertEquals($handler_settings['target_bundles_drag_drop']['team_member']['enabled'], TRUE);

    $handler = $fields['field_team_member']->getSetting('handler');
    $this->assertEquals($handler, 'default:paragraph');
  }

}
