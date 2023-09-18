<?php

declare(strict_types=1);

namespace Drupal\Tests\oe_agenda\FunctionalJavascript;

use Drupal\field\Entity\FieldConfig;
use Drupal\FunctionalJavascriptTests\WebDriverTestBase;
use Drupal\Tests\node\Traits\NodeCreationTrait;

/**
 * Functional tests for the Session sub-entity type.
 */
class SessionEntityTest extends WebDriverTestBase {

  use NodeCreationTrait;

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'oe_agenda_test',
  ];

  /**
   * Tests adding Break session to an agenda day.
   */
  public function testBreakSession() {
    $user = $this->drupalCreateUser([
      'access content',
      'create test_bundle content',
      'edit any test_bundle content',
    ]);

    $this->drupalLogin($user);

    // Visit the node add page.
    $this->drupalGet('/node/add/test_bundle');
    $assert_session = $this->assertSession();
    $page = $this->getSession()->getPage();

    $page->fillField('Title', 'Test title');
    $page->pressButton('Add new agenda');
    $assert_session->assertWaitOnAjaxRequest();
    $page->fillField('field_agenda[form][0][oe_agenda_days][form][0][oe_day_date][0][value][date]', '08-21-2023');
    // Test adding session type 'Break'.
    $page->fillField('field_agenda[form][0][oe_agenda_days][form][0][oe_day_sessions][actions][bundle]', 'oe_break');
    $page->pressButton('Add new session');
    $assert_session->assertWaitOnAjaxRequest();
    $page->fillField('field_agenda[form][0][oe_agenda_days][form][0][oe_day_sessions][form][0][oe_session_hours][0][from]', '1000AM');
    $page->fillField('field_agenda[form][0][oe_agenda_days][form][0][oe_day_sessions][form][0][oe_session_hours][0][to]', '1030AM');
    $page->pressButton('Create session');
    $assert_session->assertWaitOnAjaxRequest();
    // Assert default 'Break' session label.
    $assert_session->elementTextContains('css', 'td.inline-entity-form-oe_agenda_session-label', 'Break');

    // Test end time cannot be earlier than start time.
    $page->pressButton('Add new session');
    $assert_session->assertWaitOnAjaxRequest();
    $page->fillField('field_agenda[form][0][oe_agenda_days][form][0][oe_day_sessions][form][1][oe_session_hours][0][from]', '1230AM');
    $page->fillField('field_agenda[form][0][oe_agenda_days][form][0][oe_day_sessions][form][1][oe_session_hours][0][to]', '1200AM');
    $page->pressButton('Create session');
    $assert_session->assertWaitOnAjaxRequest();
    $assert_session->statusMessageExists('error');
    $assert_session->statusMessageContains('The Hours end time cannot be before the start time.');
    $page->fillField('field_agenda[form][0][oe_agenda_days][form][0][oe_day_sessions][form][1][oe_session_hours][0][from]', '1200AM');
    $page->fillField('field_agenda[form][0][oe_agenda_days][form][0][oe_day_sessions][form][1][oe_session_hours][0][to]', '1230AM');
    $page->pressButton('Create session');
    $assert_session->assertWaitOnAjaxRequest();
    $assert_session->statusMessageNotExists('error');

    $page->pressButton('Create day');
    $assert_session->assertWaitOnAjaxRequest();
    // Assert day label with date.
    $assert_session->elementTextContains('css', 'td.inline-entity-form-oe_agenda_day-label', '2023-08-21');
  }

  /**
   * Tests adding Default session to an agenda day.
   */
  public function testDefaultSession() {
    $user = $this->drupalCreateUser([
      'access content',
      'create test_bundle content',
      'edit any test_bundle content',
    ]);

    $this->drupalLogin($user);

    // Create test persons.
    $this->createTestPerson('John Doe');
    $this->createTestPerson('Jane Doe');

    // Setup target bundle for session person reference fields.
    foreach (['oe_session_speakers', 'oe_session_moderators'] as $field) {
      $field_config = FieldConfig::loadByName('oe_agenda_session', 'oe_default', $field);
      $dependencies = $field_config->get('dependencies');
      $dependencies['config'][] = 'oe_content_sub_entity_person.oe_person_type.test_person_type';
      $field_config->set('dependencies', $dependencies);
      $settings = $field_config->getSettings();
      $settings['handler_settings']['target_bundles']['test_person_type'] = 'test_person_type';
      $field_config->set('settings', $settings);
      $field_config->save();
    }

    // Visit the node add page.
    $this->drupalGet('/node/add/test_bundle');
    $assert_session = $this->assertSession();
    $page = $this->getSession()->getPage();

    $page->fillField('Title', 'Test title');
    $page->pressButton('Add new agenda');
    $assert_session->assertWaitOnAjaxRequest();
    $page->fillField('field_agenda[form][0][oe_agenda_days][form][0][oe_day_date][0][value][date]', '08-21-2023');

    // Test adding session type 'Default'.
    $page->fillField('field_agenda[form][0][oe_agenda_days][form][0][oe_day_sessions][actions][bundle]', 'oe_default');
    $page->pressButton('Add new session');
    $assert_session->assertWaitOnAjaxRequest();
    $page->fillField('field_agenda[form][0][oe_agenda_days][form][0][oe_day_sessions][form][0][oe_session_hours][0][from]', '1100AM');
    $page->fillField('field_agenda[form][0][oe_agenda_days][form][0][oe_day_sessions][form][0][oe_session_hours][0][to]', '1200PM');
    $page->fillField('Name', 'Test default session');
    $page->pressButton('Create session');
    $assert_session->assertWaitOnAjaxRequest();
    // Assert session label.
    $assert_session->elementTextContains('css', 'td.inline-entity-form-oe_agenda_session-label', 'Test default session');

    // Test editing the session and fill in additional fields.
    $page->pressButton('ief-field_agenda-form-0-oe_agenda_days-form-0-oe_day_sessions-form-entity-edit-0');
    $assert_session->assertWaitOnAjaxRequest();
    $page->fillField('Intro.', 'Test session introduction.');
    $page->fillField('Details', 'Test session details.');
    $page->fillField('field_agenda[form][0][oe_agenda_days][form][0][oe_day_sessions][form][inline_entity_form][entities][0][form][oe_session_venue][0][uri]', 'https://example.com');
    $page->fillField('field_agenda[form][0][oe_agenda_days][form][0][oe_day_sessions][form][inline_entity_form][entities][0][form][oe_session_venue][0][title]', 'Test venue link');
    $page->fillField('field_agenda[form][0][oe_agenda_days][form][0][oe_day_sessions][form][inline_entity_form][entities][0][form][oe_session_venue][0][description]', 'Test venue long description.');

    $page->fillField('field_agenda[form][0][oe_agenda_days][form][0][oe_day_sessions][form][inline_entity_form][entities][0][form][oe_session_moderators][0][target_id]', 'John Doe');
    $page->fillField('field_agenda[form][0][oe_agenda_days][form][0][oe_day_sessions][form][inline_entity_form][entities][0][form][oe_session_speakers][0][target_id]', 'Jane Doe');
    $page->pressButton('Update session');
    $assert_session->assertWaitOnAjaxRequest();

    $page->pressButton('Create day');
    $assert_session->assertWaitOnAjaxRequest();
    // Assert day label with date.
    $assert_session->elementTextContains('css', 'td.inline-entity-form-oe_agenda_day-label', '2023-08-21');

    // Save test node with agenda.
    $page->pressButton('Create agenda');
    $assert_session->assertWaitOnAjaxRequest();
    $page->pressButton('Save');

    // Assert texts on the node page.
    $assert_session->pageTextContains('Test default session');
    $assert_session->pageTextContains('Test session introduction.');
    $assert_session->pageTextContains('Test session details.');
    $assert_session->pageTextContains('Test venue long description.');
    $assert_session->pageTextContains('John Doe');
    $assert_session->pageTextContains('Jane Doe');
  }

  /**
   * Creates a test person node and a person sub-entity referencing it.
   *
   * @param string $name
   *   The name of the person.
   */
  private function createTestPerson(string $name): void {
    $person = $this->container->get('entity_type.manager')->getStorage('oe_person')->create([
      'type' => 'test_person_type',
    ]);

    $node_values = [
      'type' => 'test_person_bundle',
      'title' => $name,
      'uid' => 1,
    ];
    $person->set('oe_test_person_reference', [$this->createNode($node_values)]);
    $person->save();
  }

}
