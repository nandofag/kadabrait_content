<?php

namespace Drupal\kadabrait_content\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\kadabrait_content\Service\ListUserContentService;
use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * Creates the page to list last 10 nodes created by logged user.
 */
class KadabraitContentController extends ControllerBase {

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
  public function __construct(ConfigFactoryInterface $config_factory, ListUserContentService $service) {
    $this->configFactory = $config_factory;
    $this->service = $service;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
        $container->get('config.factory'),
        $container->get('kadabrait_content.list_content_service')
      );
  }

  /**
   * Return markup for this page.
   */
  public function listContent() {
    $config =$this->configFactory->get('kadabrait_content.settings');
    $limit = $config->get('kadabrait_content.page_limit_content');
    $output = $this->service->getData($limit);
    return [
      '#markup' => $output,
    ];
  }

}
