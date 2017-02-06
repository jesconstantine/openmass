<?php

namespace Drupal\mass_map\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'Random_default' formatter.
 *
 * @FieldFormatter(
 *   id = "map_row_formatter",
 *   label = @Translation("Map Row"),
 *   field_types = {
 *     "entity_reference"
 *   }
 * )
 */
class MapRowFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = array();

    $summary[] = t('Embed Google Map with location markers.');

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $location_ids = array();

    foreach ($items as $delta => $item) {
      $location_ids[] = $item->target_id;
    }



    // Use the ids to get location info.
    $locations = MapLocationFetcher::getLocations($location_ids);

    return [
      '#attached' => array(
        'library' => array(
          'mass_map/mass-map-field-renderer',
          'mass_map/mass-google-map-apis',
        ),
        'drupalSettings' => array(
          'locations' => $locations,
        ),
      ),
    ];
  }

}