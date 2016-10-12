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
   * @return string
   *   Return Hello string.
   */
  public function search() {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: search')
    ];
  }

}
