<?php

namespace Drupal\mayflower;

use Drupal\Component\Utility\UrlHelper;
use Drupal\image\Entity\ImageStyle;

/**
 * Provides mayflower prepare functions with helper functions.
 */
class Helper {

  /**
   * Helper function to determine whether or not a field is populated.
   *
   * @param object $entity
   *   Entity that contains the field to be checked.
   * @param string $field_name
   *   The name of the field to be checked.
   *
   * @return bool
   *   Whether or not a field is populated.
   */
  public static function isFieldPopulated($entity, $field_name) {
    $is_populated = FALSE;

    $has_field = $entity->hasField($field_name);

    if ($has_field) {
      $field = $entity->get($field_name);
      if ($field->count() > 0) {
        $is_populated = TRUE;
      }
    }

    return $is_populated;
  }

  /**
   * Helper function to retrieve the fields needed by the pattern.
   *
   * @param object $entity
   *   The entity which contains the fields.
   * @param array $map
   *   The array which contains all potentially used fields.
   *
   * @return array
   *   The array which contains the fields used by this pattern.
   */
  public static function getMappedFields($entity, array $map) {
    $fields = [];
    // Determines which field names to use from the map.
    // @todo refactor to make use array functions (map, filter, reduce)
    foreach ($map as $id => $key) {
      foreach ($key as $field) {
        if ($entity->hasField($field)) {
          $fields[$id] = $field;
        }
      }
    }

    return $fields;
  }

  /**
   * Provide the URL of an image.
   *
   * @param object $entity
   *   The node with the field on it.
   * @param string $style_name
   *   (Optional) The name of an image style.
   * @param string $field
   *   The name of an the image field.
   * @param int $delta
   *   (Optional) the delta of the image field to display, defaults to 0.
   *
   * @return string
   *   The URL to the styled image, or to the original image if the style
   *   does not exist.
   */
  public static function getFieldImageUrl($entity, $style_name = NULL, $field = NULL, $delta = 0) {
    $url = '';

    $fields = $entity->get($field);

    if ($fields) {
      $images = $fields->referencedEntities();
    }

    if (!empty($images)) {
      $image = $images[$delta];

      if (!empty($style_name) && ($style = ImageStyle::load($style_name))) {
        $url = $style->buildUrl($image->getFileUri());
      }
      else {
        $url = $image->url();
      }
    }

    return $url;
  }

  /**
   * Helper function to provide url of an entity based on presence of a field.
   *
   * @param object $entity
   *   Entity object that contains the external url field.
   * @param string $external_url_link_field
   *   The name of the field.
   *
   * @return array
   *   Array that contains url and type (external, internal).
   */
  public static function getEntityUrl($entity, $external_url_link_field = '') {
    if ((!empty($external_url_link_field)) && (Helper::isFieldPopulated($entity, $external_url_link_field))) {
      // External URL field exists & is populated so get its URL + type.
      $links = Helper::separatedLinks($entity, $external_url_link_field);
      // @todo update mayflower_separated_links so we don't need [0]
      return $links[0];
    }
    else {
      // External URL field is non-existent or empty, get Node path alias.
      $url = $entity->toURL();
      return [
        'href' => $url->toString(),
        'type' => 'internal',
      ];
    }
  }

  /**
   * Helper function to provide separated link parts for multiple links.
   *
   * @param object $entity
   *   Entity object that contains the link field.
   * @param string $field_name
   *   The name of the field.
   *
   * @return array
   *   Array that contains title, url and type (external, internal).
   */
  public static function separatedLinks($entity, $field_name) {
    $links = $entity->get($field_name);
    $items = [];

    foreach ($links as $link) {
      $items[] = Helper::separatedLink($link);
    }

    return $items;
  }

  /**
   * Helper function to provide separated link parts.
   *
   * @param object $link
   *   The link object.
   *
   * @return array
   *   Array that contains title, url and type (external, internal).
   */
  public static function separatedLink($link) {
    $url = $link->getUrl();
    return [
      'text' => $link->getValue()['title'],
      'href' => $url->toString(),
      'type' => (UrlHelper::isExternal($url->toString())) ? 'external' : 'internal',
    ];
  }

  /**
   * Helper function to provide separated email link parts.
   *
   * @param object $entity
   *   Entity object that contains the link field.
   * @param string $field_name
   *   The name of the field.
   *
   * @return array
   *   Array that contains title, url.
   */
  public static function separatedEmailLink($entity, $field_name) {
    $link = $entity->get($field_name);

    return [
      'text' => $link->value,
      'href' => $link->value,
    ];
  }

  /**
   * Helper function to provide render array for a field.
   *
   * @param object $entity
   *   Entity that contains the field to render.
   * @param string $field_name
   *   The name of the field.
   *
   * @return array
   *   Returns the full render array of the field.
   */
  public static function fieldFullView($entity, $field_name) {
    $field_array = [];
    $field = $entity->get($field_name);

    if ($field->count() > 0) {
      $field_array = $field->first()->view('full');
    }

    return $field_array;
  }

  /**
   * Helper function to get the value of a referenced field.
   *
   * @param object $field
   *   Send a field object.
   * @param string $referenced_field
   *   Name of the referenced field.
   *
   * @return array
   *   The value of the referenced field.
   */
  public static function getReferenceField($field, $referenced_field) {
    if (method_exists($field, 'referencedEntities') && isset($field->referencedEntities()[0]) && $field->referencedEntities()[0]->hasField($referenced_field)) {
      return $field->referencedEntities()[0]->get($referenced_field)->value;
    }
    return FALSE;
  }

  /**
   * Helper function to provide a value for a field.
   *
   * @param object $entity
   *   Entity that contains the field to render.
   * @param string $field_name
   *   The name of the field.
   *
   * @return array
   *   Returns the value of the field.
   */
  public static function fieldValue($entity, $field_name) {
    $value = '';
    $field = $entity->get($field_name);

    if ($field->count() > 0) {
      $value = $field->first()->value;
    }

    return $value;
  }

  /**
   * Helper function to retrieve the entities referenced from the entity field.
   *
   * @param object $entity
   *   The entity which contains the reference field.
   * @param string $reference_field
   *   The name of the entity reference field.
   *
   * @return array
   *   The array which contains the entities referenced by the field.
   */
  public static function getReferencedEntitiesFromField($entity, $reference_field) {
    // Retrieves the featured actions referenced from the entity field.
    $field = $entity->get($reference_field);
    $referenced_items = [];
    if ($field->count() > 0) {
      $referenced_items = $field->referencedEntities();
    }

    return $referenced_items;
  }

  /**
   * Helper function to find the field names to use on the entity.
   *
   * @param array $referenced_entities
   *   Array that contains the featured/all actions referenced entities.
   * @param array $referenced_fields_map
   *   The array which contains the list of possible fields from the
   *   referenced entities.
   *
   * @return array
   *   The array which contains the list of necessary fields from the
   *   referenced entities.
   */
  public static function getMappedReferenceFields(array $referenced_entities, array $referenced_fields_map) {
    // @todo determine if this can be combined with mayflower_get_mapped_fields
    $referenced_fields = [];
    // Determines the field names to use on the referenced entity.
    foreach ($referenced_fields_map as $id => $key) {
      foreach ($key as $field) {
        if (isset($referenced_entities[0]) && $referenced_entities[0]->hasField($field)) {
          $referenced_fields[$id] = $field;
        }
      }
    }

    return $referenced_fields;
  }

  /**
   * Helper function to populate a featured/links property of action finder.
   *
   * @param array $referenced_entities
   *   Array that contains the featured/all actions referenced entities.
   * @param array $referenced_fields
   *   The array which contains the list of necessary fields from the
   *   referenced entities.
   *
   * @return array
   *   The variable structure for the featured/links property.
   */
  public static function populateActionFinderLinks(array $referenced_entities, array $referenced_fields) {
    // Populate links array.
    $links = [];
    if (!empty($referenced_entities)) {
      foreach ($referenced_entities as $item) {

        // Get the image, if there is one.
        $image = "";
        if (!empty($referenced_fields['image'])) {
          $is_image_field_populated = Helper::isFieldPopulated($item, $referenced_fields['image']);
          if ($is_image_field_populated) {
            $image = Helper::getFieldImageUrl($item, 'thumbnail_130x160', $referenced_fields['image']);
          }
        }

        // Get url + type from node external url field if exists and is
        // populated, otherwise from node url.
        $ext_url_field = "";
        if (!empty($referenced_fields['external'])) {
          $ext_url_field = $referenced_fields['external'];
        }
        $url = Helper::getEntityUrl($item, $ext_url_field);

        $links[] = [
          'image' => $image,
          'text' => $item->$referenced_fields['text']->value,
          'type' => $url['type'],
          'href' => $url['href'],
        ];
      }
    }

    return $links;
  }

  /**
   * Helper function to build a featured/links property of action finder.
   *
   * @param object $entity
   *   Entity that contains the featured/all actions entity reference field.
   * @param string $field
   *   The name of the feature/all actions entity reference field.
   * @param array $referenced_fields_map
   *   The array which contains the list of possible fields from the
   *   referenced entities.
   *
   * @return array
   *   The variable structure for the featured/links property.
   */
  public static function buildActionFinderSection($entity, $field, array $referenced_fields_map) {
    // Retrieves the entities referenced from the entity field.
    $referenced_entities = Helper::getReferencedEntitiesFromField($entity, $field);
    // Determines the field names to use on the referenced entity.
    $referenced_fields = Helper::getMappedReferenceFields($referenced_entities, $referenced_fields_map);
    // Populate a section (featured links or links).
    // @todo Add support for new label property, values: 'GUIDE', etc.
    $section = Helper::populateActionFinderLinks($referenced_entities, $referenced_fields);

    return $section;
  }

  /**
   * Check for icon twig templates.
   *
   * @param string $icon
   *   The icon to render.
   *
   * @return string
   *   The path to the icon twig file.
   */
  public static function getIconPath($icon) {
    $theme_path = \Drupal::theme()->getActiveTheme()->getPath();
    $path = DRUPAL_ROOT . '/' . $theme_path . '/patterns/atoms/';

    // Check if this template exists.
    if (file_exists($path . '07-user-added-icons/svg-' . strtolower($icon) . '.twig')) {
      return '@atoms/07-user-added-icons/svg-' . strtolower($icon) . '.twig';
    }

    if (file_exists($path . '05-icons/svg-' . strtolower($icon) . '.twig')) {
      return '@atoms/05-icons/svg-' . strtolower($icon) . '.twig';
    }

    if (file_exists($path . '06-icons-location/svg-loc-' . strtolower($icon) . '.twig')) {
      return '@atoms/06-icons-location/svg-' . strtolower($icon) . '.twig';
    }

    return '@atoms/05-icons/svg-marker.twig';
  }

  /**
   * Returns the current path alias.
   */
  public static function getCurrentPathAlias() {
    $path = \Drupal::service('path.current')->getPath();
    return \Drupal::service('path.alias_manager')->getAliasByPath($path);
  }

  /**
   * Returns the first line or paragraph of a string of text or raw HTML.
   *
   * @param string $string
   *   The text string or rawHTML string to be parsed.
   *
   * @return string
   *   The first line or paragraph of a string of text or raw HTML.
   */
  public static function getFirstParagraph($string) {
    if (!is_string($string)) {
      return FALSE;
    }

    // Get only the first html paragraph from the field value.
    if (preg_match("%(<p[^>]*>.*?</p>)%i", $string, $matches)) {
      return strip_tags($matches[1]);
    }

    // Get only the first plain text line.
    $plain_text_lines = preg_split("/\"\/\r\n|\r|\n\/\"/", $string);
    if ($plain_text_lines !== FALSE) {
      return $plain_text_lines[0];
    }

    return FALSE;
  }

  /**
   * Remove the appended cache string from a URL.
   *
   * @param string $url
   *   The URL to be sanitized.
   * @param string $cacheString
   *   The string to be sanitized from the URL.
   *
   * @return string
   *   The sanitized URL.
   */
  public static function sanitizeUrlCacheString($url, $cacheString) {
    if (!is_string($url) || !is_string($cacheString)) {
      return FALSE;
    }

    $pos = strpos($url, $cacheString);
    if ($pos !== FALSE) {
      $url = substr($url, 0, $pos);
    }

    return $url;
  }

  /**
   * Supplements page meta data from metatags.
   *
   * @param array $metadata
   *   Array of pageMetaData used by templates/includes/page-meta.html.twig.
   * @param array $map
   *   Array that maps metatags to page_meta_data keys in form tag=>key.
   *   Defaults to 'siteDescription'=>'siteDescription'.
   * @param string $meta_area
   *   The part of the metadata attachments array to search in.
   *   Defaults to html_head.
   *
   * @return array
   *   The array with appended metatag values.
   */
  public static function addMetatagData(array $metadata, array $map = [], $meta_area = 'html_head') {
    // Code largely copied from metatag.module/metatag_preprocess_html()
    if (!function_exists('metatag_is_current_route_supported') || !metatag_is_current_route_supported()) {
      return $metadata;
    }

    if (empty($map)) {
      $map = [
        'siteDescription' => 'siteDescription',
        'description' => 'description',
      ];
    }

    $attachments = drupal_static('metatag_attachments');
    if (is_null($attachments)) {
      $attachments = metatag_get_tags_from_route();
    }

    if (!$attachments || empty($attachments['#attached'][$meta_area])) {
      return $metadata;
    }

    foreach ($attachments['#attached'][$meta_area] as $metatag) {
      $tag_name = $metatag[1];
      if (isset($map[$tag_name])) {
        // It's safe to access the value directly because it was already
        // processed in MetatagManager::generateElements().
        $metadata[$map[$tag_name]] = $metatag[0]['#attributes']['content'];
      }
    }

    return $metadata;
  }

  /**
   * Returns the center lat/lng of a map.
   *
   * @param array $data
   *   Array of coords for each marker.
   *
   * @return array
   *   Return an array with center lat and lng.
   */
  public static function getCenterFromDegrees(array $data) {
    if (!is_array($data)) {
      return FALSE;
    }
    $num_coords = count($data);
    $iX = 0.0;
    $iY = 0.0;
    $iZ = 0.0;
    foreach ($data as $coord) {
      $lat = $coord[0] * pi() / 180;
      $lon = $coord[1] * pi() / 180;
      $a = cos($lat) * cos($lon);
      $b = cos($lat) * sin($lon);
      $c = sin($lat);
      $iX += $a;
      $iY += $b;
      $iZ += $c;
    }
    $iX /= $num_coords;
    $iY /= $num_coords;
    $iZ /= $num_coords;
    $lon = atan2($iY, $iX);
    $hyp = sqrt($iX * $iX + $iY * $iY);
    $lat = atan2($iZ, $hyp);
    return [
      $lat * 180 / pi(),
      $lon * 180 / pi(),
    ];
  }

  /**
   * Helper function to build Hours section.
   *
   * @param object $hours
   *   Send a field object.
   * @param string $align
   *   Which way to align statsCallout.
   *
   * @return array
   *   Return structured array.
   */
  public static function buildHours($hours, $align) {
    $rteElements = [];

    // Hours section.
    foreach ($hours as $index => $hour) {
      $entity = $hour->entity;

      if (!method_exists($entity, 'hasField')) {
        return FALSE;
      }

      // Creates a map of fields that are on the entitiy.
      $map = [
        'label' => ['field_label'],
        'time' => ['field_time_frame'],
        'hour' => ['field_hours'],
      ];

      // Determines which fieldnames to use from the map.
      $field = Helper::getMappedFields($entity, $map);

      // The first one is styled differently.
      if ($index == 0) {
        $rteElements[] = [
          'path' => '@molecules/callout-stats.twig',
          'data' => [
            'statsCallout' => [
              'pull' => $align,
              'stat' => Helper::fieldValue($entity, $field['time']),
              'content' => Helper::fieldValue($entity, $field['hour']),
            ],
          ],
        ];
        continue;
      }

      if (Helper::isFieldPopulated($entity, $field['label'])) {
        $rteElements[] = [
          'path' => '@atoms/04-headings/heading-4.twig',
          'data' => [
            'heading4' => [
              'text' => Helper::fieldValue($entity, $field['label']),
            ],
          ],
        ];
      }

      $rteElements[] = [
        'path' => '@atoms/11-text/paragraph.twig',
        'data' => [
          'paragraph' => [
            'text' => Helper::fieldValue($entity, $field['time']) . '<br/>' . Helper::fieldValue($entity, $field['hour']),
          ],
        ],
      ];
    }

    return [
      'title' => Helper::getReferenceField($hours, 'field_label'),
      'into' => '',
      'id' => Helper::getReferenceField($hours, 'field_label'),
      'path' => '@organisms/by-author/rich-text.twig',
      'data' => [
        'richText' => [
          'property' => '',
          'rteElements' => $rteElements,
        ],
      ],
    ];
  }

}
