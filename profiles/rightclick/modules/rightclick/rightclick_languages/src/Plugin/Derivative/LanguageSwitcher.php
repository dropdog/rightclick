<?php

/**
 * @file
 * Contains \Drupal\rightclick_languages\Plugin\Derivative\LanguageSwitcher.
 */

namespace Drupal\rightclick_languages\Plugin\Derivative;

use Drupal\Component\Plugin\Derivative\DeriverBase;
use Drupal\language\ConfigurableLanguageManagerInterface;

/**
 * Provides language switcher block plugin definitions for all languages.
 */
class LanguageSwitcher extends DeriverBase {

  /**
   * {@inheritdoc}
   */
  public function getDerivativeDefinitions($base_plugin_definition) {
    $language_manager = \Drupal::languageManager();

    if ($language_manager instanceof ConfigurableLanguageManagerInterface) {
      $info = $language_manager->getDefinedLanguageTypesInfo();
      $configurable_types = $language_manager->getLanguageTypes();
      foreach ($configurable_types as $type) {
        $this->derivatives[$type] = $base_plugin_definition;
        $this->derivatives[$type]['admin_label'] = t('Language switcher (@type)', array('@type' => $info[$type]['name']));
      }
      // If there is just one configurable type then change the title of the
      // block.
      if (count($configurable_types) == 1) {
        $this->derivatives[reset($configurable_types)]['admin_label'] = t('Rightclick Language Switcher Block');
      }
    }

    return parent::getDerivativeDefinitions($base_plugin_definition);
  }

}
