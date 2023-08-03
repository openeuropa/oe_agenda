<?php

declare(strict_types = 1);

namespace Drupal\Tests\oe_agenda\FunctionalJavascript;

use Drupal\FunctionalJavascriptTests\WebDriverTestBase;

/**
 * Functional tests for the Agenda sub-entity type.
 */
class AgendaEntityTest extends WebDriverTestBase {

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
   * Tests adding Default agenda to a node.
   */
  public function testDefaultAgenda() {
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
    $page->pressButton('Create day');
    $assert_session->assertWaitOnAjaxRequest();
    $page->pressButton('Create agenda');
    $assert_session->assertWaitOnAjaxRequest();
    // Assert agenda label.
    $assert_session->elementTextContains('css', 'td.inline-entity-form-oe_agenda-label', 'Agenda (Default)');
    $page->pressButton('Save');
    $this->drupalGet('/node/1/edit');
    // Test updating agenda.
    $page->pressButton('ief-field_agenda-form-entity-edit-0');
    $assert_session->assertWaitOnAjaxRequest();
    $page->pressButton('ief-edit-submit-field_agenda-form-0');
    $assert_session->assertWaitOnAjaxRequest();
    $assert_session->buttonExists('ief-field_agenda-form-entity-edit-0');
    // Test removing agenda.
    $page->pressButton('ief-field_agenda-form-entity-remove-0');
    $assert_session->assertWaitOnAjaxRequest();
    $page->pressButton('ief-remove-confirm-field_agenda-form-0');
    $assert_session->assertWaitOnAjaxRequest();
    $assert_session->buttonExists('Add new agenda');
  }

}
