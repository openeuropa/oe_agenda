<?php

declare(strict_types=1);

namespace Drupal\oe_agenda\Entity;

use Drupal\oe_content_sub_entity\Entity\SubEntityTypeBase;

/**
 * Defines the session type entity.
 *
 * @ConfigEntityType(
 *   id = "oe_agenda_session_type",
 *   label = @Translation("Agenda session type"),
 *   bundle_of = "oe_agenda_session",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *   },
 *   config_prefix = "oe_agenda_session_type",
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
 *     "add-form" = "/admin/structure/oe_agenda_session_type/add",
 *     "edit-form" = "/admin/structure/oe_agenda_session_type/{oe_agenda_session_type}/edit",
 *     "delete-form" = "/admin/structure/oe_agenda_session_type/{oe_agenda_session_type}/delete",
 *     "collection" = "/admin/structure/oe_agenda_session_type",
 *   }
 * )
 */
class SessionType extends SubEntityTypeBase {}
