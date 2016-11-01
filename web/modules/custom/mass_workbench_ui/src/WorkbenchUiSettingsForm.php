<?php

namespace Drupal\mass_workbench_ui;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure hello settings for this site.
 */
class WorkbenchUiSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'workbench_ui_admin_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'mass_workbench.ui',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('mass_workbench.ui');

    $form['workbench_ui_remove_preview_button'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Remove node preview button'),
      '#default_value' => $config->get('remove_preview_button'),
      '#description' => t('Removes the preview button found on node edit forms.'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('mass_workbench.ui')
      ->set('remove_preview_button', $form_state->getValue('workbench_ui_remove_preview_button'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
