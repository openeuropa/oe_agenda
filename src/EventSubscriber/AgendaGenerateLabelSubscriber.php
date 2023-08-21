<?php

declare(strict_types=1);

namespace Drupal\oe_agenda\EventSubscriber;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\oe_content_sub_entity\SubEntityGenerateLabelSubscriberBase;

/**
 * Event subscriber for handing entity labels for "Agenda" entity type bundles.
 */
class AgendaGenerateLabelSubscriber extends SubEntityGenerateLabelSubscriberBase {

  /**
   * {@inheritdoc}
   */
  protected function generateLabel(ContentEntityInterface $entity): ?string {
    // As a default, use the entity type label with the bundle label in
    // parentheses, e.g. 'Agenda (Default)'.
    // @todo When days are added to the agenda, we should probably display
    //   the range of days as the label.
    return sprintf('%s (%s)', $entity->getEntityType()->getLabel(), $entity->get('type')->entity->label());
  }

  /**
   * {@inheritdoc}
   */
  protected function applies(ContentEntityInterface $entity): bool {
    return $entity->getEntityTypeId() === 'oe_agenda';
  }

}
