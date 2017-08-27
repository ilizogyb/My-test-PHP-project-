<?php
/**
 *
 *
 *
 *
 */
namespace MySystem\Controller;

use Core\Controller\Controller;

class IndexController extends Controller {

  public function indexAction() {
      return $this->render('index.html', array());

  }

}
