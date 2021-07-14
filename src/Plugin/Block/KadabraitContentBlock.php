<?php

namespace Drupal\kadabrait_content\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\kadabrait_content\Service\ListUserContentService;
use Drupal\Core\Config\ConfigFactoryInterface;

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
   * The config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * The ListUserContentService.
   *
   * @var Drupal\kadabrait_content\Service\ListUserContentService
   */
  protected $service;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, ConfigFactoryInterface $config_factory, ListUserContentService $service) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->configFactory = $config_factory;
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
      $container->get('config.factory'),
      $container->get('kadabrait_content.list_content_service')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {

    $config =$this->configFactory->get('kadabrait_content.settings');
    $limit = $config->get('kadabrait_content.block_limit_content');
    $output = $this->service->getData($limit);
    return [
      '#markup' => $output,
    ];
  }

}
