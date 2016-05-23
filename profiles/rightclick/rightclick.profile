<?php
/**
 * @file
 * Enables modules and site configuration for the Dropdog installation.
 */

use Drupal\Core\Form\FormStateInterface;

/**
 * Implements hook_form_FORM_ID_alter() for install_configure_form().
 *
 * Allows the profile to alter the site configuration form.
 */
function rightclick_form_install_configure_form_alter(&$form, FormStateInterface $form_state) {

  $date = date('d/m/Y h:i:s a');

  $form['site_information']['site_name']['#value'] = t('Rightclick') . " " . $date;
  $form['regional_settings']['site_default_country']['#default_value'] = 'GR';
  $form['regional_settings']['date_default_timezone']['#default_value'] = t('Europe/Athens');
  $form['update_notifications']['update_status_module']['2']['#default_value'] = '';
}
