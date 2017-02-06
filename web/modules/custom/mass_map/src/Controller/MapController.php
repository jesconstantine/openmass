<?php

namespace Drupal\mass_map\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\paragraphs\Entity\Paragraph;
use Drupal\mass_map\MapLocationFetcher;

/**
 * Class MapController.
 *
 * @package Drupal\mass_map\Controller
 */
class MapController extends ControllerBase {

  /**
   * Content for the map pages.
   *
   * @param int $id
   *   Subtopic nid with a list of locations.
   *
   * @return array
   *   Render array that returns a list of locations.
   */
  public function content($id) {
    $markup = '';

    // Get Locations from the given subtopic.
    $node_storage = \Drupal::entityManager()->getStorage('node');
    $node = $node_storage->load($id);
    $ids = array();
    foreach ($node->field_map_locations as $location) {
      $ids[] = $location->getValue()['target_id'];
    }

    // Use the ids to get location info.
    $locations = MapLocationFetcher::getLocations($ids);

    return [
      '#theme' => 'map_page',
      '#attached' => array(
        'library' => array(
          'mass_map/mass-map-page-renderer',
          'mass_map/mass-google-map-apis',
        ),
        'drupalSettings' => array(
          'locations' => $locations,
        ),
      ),
    ];
  }


}
