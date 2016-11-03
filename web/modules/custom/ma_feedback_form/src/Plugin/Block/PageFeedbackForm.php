<?php

namespace Drupal\ma_feedback_form\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'PageFeedbackForm' block.
 *
 * @Block(
 *  id = "page_feedback_form",
 *  admin_label = @Translation("Page feedback form"),
 * )
 */
class PageFeedbackForm extends BlockBase {


  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $build['page_feedback_form']['#markup'] = 'Implement PageFeedbackForm.';

    return $build;
  }

}
