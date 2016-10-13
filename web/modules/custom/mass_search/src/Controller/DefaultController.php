<?php

namespace Drupal\mass_search\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class DefaultController.
 *
 * @package Drupal\mass_search\Controller
 */
class DefaultController extends ControllerBase {

  /**
   * Search.
   *
   * @return array
   *   Render array that calls mass-search template and attaches results pg js
   */
  public function search() {
    return [
      '#theme' => 'mass_search',
      '#attached' => array(
        'library' => array(
          'mass_search/google-cse-results',
        ),
      ),
    ];
  }

}
