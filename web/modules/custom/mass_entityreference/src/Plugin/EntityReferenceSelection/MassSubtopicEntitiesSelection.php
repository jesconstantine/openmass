<?php

namespace Drupal\mass_entityreference\Plugin\EntityReferenceSelection;

use Drupal\Core\Entity\Plugin\EntityReferenceSelection\DefaultSelection;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'selection' entity_reference.
 *
 * @EntityReferenceSelection(
 *   id = "mass",
 *   label = @Translation("Subtopic: Related Content"),
 *   group = "mass",
 *   weight = 0
 * )
 */
class MassSubtopicEntitiesSelection extends DefaultSelection {

  protected function buildEntityQuery($match = NULL, $match_operator = 'CONTAINS') {
    $query = parent::buildEntityQuery($match, $match_operator);
    $node = \Drupal::routeMatch()->getRawParameter('node');
    $current_path = \Drupal::service('path.current')->getPath();
    //$current_path = explode('/', $current_path);
    //$selection_settings = $this->keyValue->get($current_path[3], FALSE);
    dpm($current_path);
    if ($node) {
      $nid = $node->nid;
      $query->condition('field_action_parent.target_id', $nid);
    }
    //dpm($query);
    return $query;
  }

  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateConfigurationForm(array &$form, FormStateInterface $form_state){ }
}