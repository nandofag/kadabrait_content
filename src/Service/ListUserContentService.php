<?php

namespace Drupal\kadabrait_content\Service;

use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Render\Renderer;

/**
 * Get the last nodes created by logged user.
 *
 * @package Drupal\kadabrait_content\Services
 */
class ListUserContentService {

  /**
   * Current user.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected $currentUser;

  /**
   * Entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Renderer service.
   *
   * @var Drupal\Core\Render\Renderer
   */
  protected $renderer;

  /**
   * {@inheritdoc}
   */
  public function __construct(AccountInterface $currentUser, EntityTypeManagerInterface $entityTypeManager, Renderer $renderer) {
    $this->currentUser = $currentUser;
    $this->entityTypeManager = $entityTypeManager;
    $this->renderer = $renderer;
  }

  /**
   * Return rendered string.
   *
   * @param int $limit
   *   Limit of nodes to get.
   *
   * @return \Drupal\Component\Render\MarkupInterface|string
   *   string markup
   */
  public function getData($limit) {
    $entity_type = 'node';
    $view_mode = 'teaser';

    $node_ids = $this->entityTypeManager->getStorage($entity_type)->getQuery()
      ->condition('uid', $this->currentUser->id())
      ->range(0, $limit)
      ->sort('created', 'DESC')
      ->execute();
    $nodes = $this->entityTypeManager->getStorage($entity_type)->loadMultiple($node_ids);
    $list = [];
    $view_builder = $this->entityTypeManager->getViewBuilder($entity_type);
    foreach ($nodes as $node) {
      $list[$node->id()] = $view_builder->view($node, $view_mode);
    }

    $output = $this->renderer->render($list);
    return $output;
  }

}
