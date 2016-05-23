<?php

/**
 * @file
 * Contains \Drupal\dropdog_languages\Plugin\Block\LanguageSwitcher.
 */


namespace Drupal\rightclick_languages\Plugin\Block;

use Drupal\Core\Url;
use Drupal\language\Plugin\Block\LanguageBlock;

/**
 * Provides the 'Rightclick Language Switcher' Block
 *
 * @Block(
 *   id = "languageswitcher_block",
 *   admin_label = @Translation("Rightclick Language Switcher Block"),
 *   category = @Translation("Rightclick"),
 *   deriver = "Drupal\rightclick_languages\Plugin\Derivative\LanguageSwitcher"
 * )
 */

class LanguageSwitcher extends LanguageBlock {

  /**
   * {@inheritdoc}
   */
  public function build() {

    $build = parent::build();

    // Apply the dropbutton functionality.
    $build['#type'] = 'dropbutton';

    // Get the current language to use it in the links manipulation.
    $current_language = \Drupal::languageManager()->getCurrentLanguage()->getId();

    /**
     * Move the active link (array) to index 0,
     * so that the link in the language switcher
     * matches the current language.
     */
    array_unshift($build['#links'], $build['#links'][$current_language]);

    // Unset the link to avoid duplicates.
    unset($build['#links'][$current_language]);

    // Manipulate the language titles.
    if (isset($build['#links']['zh-hans']['title'])) {
      $build['#links']['zh-hans']['title'] = 'Chinese';
    }
    if (isset($build['#links']['sr']['title'])) {
      $build['#links']['sr']['title'] = 'Cрпски';
    }

    return $build;
  }
}
