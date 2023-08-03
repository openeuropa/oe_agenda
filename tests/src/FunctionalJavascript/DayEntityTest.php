<?php

declare(strict_types = 1);

namespace Drupal\Tests\oe_agenda\FunctionalJavascript;

use Drupal\FunctionalJavascriptTests\WebDriverTestBase;

/**
 * Functional tests for the Day sub-entity type.
 */
class DayEntityTest extends WebDriverTestBase {

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
   * Tests adding Default day to an agenda.
   */
  public function testDefaultDay() {
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
    // Assert day label with date.
    $assert_session->elementTextContains('css', 'td.inline-entity-form-oe_agenda_day-label', '2023-08-21');
    // Test editing the day.
    $page->pressButton('ief-field_agenda-form-0-oe_agenda_days-form-entity-edit-0');
    $assert_session->assertWaitOnAjaxRequest();
    $page->fillField('field_agenda[form][0][oe_agenda_days][form][inline_entity_form][entities][0][form][oe_day_title][0][value]', 'Test day title');
    $page->pressButton('Update day');
    $assert_session->assertWaitOnAjaxRequest();
    // Assert day label with title.
    $assert_session->elementTextContains('css', 'td.inline-entity-form-oe_agenda_day-label', 'Test day title');
    // Test adding a second day.
    $page->pressButton('Add new day');
    $assert_session->assertWaitOnAjaxRequest();
    $page->fillField('field_agenda[form][0][oe_agenda_days][form][1][oe_day_date][0][value][date]', '08-22-2023');
    $page->pressButton('Create day');
    $assert_session->assertWaitOnAjaxRequest();
    $assert_session->elementTextContains('css', '.ief-entity-table tbody tr:nth-child(2) td.inline-entity-form-oe_agenda_day-label', '2023-08-22');
    // Test removing second day.
    $page->pressButton('ief-field_agenda-form-0-oe_agenda_days-form-entity-remove-1');
    $assert_session->assertWaitOnAjaxRequest();
    $page->pressButton('ief-remove-confirm-field_agenda-form-0-oe_agenda_days-form-1');
    $assert_session->assertWaitOnAjaxRequest();
    $assert_session->pageTextNotContains('2023-08-22');
  }

}
