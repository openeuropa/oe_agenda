<?php

declare(strict_types=1);

namespace Drupal\oe_agenda\EventSubscriber;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\oe_content_sub_entity\SubEntityGenerateLabelSubscriberBase;

/**
 * Event subscriber for handling entity labels for "Day" entity type bundles.
 */
class DayGenerateLabelSubscriber extends SubEntityGenerateLabelSubscriberBase {

  /**
   * {@inheritdoc}
   */
  protected function generateLabel(ContentEntityInterface $entity): ?string {
    if ($entity->bundle() === 'oe_default'
      && $entity->hasField('oe_day_title')
      && $entity->hasField('oe_day_date')
    ) {
      // Display the day title as label if set, otherwise the date for Default
      // day type.
      return $entity->get('oe_day_title')->isEmpty()
        ? $entity->get('oe_day_date')->value
        : $entity->get('oe_day_title')->value;
    }

    return parent::defaultLabel($entity);
  }

  /**
   * {@inheritdoc}
   */
  protected function applies(ContentEntityInterface $entity): bool {
    return $entity->getEntityTypeId() === 'oe_agenda_day';
  }

}
