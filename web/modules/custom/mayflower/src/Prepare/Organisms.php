<?php

namespace Drupal\mayflower\Prepare;

use Drupal\mayflower\Helper;

/**
 * Provides variable structure for mayflower organisms using prepare functions.
 *
 * Copyright 2017 Palantir.net, Inc.
 */
class Organisms {

  /**
   * Returns the variables structure required to render an action finder.
   *
   * @param object $entity
   *   The object that contains the necessary fields.
   * @param array $options
   *   The object that contains static data and other options.
   *
   * @see @organisms/by-author/action-finder.twig
   *
   * @return array
   *   Returns an array of items that contain:
   *   "actionFinder": [
   *      "bgWide":"/assets/images/placeholder/1600x600-lighthouse-blur.jpg",
   *      "bgNarrow":"/assets/images/placeholder/800x800.png",
   *      "title": "What Would You Like to Do?",
   *      "featuredHeading":"Featured:",
   *      "generalHeading":"All Actions & Guides:",
   *      "seeAll": [
   *        "type": "external",
   *        "href": "http://www.google.com",
   *        "text": "See all EOHHS’s programs and services on
   *                 classic Mass.gov",
   *        "info": ""
   *      ],
   *      "featuredLinks": [[
   *        "image": "/assets/images/placeholder/130x160.png",
   *        "text": "Getting Outdoors",
   *        "type": "",
   *        "href": "#"
   *      ], ... ],
   *      "links": [[
   *        "image": "",
   *        "text": "Find a State Park",
   *        "type": "",
   *        "href": "#"
   *      ], ... ]
   *    ]
   */
  public static function prepareActionFinder($entity, array $options) {
    $map = [
      'bgWide' => ['field_action_set__bg_wide'],
      'bgNarrow' => ['field_action_set__bg_narrow'],
      'featured_actions' => ['field_ref_actions_3'],
      'all_actions' => ['field_ref_actions_6'],
      'see_all' => ['field_link'],
    ];

    // Determines which field names to use from the map.
    $fields = Helper::getMappedFields($entity, $map);

    // Creates a map of fields that are on the referenced entity.
    $referenced_fields_map = [
      'image' => ['field_photo'],
      'text' => ['title', 'field_title'],
      'external' => ['field_external_url'],
      'href' => [],
    ];

    $featured_heading = '';
    $featured_links = '';
    // @todo revisit Mayflower pattern to render this markup conditionally
    if (Helper::isFieldPopulated($entity, $fields['featured_actions'])) {
      $featured_heading = $options['featuredHeading'];
      $featured_links = Helper::buildActionFinderSection($entity, $fields['featured_actions'], $referenced_fields_map);
    }

    $all_heading = '';
    $links = '';
    // @todo revisit Mayflower pattern to render this markup conditionally
    if (Helper::isFieldPopulated($entity, $fields['all_actions'])) {
      $all_heading = $options['generalHeading'];
      $links = Helper::buildActionFinderSection($entity, $fields['all_actions'], $referenced_fields_map);
    }

    // Build see all link.
    // @todo Consider making this its own prepare function
    $see_all = NULL;
    if (Helper::isFieldPopulated($entity, $fields['see_all'])) {
      // @todo update mayflower_separated_links so we don't need [0]
      $see_all = Helper::separatedLinks($entity, $fields['see_all'])[0];
    }

    // Get desktop image, required when this component is used.
    $desktop_image = Helper::getFieldImageUrl($entity, 'action_finder_mobile', $fields['bgWide']);

    // Use the desktop image by default if there is no mobile image.
    $mobile_image = $desktop_image;

    // Get mobile image if exists use mobile image and mobile image style.
    if (Helper::isFieldPopulated($entity, $fields['bgNarrow'])) {
      $mobile_image = Helper::getFieldImageUrl($entity, 'action_finder_mobile', $fields['bgNarrow']);
    }

    // Build actionFinder data array.
    return [
      'actionFinder' => [
        'title' => $options["title"],
        'featuredHeading' => $featured_heading,
        'generalHeading' => $all_heading,
        'bgWide' => $desktop_image,
        'bgNarrow' => $mobile_image,
        'seeAll' => $see_all,
        'featuredLinks' => $featured_links,
        'links' => $links,
      ],
    ];
  }

  /**
   * Returns the variables structure required to render an action header.
   *
   * @param object $entity
   *   The object that contains the necessary fields.
   * @param object $options
   *   The object that contains static data and other options.
   * @param object $widgets
   *   Contains array of widget components prepared outside of this function.
   *   "widgets": [[
   *     "path": "[path/to/pattern]",
   *     "data": []
   *   ], ... ].
   *
   * @see @organisms/by-template/action-header.twig
   *
   * @return array
   *   Returns an array of items.
   *    "actionHeader": [
   *      "pageHeader": [
   *        "title": "Executive Office of Health and Human Services",
   *        "titleNote": "(EOHHS)",
   *        "subTitle": "",
   *        "rteElements": "",
   *        "headerTags": ""
   *      ],
   *      "contactUs": [],
   *      "divider": false / true,
   *      "widgets": [[
   *         "path": "[path/to/pattern]",
   *         "data": []
   *       ], ... ]
   *    ]
   */
  public static function prepareActionHeader($entity, $options, $widgets) {
    // Create the map of all possible field names to use.
    $map = [
      'title' => ['title'],
      'titleNote' => ['field_title_sub_text'],
      'subTitle' => ['field_sub_title'],
      'contactUs' => ['field_ref_contact_info'],
    ];

    // Determines which field names to use from the map.
    $fields = Helper::getMappedFields($entity, $map);

    $contactUs = [];

    $contact_items = Helper::getReferencedEntitiesFromField($entity, $fields['contactUs']);

    foreach ($contact_items as $contact_item) {
      $contactUs = Molecules::prepareContactUs($contact_item, ['display_title' => FALSE]);
    }

    // Create the actionHeader data structure.
    $actionHeader = [
      'pageHeader' => [
        'title' => $entity->$fields['title']->value,
        'titleNote' => $entity->$fields['titleNote']->value,
        'subTitle' => $entity->$fields['subTitle']->value,
      ],
      'divider' => $options['divider'],
      'contactUs' => $contactUs,
      'widgets' => $widgets,
    ];

    return $actionHeader;
  }

  /**
   * Returns the variables structure required to render a sidebarContact.
   *
   * @param object $entity
   *   The object that contains the necessary fields.
   *
   * @see @organisms/by-author/sidebar-contact.twig
   *
   * @return array
   *   Returns an array of items.
   *   'sidebarContact': array(
   *      'coloredHeading': array(
   *        'text': string / required,
   *        'color': string / optional
   *      ),
   *      'items': array(
   *         contactUs see @molecules/contact-us
   *      ).
   */
  public static function prepareSidebarContact($entity) {
    $items = [];

    // Create the map of all possible field names to use.
    $map = [
      'items' => ['field_ref_contact_info_1'],
    ];

    // Determines which field names to use from the map.
    $fields = Helper::getMappedFields($entity, $map);

    $contactUs = [];

    $ref_items = Helper::getReferencedEntitiesFromField($entity, $fields['items']);

    foreach ($ref_items as $item) {
      $items[] = ['contactUs' => Molecules::prepareContactUs($item, ['display_title' => TRUE])];
    }

    // Create the actionHeader data structure.
    $sidebarContact = [
      'coloredHeading' => [
        'text' => t('Contact'),
        'color' => 'green',
      ],
      'items' => $items,
    ];

    return $sidebarContact;
  }

  /**
   * Returns the variables structure required to render link list.
   *
   * @param object $entity
   *   The object that contains the fields.
   *
   * @see @organisms/by-author/link-list.twig
   *
   * @return array
   *   Returns an array of items that contains:
   *    "linkList" : [
   *      "title": "Related Organizations on pilot.mass.gov",
   *      "links" : [[
   *        "url":"#",
   *        "text":"Executive Office of Elder Affairs"
   *      ],... ]
   *    ]
   */
  public static function prepareLinkList($entity, $title) {
    // @todo Use $options[] as 2nd parameter in prepare functions

    // Roll up the link list.
    $links = [];
    foreach ($entity as $link) {
      $links[] = [
        'url' => $link->toURL()->toString(),
        'text' => $link->get('title')->value,
      ];
    }

    return [
      'linkList' => [
        'title' => $title,
        'links' => $links,
      ],
    ];
  }

  /**
   * Returns the variables structure required to render a page banner.
   *
   * @param object $entity
   *   The object that contains the necessary fields.
   * @param object $options
   *   The object that contains static data and other options.
   *
   * @see @organisms/by-template/page-banner.twig
   *
   * @return array
   *   Returns an array of items that contains:
   *    [
   *      "bgWide":"/assets/images/placeholder/1600x400.png"
   *      "bgNarrow":"/assets/images/placeholder/800x400.png",
   *      "size": "large",
   *      "icon": null,
   *      "title": "Executive Office of Health and Human Services",
   *      "titleSubText": "(EOHHS)"
   *    ]
   */
  public static function preparePageBanner($entity, $options) {
    $pageBanner = [];

    // Create the map of all possible field names to use.
    $map = [
      'title' => ['title'],
      'title_sub_text' => ['field_title_sub_text'],
      'bg_wide' => ['field_bg_wide'],
      'bg_narrow' => ['field_bg_narrow'],
    ];

    // Determines which field names to use from the map.
    $fields = Helper::getMappedFields($entity, $map);

    // Use helper function to get the image url of a given image style.
    $pageBanner['bgWide'] = Helper::getFieldImageUrl($entity, 'action_banner_large', $fields['bg_wide']);
    $pageBanner['bgNarrow'] = Helper::getFieldImageUrl($entity, 'action_banner_small', $fields['bg_narrow']);

    // @todo determine how to handle options vs field value (check existence, order of importance, etc.)
    $pageBanner['size'] = $options['size'];
    $pageBanner['icon'] = $options['icon'];

    $pageBanner['title'] = $entity->$fields['title']->value;

    $title_sub_text = '';
    if (Helper::isFieldPopulated($entity, $fields['title_sub_text'])) {
      $title_sub_text = $entity->$fields['title_sub_text']->value;
    }
    $pageBanner['titleSubText'] = $title_sub_text;

    return $pageBanner;
  }

  /**
   * Returns the variables structure required to render section Three Up.
   *
   * @param object $entity
   *   The object that contains the fields.
   * @param string $title
   *   A string containing text.
   *
   * @see @organsms/by-author/sections-three-up
   *
   * @return array
   *   Returns structured array.
   */
  public static function prepareSectionThreeUp($entity, $title) {
    // @todo Use $options[] as 2nd parameter in prepare functions

    return [
      'sectionThreeUp' => [
        'compHeading' => [
          'title' => $title,
          'sub' => '',
          'color' => '',
          'id' => '',
          'centered' => '',
        ],
        'sections' => mayflower_prepare_topic_cards($entity),
      ],
    ];
  }

}
