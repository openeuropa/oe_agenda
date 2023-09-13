<?php

declare(strict_types=1);

namespace Drupal\oe_agenda\EventSubscriber;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\oe_content_sub_entity\SubEntityGenerateLabelSubscriberBase;

/**
 * Event subscriber for handling entity labels for "Session" entity type.
 */
class SessionGenerateLabelSubscriber extends SubEntityGenerateLabelSubscriberBase {

  /**
   * {@inheritdoc}
   */
  protected function generateLabel(ContentEntityInterface $entity): ?string {
    // Display the session name as label if set.
    return $entity->hasField('name') && !$entity->get('name')->isEmpty()
      ? $entity->get('name')->value
      : parent::defaultLabel($entity);
  }

  /**
   * {@inheritdoc}
   */
  protected function applies(ContentEntityInterface $entity): bool {
    return $entity->getEntityTypeId() === 'oe_agenda_session';
  }

}
