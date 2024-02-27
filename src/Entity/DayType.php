<?php

declare(strict_types=1);

namespace Drupal\oe_agenda\Entity;

use Drupal\oe_content_sub_entity\Entity\SubEntityTypeBase;

/**
 * Defines the agenda day type entity.
 *
 * @ConfigEntityType(
 *   id = "oe_agenda_day_type",
 *   label = @Translation("Agenda day type"),
 *   bundle_of = "oe_agenda_day",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *   },
 *   config_prefix = "oe_agenda_day_type",
 *   config_export = {
 *     "id",
 *     "label",
 *     "description",
 *   },
 *   handlers = {
 *     "access" = "Drupal\oe_content_entity\CorporateEntityTypeAccessControlHandler",
 *     "list_builder" = "Drupal\oe_content\Entity\EntityTypeListBuilder",
 *     "form" = {
 *       "default" = "Drupal\oe_content\Form\EntityTypeForm",
 *       "add" = "Drupal\oe_content\Form\EntityTypeForm",
 *       "edit" = "Drupal\oe_content\Form\EntityTypeForm",
 *       "delete" = "Drupal\oe_content\Form\EntityTypeDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     },
 *   },
 *   admin_permission = "administer sub entity types",
 *   links = {
 *     "add-form" = "/admin/structure/oe_agenda_day_type/add",
 *     "edit-form" = "/admin/structure/oe_agenda_day_type/{oe_agenda_day_type}/edit",
 *     "delete-form" = "/admin/structure/oe_agenda_day_type/{oe_agenda_day_type}/delete",
 *     "collection" = "/admin/structure/oe_agenda_day_type",
 *   }
 * )
 */
class DayType extends SubEntityTypeBase {}
