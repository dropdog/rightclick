<?php

/**
 * @file
 * Contains \Drupal\defaultcontent\LinkManager\TypeLinkManager.
 */

namespace Drupal\defaultcontent\LinkManager;

use Drupal\rest\LinkManager\TypeLinkManager as RestTypeLinkManager;

/**
 * Creates a type link manager that references drupal.org as the domain.
 */
class TypeLinkManager extends RestTypeLinkManager {

  /**
   * {@inheritdoc}
   */
  public function getTypeUri($entity_type, $bundle, $context = array()) {
    // Make the base path refer to drupal.org.
    return "http://drupal.org/rest/type/$entity_type/$bundle";
  }

}