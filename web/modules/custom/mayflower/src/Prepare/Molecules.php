<?php

namespace Drupal\mayflower\Prepare;

use Drupal\mayflower\Helper;

/**
 * Provides variable structure for mayflower molecules using prepare functions.
 *
 * Copyright 2017 Palantir.net, Inc.
 */
class Molecules {

  /**
   * Returns the actionSeqList variable structure for the mayflower template.
   *
   * @param object $entity
   *   The object that contains the fields for the sequential list.
   *
   * @see @molecules/action-sequential-list.twig
   *
   * @return array
   *   Returns an array of elements that contains:
   *   [[
   *     "title": "My Title",
   *     "rteElements": [[
   *       "path": "@atoms/11-text/paragraph.twig",
   *       "data": [
   *         "paragraph": [
   *           "text": "My Paragraph Text"
   *         ]
   *       ]
   *     ], ...]
   *   ], ...]
   */
  public static function prepareActionSeqList($entity) {
    $actionSeqLists = [];

    // Creates a map of fields on the parent entity.
    $map = [
      'reference' => ['field_action_step_numbered_items'],
    ];

    // Determines which fieldnames to use from the map.
    $fields = Helper::getMappedFields($entity, $map);

    // Retrieves the referenced field from the entity.
    $items = Helper::getReferencedEntitiesFromField($entity, $fields['reference']);

    // Creates a map of fields that are on the referenced entitiy.
    $referenced_fields_map = [
      'title'   => ['field_title'],
      'content' => ['field_content'],
    ];

    // Determines the fieldsnames to use on the refrenced entity.
    $referenced_fields = Helper::getMappedReferenceFields($items, $referenced_fields_map);

    // Creates the actionSeqLists array structure.
    if (!empty($items)) {
      foreach ($items as $id => $item) {
        $actionSeqLists[$id] = [];
        $actionSeqLists[$id]['title'] = Helper::fieldFullView($item, $referenced_fields['title']);
        $actionSeqLists[$id]['rteElements'][] = [
          'path' => '@atoms/11-text/paragraph.twig',
          'data' => [
            'paragraph' => [
              'text' => Helper::fieldFullView($item, $referenced_fields['content']),
            ],
          ],
        ];
      }
    }

    return $actionSeqLists;
  }

  /**
   * Returns the variables structure required to render calloutLinks template.
   *
   * @param object $entity
   *   The object that contains the link field.
   *
   * @see @molecules/callout-links.twig
   *
   * @return array
   *   Returns an array of items that contains:
   *    [[
   *      "text": "Order a MassParks Pass online through Reserve America",
   *      "type": internal/external,
   *      "href": URL,
   *      "info": ""
   *    ], ...]
   */
  public static function prepareCalloutLinks($entity) {
    $map = [
      'link' => ['field_link'],
    ];

    // Determines which fieldnames to use from the map.
    $fields = Helper::getMappedFields($entity, $map);

    // Creates array of links to use in calloutLinks.
    $calloutLinks = Helper::separatedLinks($entity, $fields['link']);

    return $calloutLinks;
  }

  /**
   * Returns the variables structure required to render icon links.
   *
   * @param object $entity
   *   The object that contains the fields.
   *
   * @see @molecules/icon-links.twig
   *
   * @return array
   *   Returns an array of items that contains:
   *    "iconLinks": [
   *      "items":[[
   *        "icon": /@path/to/icon.twig
   *        "link": [
   *          "href": "https://twitter.com/MassHHS",
   *          "text": "@MassHHS",
   *          "chevron": ""
   *        ]
   *      ], ...]
   *    ]
   */
  public static function prepareIconLinks($entity, $options) {
    $items = [];
    $map = [
      'socialLinks' => ['field_social_links'],
    ];

    // Determines which fieldnames to use from the map.
    $fields = Helper::getMappedFields($entity, $map);

    // Creates array of links with link parts.
    $links = Helper::separatedLinks($entity, $fields['socialLinks']);

    // Get icons for social links.
    $services = [
      'twitter',
      'facebook',
      'flickr',
      'blog',
      'linkedin',
      'google',
      'instagram',
    ];

    foreach ($links as $link) {
      $icon = '';

      foreach ($services as $key => $service) {
        if (strpos($link['href'], $service) !== FALSE) {
          $icon = $services[$key];
          break;
        }
      }

      $items[] = [
        'icon' => Helper::getIconPath($icon),
        'link' => $link,
      ];
    }

    return [
      'iconLinks' => [
        'items' => $items,
      ],
    ];
  }

  /**
   * Returns the variables structure required to render sectionLinks template.
   *
   * @param object $entity
   *   The object that contains the title/lede fields.
   *
   * @see @molecules/section-links.twig
   *
   * @return array
   *   Returns an array of items that contains:
   *    sectionLinks: {
   *      catIcon: {
   *        icon:
   *        type: string/path to icon
   *        small:
   *        type: boolean/true
   *      },
   *      title: {
   *        href:
   *        type: url/required
   *        text:
   *        type: string/required
   *      },
   *      description:
   *      type: string
   *      links: [{
   *        href:
   *        type: url/required
   *        text:
   *        type: string/required
   *      }]
   *    }
   */
  public static function prepareSectionLink($entity, $links) {
    $index = &drupal_static(__FUNCTION__);
    $index++;
    return [
      'id' => 'section_link_' . $index,
      'catIcon' => [
        'icon' => Helper::getIconPath($entity->field_icon_term->referencedEntities()[0]->get('field_sprite_name')->value),
        'small' => 'true',
      ],
      'title' => [
        'href' => '#',
        'text' => $entity->getTitle(),
      ],
      'description' => $entity->field_lede->value,
      'links' => $links,
    ];
  }

  /**
   * Returns the variables structure required to render contactGroup template.
   *
   * @param array $entities
   *   An array that containing the $entities for the group.
   * @param array $options
   *   An array containing options.
   *   array(
   *     type: string ('phone' || 'online' || 'email' || 'address' || 'fax')
   *   )
   * @param array &$contactInfo
   *   An array that containing the current schema contact info.
   *
   * @see @molecules/contact-group.twig
   *
   * @return array
   *   Returns an array of items that contains:
   *    contactGroup: {
   *      icon: string / path to icon,
   *      name: string ('Phone' || 'Online' || 'Address' || 'Fax') / optional
   *      items: [{
   *        type: string ('phone' || 'online' || 'email' || 'address' || 'fax' )
   *        property: string / optional
   *        label: string / optional
   *        value: string (html allowed) / required
   *        link: string / optional
   *        details: string / optional
   *      }]
   *    }
   */
  public static function prepareContactGroup($entities, $options, &$contactInfo) {
    $type = $options['type'];

    switch ($type) {
      case 'address':
        $name = t('Address');
        $icon = '@atoms/05-icons/svg-marker.twig';
        break;

      case 'online':
        $name = t('Online');
        $icon = '@atoms/05-icons/svg-laptop.twig';
        break;

      case 'fax':
        $name = t('Fax');
        $icon = '@atoms/05-icons/svg-fax-icon.twig';
        break;

      case 'phone':
        $name = t('Phone');
        $icon = '@atoms/05-icons/svg-phone.twig';
        break;

      default:
        $name = '';
        $icon = '';
        break;

    }

    $contactGroup = [
      'name' => $name,
      'icon' => $icon,
      'hidden' => '',
      'items' => [],
    ];

    foreach ($entities as $entity) {
      $item = [];

      $item['type'] = $type;

      // Creates a map of fields that are on the entitiy.
      $map = [
        'details' => ['field_caption'],
        'label' => ['field_label'],
        'value' => ['field_address_text', 'field_phone', 'field_fax'],
        'link' => ['field_link_single', 'field_email'],
      ];

      // Determines which fieldnames to use from the map.
      $fields = Helper::getMappedFields($entity, $map);

      if (array_key_exists('details', $fields) && Helper::isFieldPopulated($entity, $fields['details'])) {
        $item['details'] = Helper::fieldFullView($entity, $fields['details']);
      }

      if (array_key_exists('label', $fields) && Helper::isFieldPopulated($entity, $fields['label'])) {
        $item['label'] = Helper::fieldFullView($entity, $fields['label']);
      }

      if ($type == 'address') {
        $item['value'] = Helper::fieldFullView($entity, $fields['value']);
        $item['link'] = 'https://maps.google.com/?q=' . urlencode(Helper::fieldValue($entity, $fields['value']));

        // Respect first address provided if present.
        if (!$contactInfo['address']) {
          $contactInfo['address'] = Helper::fieldValue($entity, $fields['value']);
          $contactInfo['hasMap'] = $item['link'];
        }
      }
      elseif ($type == 'fax' || $type == 'phone') {
        $item['value'] = Helper::fieldValue($entity, $fields['value']);
        $item['link'] = str_replace(['+', '-'], '', filter_var(Helper::fieldValue($entity, $fields['value']), FILTER_SANITIZE_NUMBER_INT));

        // Respect first fax and phone number provided if present.
        if (!$contactInfo[$type]) {
          $contactInfo[$type] = "+1" . $item['link'];
        }
      }
      elseif ($type == 'online') {
        if ($entity->getType() == 'online_email') {
          $link = Helper::separatedEmailLink($entity, $fields['link']);
          $item['link'] = $link['href'];
          $item['value'] = $link['text'];
          $item['type'] = 'email';

          // Respect first email address provided if present.
          if (!$contactInfo['email']) {
            $contactInfo['email'] = $item['link'];
          }
        }
        else {
          $link = Helper::separatedLinks($entity, $fields['link']);
          $item['link'] = $link[0]['href'];
          $item['value'] = $link[0]['text'];
        }
      }

      $contactGroup['items'][] = $item;
    }

    return $contactGroup;
  }

  /**
   * Returns the variables structure required to render calloutLinks template.
   *
   * @param object $entity
   *   The object that contains the link field.
   * @param array $options
   *   An array containing options.
   *   array(
   *     display_title: Boolean / require.
   *   )
   *
   * @see @molecules/contact-us.twig
   *
   * @return array
   *   Returns an array of items that contains:
   *    contactUs: array(
   *      schemaSd: array(
   *        property: string / required,
   *        type: string / required,
   *      ),
   *     title: array(
   *       href: string (url) / optional
   *       text: string (_blank || '') / optional
   *       chevron: boolean / required
   *     ),
   *     groups: [
   *       contactGroup see @molecules/contact-group
   *     ]
   *   )
   */
  public static function prepareContactUs($entity, $options) {
    $title = '';

    // Create contactInfo object for governmentOrg schema.
    $contactInfo = [
      "address" => "",
      "hasMap" => "",
      "phone" => "",
      "fax" => "",
      "email" => "",
    ];

    // Creates a map of fields that are on the entitiy.
    $reference_map = [
      'address' => ['field_ref_address'],
      'phone' => ['field_ref_phone_number'],
      'online' => ['field_ref_links'],
      'fax' => ['field_ref_fax_number'],
    ];

    $map = [
      'title' => ['field_display_title'],
    ];

    // Determines which fieldnames to use from the map.
    $referenced_fields = Helper::getMappedFields($entity, $reference_map);

    $groups = [];

    foreach ($referenced_fields as $id => $field) {
      if (Helper::isFieldPopulated($entity, $field)) {
        $items = Helper::getReferencedEntitiesFromField($entity, $field);
        $groups[] = Molecules::prepareContactGroup($items, ['type' => $id], $contactInfo);
      }
    }

    $fields = Helper::getMappedFields($entity, $map);

    $display_title = $options['display_title'];

    if (Helper::isFieldPopulated($entity, $fields['title']) && $display_title != FALSE) {
      $title = [
        'href' => '',
        'text' => $entity->$fields['title']->value,
        'chevron' => FALSE,
      ];
    }

    return [
      'schemaSd' => [
        'property' => 'containedInPlace',
        'type' => 'CivicStructure',
      ],
      'schemaContactInfo' => $contactInfo,
      // TODO: Needs validation if empty or not.
      'title' => $title,
      'groups' => $groups,
    ];
  }

}
