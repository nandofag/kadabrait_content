<?php

namespace Drupal\kadabrait_content\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\kadabrait_content\Service\ListUserContentService;

/**
 * Provides a custom Kadabrait Content Block.
 *
 * @Block(
 *   id = "kadabrait_content_block",
 *   admin_label = @Translation("Kadabrait Content Block"),
 *   category = @Translation("Kadabrait Content Block"),
 * )
 */
class KadabraitContentBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The ListUserContentService.
   *
   * @var Drupal\kadabrait_content\Service\ListUserContentService
   */
  protected $service;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, ListUserContentService $service) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->service = $service;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('kadabrait_content.list_content_service')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {

    $output = $this->service->getData(3);
    return [
      '#markup' => $output,
    ];
  }

}
