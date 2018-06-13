<?php
namespace Drupal\homework\Controller;
use Drupal\Core\Controller\ControllerBase;

class HomeworkController extends ControllerBase {
  /**
   *
   */
  public function content() {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Hello, World!'),
    ];

  }

}
