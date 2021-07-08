<?php

namespace Drupal\kadabrait_content\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\kadabrait_content\Service\ListUserContentService;

/**
 * Creates the page to list last 10 nodes created by logged user.
 */
class KadabraitContentController extends ControllerBase {

  /**
   * The ListUserContentService.
   *
   * @var Drupal\kadabrait_content\Service\ListUserContentService
   */
  protected $service;

  /**
   * {@inheritdoc}
   */
  public function __construct(ListUserContentService $service) {
    $this->service = $service;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
        $container->get('kadabrait_content.list_content_service')
      );
  }

  /**
   * Return markup for this page.
   */
  public function listContent() {

    $output = $this->service->getData(10);
    return [
      '#markup' => $output,
    ];
  }

}
