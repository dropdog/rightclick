<?php
/**
 * @file
 * Contains \Drupal\admin_toolbar_tools\Controller\ToolbarController.
 *
 */

namespace Drupal\admin_toolbar_tools\Controller;

//Use the necessary classes
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\CronInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Menu\ContextualLinkManager;
use Drupal\Core\Menu\LocalActionManager;
use Drupal\Core\Menu\LocalTaskManager;
use Drupal\Core\Menu\MenuLinkManager;

/**
 * Class ToolbarController
 * @package Drupal\admin_toolbar_tools\Controller
 */
class ToolbarController extends ControllerBase {
  /**
   * The cron service.
   *
   * @var \Drupal\Core\CronInterface
   */
  protected $cron;

  protected $menuLinkManager;
  protected $contextualLinkManager;
  protected $localTaskLinkManager;
  protected $localActionLinkManager;

  /**
   * Constructs a CronController object.
   *
   * @param \Drupal\Core\CronInterface $cron
   *   The cron service.
   */
  public function __construct(CronInterface $cron,
                              MenuLinkManager $menuLinkManager,
                              ContextualLinkManager $contextualLinkManager,
                              LocalTaskManager $localTaskLinkManager,
                              LocalActionManager $localActionLinkManager) {
    $this->cron = $cron;
    $this->menuLinkManager = $menuLinkManager;
    $this->contextualLinkManager = $contextualLinkManager;
    $this->localTaskLinkManager = $localTaskLinkManager;
    $this->localActionLinkManager = $localActionLinkManager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('cron'),
      $container->get('plugin.manager.menu.link'),
      $container->get('plugin.manager.menu.contextual_link'),
      $container->get('plugin.manager.menu.local_task'),
      $container->get('plugin.manager.menu.local_action')
    );
  }
  //Reload the previous page.
  public function reload_page() {
    $request = \Drupal::request();
    return $request->server->get('HTTP_REFERER');
  }

  //Flush all caches.
  public function flushAll() {
    drupal_flush_all_caches();
    drupal_set_message($this->t('All cache cleared.'));
    return new RedirectResponse($this->reload_page());
  }

  //This function flush css and javascript caches.
  public function flush_js_css() {
    \Drupal::state()
      ->set('system.css_js_query_string', base_convert(REQUEST_TIME, 10, 36));
    drupal_set_message($this->t('CSS and JavaScript cache cleared.'));
    return new RedirectResponse($this->reload_page());
  }

  //This function flush plugins caches.
  public function flush_plugins() {
    // Clear all plugin caches.
    \Drupal::service('plugin.cache_clearer')->clearCachedDefinitions();
    drupal_set_message($this->t('Plugin cache cleared.'));
    return new RedirectResponse($this->reload_page());
  }

  // Reset all static caches.
  public function flush_static() {
    drupal_static_reset();
    drupal_set_message($this->t('All static caches cleared.'));
    return new RedirectResponse($this->reload_page());
  }

// Clears all cached menu data.
  public function flush_menu() {
    menu_cache_clear_all();
    $this->menuLinkManager->rebuild();
    $this->contextualLinkManager->clearCachedDefinitions();
    $this->localTaskLinkManager->clearCachedDefinitions();
    $this->localActionLinkManager->clearCachedDefinitions();
    drupal_set_message($this->t('All cached menu data cleared.'));
    return new RedirectResponse($this->reload_page());
  }

// this function allow to access in documentation via admin_toolbar module
  public function drupal_org() {
    $response = new RedirectResponse("https://www.drupal.org");
    $response->send();
    return $response;
  }

  //This function display the administration link Development
  public function development() {
    return new RedirectResponse('/admin/structure/menu/');
  }

  // this function allow to access in documentation(list changes of the different versions of drupal core) via admin_toolbar module.
  public function list_changes() {
    $response = new RedirectResponse("https://www.drupal.org/list-changes");
    $response->send();
    return $response;
  }

  //this function allow to add
  public function documentation() {
    $response = new RedirectResponse("https://api.drupal.org/api/drupal/8");
    $response->send();
    return $response;
  }

  public function runCron() {
    $this->cron->run();
    drupal_set_message($this->t('Cron ran successfully.'));
    return new RedirectResponse($this->reload_page());
  }


}