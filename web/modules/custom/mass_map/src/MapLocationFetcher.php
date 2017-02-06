<?php

namespace Drupal\mass_map;

use Drupal\paragraphs\Entity\Paragraph;

/**
 * Class MapLocationFetcher.
 *
 * @package Drupal\mass_map
 */
class MapLocationFetcher {

  /**
   * Get location information from nodes.
   *
   * @param array $nids
   *    A list of nodes containing locations.
   *
   * @return array
   *    An array of location data and addresses keyed by the nid it belongs to.
   */
  public function getLocations($nids) {
    $node_storage = \Drupal::entityManager()->getStorage('node');
    $nodes = $node_storage->loadMultiple($nids);

    $locations = array();

    foreach ($nodes as $node) {
      $nid = $node->nid->value;

      // Extract location info from right rail layout.
      if ($node->getType() == 'action') {
        $locations[$nid] = $this->getActionLocation($node);
      }
      // Extract location info from stacked layout.
      if ($node->getType() == 'stacked_layout') {
        $locations[$nid] = $this->getStackedLayoutLocation($node);
      }

      // Get the node title as a link to the node.
      $locations[$nid]['titleLink'] = $node->toLink()->toString();
      // Get the description for the node.
      $locations[$nid]['lede'] = $node->field_lede->value;

    }

    return $locations;

  }

  /**
   * Get location information from Right Rail node.
   *
   * @param object $node
   *   Right Rail node.
   *
   * @return array
   *   And array containing the address and location information.
   */
  private function getActionLocation($node) {
    $address = NULL;
    $location = NULL;

    // The map could be in one of a couple of fields.
    // Use map from the banner if it contains one.
    foreach ($node->field_action_banner as $banner_id) {
      $banner = Paragraph::load($banner_id->target_id);
      foreach ($banner->field_full_bleed_ref as $full_bleed_id) {
        $full_bleed = Paragraph::load($full_bleed_id->target_id);
        if ($full_bleed->getType() == 'map') {
          $location = $full_bleed->field_map->getValue();
          $location = reset($location);
          break;
        }
      }
      if (!empty($location)) {
        break;
      }
    }
    // If it is not in the header get map point from the details field.
    if (empty($location)) {
      foreach ($node->field_action_details as $detail_id) {
        $detail = Paragraph::load($detail_id->target_id);
        if ($detail->getType() == 'map') {
          $location = $detail->field_map->getValue();
          $location = reset($location);
          break;
        }
      }
    }
    // The address could be in one of a couple of fields.
    // Use address from the header if it contains one.
    foreach ($node->field_action_header as $header_id) {
      $header = Paragraph::load($header_id->target_id);
      if ($group_address = $this->getAddressContactGroup($header)) {
        $address = $group_address;
        break;
      }
    }
    if (empty($address)) {
      // Next place to check for the address is the contact group field.
      foreach ($node->field_contact_group as $group_id) {
        $group = Paragraph::load($group_id->target_id);
        if ($group->getType() == 'contact_group') {
          if ($group_address = $this->getAddressContactGroup($group)) {
            $address = $group_address;
            break;
          }
        }
      }
    }
    if (empty($address)) {
      // Last we check the sidebar for an address.
      foreach ($node->field_action_sidebar as $sidebar_id) {
        $sidebar = Paragraph::load($sidebar_id->target_id);
        if ($sidebar->getType() == 'contact_group') {
          if ($group_address = $this->getAddressContactGroup($sidebar)) {
            $address = $group_address;
            break;
          }
        }
      }
    }
    return array(
      'address' => $address,
      'location' => $location,
    );
  }

  /**
   * Get location information from Stacked Layout node.
   *
   * @param object $node
   *   Stacked Layout node.
   *
   * @return array
   *   And array containing the address and location information.
   */
  private function getStackedLayoutLocation($node) {
    $address = NULL;
    $location = NULL;

    // Get address from header if it has one.
    foreach ($node->field_action_header as $header_id) {
      $header = Paragraph::load($header_id->target_id);
      if ($group_address = $this->getAddressContactGroup($header)) {
        $address = $group_address;
        break;
      }
    }
    foreach ($node->field_bands as $band_id) {
      // Search the main bands field for location and address information.
      $band = Paragraph::load($band_id->target_id);
      foreach ($band->field_main as $band_main_id) {
        $band_main = Paragraph::load($band_main_id->target_id);
        if ($band_main->getType() == 'map') {
          $location = $band_main->field_map->getValue();
          $location = reset($location);
          break;
        }
        if ($band_main->getType() == 'contact_group' && !empty($address)) {
          if ($group_address = $this->getAddressContactGroup($band_main)) {
            $address = $group_address;
            break;
          }
        }
      }
      // Check the right rail of 2up bands for address info.
      if (empty($address) && $band->getType() == '2up_stacked_band') {
        foreach ($band->field_right_rail as $band_rail_id) {
          $band_rail = Paragraph::load($band_rail_id->target_id);
          if ($band_rail->getType() == 'contact_group' && !empty($address)) {
            if ($group_address = $this->getAddressContactGroup($band_rail)) {
              $address = $group_address;
              break;
            }
          }
        }
      }
    }
    return array(
      'address' => $address,
      'location' => $location,
    );
  }

  /**
   * Get address out of a contact group if it contains one.
   *
   * @param object $contact_group
   *   The contact group paragraph object.
   *
   * @return string
   *   The address if the group contains one.
   */
  private function getAddressContactGroup($contact_group) {
    $address = NULL;
    foreach ($contact_group->field_contact_info as $contact_info_id) {
      $contact_info = Paragraph::load($contact_info_id->target_id);
      // Check contact info paragraph for address.
      if ($contact_info->field_address) {
        $address = $contact_info->field_address->value;
        break;
      }
    }
    return $address;
  }

}
