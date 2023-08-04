<?php

declare(strict_types=1);

namespace Drupal\oe_agenda\Entity;

use Drupal\oe_content_sub_entity\Entity\SubEntityBase;

/**
 * Defines the session entity.
 *
 * @ContentEntityType(
 *   id = "oe_agenda_session",
 *   label = @Translation("Session"),
 *   label_collection = @Translation("Sessions"),
 *   bundle_label = @Translation("Type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "access" = "Drupal\oe_content_sub_entity\SubEntityAccessControlHandler",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "translation" = "Drupal\content_translation\ContentTranslationHandler",
 *     "form" = {
 *       "default" = "Drupal\Core\Entity\ContentEntityForm",
 *       "edit" = "Drupal\Core\Entity\ContentEntityForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *     },
 *   },
 *   base_table = "oe_agenda_session",
 *   data_table = "oe_agenda_session_field_data",
 *   revision_table = "oe_agenda_session_revision",
 *   revision_data_table = "oe_agenda_session_field_revision",
 *   translatable = TRUE,
 *   entity_revision_parent_type_field = "parent_type",
 *   entity_revision_parent_id_field = "parent_id",
 *   entity_revision_parent_field_name_field = "parent_field_name",
 *   entity_keys = {
 *     "id" = "id",
 *     "revision" = "revision_id",
 *     "bundle" = "type",
 *     "uuid" = "uuid",
 *     "langcode" = "langcode",
 *     "published" = "status",
 *   },
 *   bundle_entity_type = "oe_agenda_session_type",
 *   field_ui_base_route = "entity.oe_agenda_session_type.edit_form",
 *   content_translation_ui_skip = TRUE,
 * )
 */
class Session extends SubEntityBase implements SessionInterface {}
