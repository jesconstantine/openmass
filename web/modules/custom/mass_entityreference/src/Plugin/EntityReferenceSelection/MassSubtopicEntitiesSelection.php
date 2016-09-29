<?php

namespace Drupal\mass_entityreference\Plugin\EntityReferenceSelection;

use Drupal\Core\Entity\Plugin\EntityReferenceSelection\DefaultSelection;

/**
 * Plugin implementation of the 'selection' entity_reference.
 *
 * @EntityReferenceSelection(
 *   id = "mass_subtopic_related",
 *   label = @Translation("Subtopic: Related Content"),
 *   entity_types = {"node"},
 *   group = "mass",
 *   weight = 1
 * )
 */
class MassSubtopicEntitiesSelection extends DefaultSelection {

  protected function buildEntityQuery($match = NULL, $match_operator = 'CONTAINS') {
    $query = parent::buildEntityQuery($match, $match_operator);
    $node = \Drupal::routeMatch()->getParameter('node');
    if ($node) {
      $nid = $node->nid;
      $query->condition('field_action_parent.target_id', $nid);
    }
    dpm($query);
    return $query;
  }
}