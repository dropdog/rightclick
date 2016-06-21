<?php

/**
 * @file
 * Contains \Drupal\rightclick_share_links\Plugin\Block\ShareBlock.
 */

namespace Drupal\rightclick_share_links\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Provides a 'ShareBlock' block.
 *
 * @Block(
 *  id = "share_block",
 *  admin_label = @Translation("Share block"),
 * )
 */
class ShareBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['share_facebook'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Facebook'),
      '#description' => $this->t(''),
      '#default_value' => isset($this->configuration['share_facebook']) ? $this->configuration['share_facebook'] : '',
      '#weight' => '0',
    );
    $form['share_googleplus'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Google Plus'),
      '#description' => $this->t(''),
      '#default_value' => isset($this->configuration['share_googleplus']) ? $this->configuration['share_googleplus'] : '',
      '#weight' => '0',
    );
    $form['share_instagram'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Instagram'),
      '#description' => $this->t(''),
      '#default_value' => isset($this->configuration['share_instagram']) ? $this->configuration['share_instagram'] : '',
      '#weight' => '0',
    );
    $form['share_twitter'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Twitter'),
      '#description' => $this->t(''),
      '#default_value' => isset($this->configuration['share_twitter']) ? $this->configuration['share_twitter'] : '',
      '#weight' => '0',
    );
    $form['share_pinterest'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Pinterest'),
      '#description' => $this->t(''),
      '#default_value' => isset($this->configuration['share_pinterest']) ? $this->configuration['share_pinterest'] : '',
      '#weight' => '0',
    );
    $form['share_tripadvisor'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Tripadvisor'),
      '#description' => $this->t(''),
      '#default_value' => isset($this->configuration['share_tripadvisor']) ? $this->configuration['share_tripadvisor'] : '',
      '#weight' => '0',
    );
    $form['share_youtube'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Youtube'),
      '#description' => $this->t(''),
      '#default_value' => isset($this->configuration['share_youtube']) ? $this->configuration['share_youtube'] : '',
      '#weight' => '0',
    );
    $form['share_linkedin'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Linkedin'),
      '#description' => $this->t(''),
      '#default_value' => isset($this->configuration['share_linkedin']) ? $this->configuration['share_linkedin'] : '',
      '#weight' => '0',
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['share_facebook'] = $form_state->getValue('share_facebook');
    $this->configuration['share_googleplus'] = $form_state->getValue('share_googleplus');
    $this->configuration['share_instagram'] = $form_state->getValue('share_instagram');
    $this->configuration['share_twitter'] = $form_state->getValue('share_twitter');
    $this->configuration['share_pinterest'] = $form_state->getValue('share_pinterest');
    $this->configuration['share_tripadvisor'] = $form_state->getValue('share_tripadvisor');
    $this->configuration['share_youtube'] = $form_state->getValue('share_youtube');
    $this->configuration['share_linkedin'] = $form_state->getValue('share_linkedin');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    /*
     * Get Current URL
     */
    global $base_url;
    $current_path = \Drupal::service('path.current')->getPath();
    $page_url = $base_url . \Drupal::service('path.alias_manager')
        ->getAliasByPath($current_path);

    /*
     * Get Page Title
     */
    $request = \Drupal::request();
    if ($route = $request->attributes->get(\Symfony\Cmf\Component\Routing\RouteObjectInterface::ROUTE_OBJECT)) {
      $page_title = \Drupal::service('title_resolver')
        ->getTitle($request, $route);
    }

    /*
     * Services Array
     */
    $services = [
      'facebook' => [
        'title' => 'Facebook',
        'url' => 'https://www.facebook.com/sharer/sharer.php',
        'query' => 'u',
        'icon' => 'facebook',
      ],
      'googleplus' => [
        'title' => 'Google Plus',
        'url' => 'https://plus.google.com/share',
        'query' => 'url',
        'icon' => 'google-plus',
      ],
      /*'instagram' => [
        'title' => 'Instargam',
        'url' => 'https://plus.google.com/share',
        'query' => 'url',
        'icon' => 'instagram',
      ],*/
      'twitter' => [
        'title' => 'Twitter',
        'url' => 'https://twitter.com/home',
        'query' => 'status',
        'icon' => 'twitter',
      ],
      'pinterest' => [
        'title' => 'Pinterest',
        'url' => 'https://pinterest.com/pin/create/button',
        'query' => 'url',
        'icon' => 'pinterest',
      ],
      'tripadvisor' => [
        'title' => 'Tripadvisor',
        'url' => 'http://www.tripadvisor.co.uk/Hotel_Review-g1187654-d4561449-Reviews-Melissanthi_Hotel-Dionisiou_Beach_Halkidiki_Region_Central_Macedonia.html',
        'query' => '',
        'icon' => 'tripadvisor',
      ],
      'linkedin' => [
        'title' => 'Linkedin',
        'url' => 'https://www.linkedin.com/shareArticle',
        'query' => 'url',
        'icon' => 'linkedin',
      ],
    ];

    /*
     * Build Links
     */
    $link_generator = \Drupal::service('link_generator');
    foreach ($services as $key => $service) {
      if ($this->configuration['share_' . $key] == 1) {
        $external_url = Url::fromUri($service['url'], [
          'query' => [
            $service['query'] => $page_url,
            'title' => $page_title
          ],
          'attributes' => [
            'target' => '_blank',
            'class' => ['share-' . $key]
          ],
        ]);
        $external_text = [
          '#type' => 'inline_template',
          '#template' => '<i class="fa fa-' . $service['icon'] . '" aria-hidden="true"></i><span>{{ link_text }}</span>',
          '#context' => array('link_text' => $service['title'])
        ];
        $external_link = $link_generator->generate($external_text, $external_url);
        $items['link_' . $key]['#markup'] = $external_link;
      }
    }


    /*
     * Build Link for Pet friendly page
     */
    $path = '/pet-friendly';
    $pet_url = Url::fromUserInput($path, [
      'attributes' => ['class' => ['petfriendly']],
    ]);
    $pet_text = 'Petfriendly';
    $pet_link = $link_generator->generate($pet_text, $pet_url);


    /*
     * Build Block Output
     */
    $build = [];
    $build['share_links'] = [
      '#items' => $items,
      '#theme' => 'item_list'
    ];

    $build['pet_friendly'] = [
      '#markup' => $pet_link,
    ];


    $build['#cache']['max-age'] = 0;
    return $build;
  }

}
