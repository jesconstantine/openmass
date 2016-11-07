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
//    $build = [];
//    $build['page_feedback_form']['#type'] = 'text_format';
//    $build['page_feedback_form']['#markup'] = '';
//    $build['page_feedback_form']['#attached']['library'][] = 'ma_feedback_form/feedback-form-css';

    return array(
      '#theme' => 'ma_feedback_form',
      '#attached' => array(
        'library' =>  array(
          'ma_feedback_form/feedback-form-css'
        ),
      ),
    );
  }

}
