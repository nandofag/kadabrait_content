<?php

namespace Drupal\kadabrait_content\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines a form that configures kadabrait content module settings.
 */
class KadabraitContentConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'kadabrait_content_config_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'kadabrait_content.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('kadabrait_content.settings');

    $form['kadabrait_content_settings'] = [
      '#type'  => 'fieldset',
      '#title' => $this->t('Kadabrait Content Settings'),
    ];

    $form['kadabrait_content_settings']['items_per_page'] = [
      '#type' => 'number',
      '#title' => $this->t('Items per Page'),
      '#default_value' => $config->get('kadabrait_content.page_limit_content'),
    ];

    $form['kadabrait_content_settings']['items_per_block'] = [
      '#type' => 'number',
      '#title' => $this->t('Items per Block'),
      '#default_value' => $config->get('kadabrait_content.block_limit_content'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
     $completeForm = $form_state->getCompleteForm();
    if (empty($completeForm['kadabrait_content_settings']['items_per_page']['#value'])) {
      $form_state->setErrorByName('items_per_page', $this->t('The value of "Items per page" field must be greater than 0.'));
    }
    if (empty($completeForm['kadabrait_content_settings']['items_per_block']['#value'])) {
      $form_state->setErrorByName('items_per_block', $this->t('The value of "Items per block" field must be greater than 0.'));
    }

  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    $config = $this->config('kadabrait_content.settings');
    $config->set('kadabrait_content.page_limit_content', $values['items_per_page']);
    $config->set('kadabrait_content.block_limit_content', $values['items_per_block']);
    
    $config->save();
  }

}
