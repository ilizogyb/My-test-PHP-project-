<?php
/**
 *
 *
 *
 *
 */
namespace MySystem\Controller;

use Core\Controller\Controller;
use MySystem\Model\Product;

class GoodsController extends Controller {

  public function indexAction() {
      $prods = Product::find('all');
      return $this->render('goods.html', array('prods' => $prods));
  }

  public function removeAction($id) {
    $prods = Product::delete($id);
    $this->redirect('/goods');
  }

  public function editAction($id) {
    $templProd = Product::find((int)$id);
    $prod = new Product();
    $prod->producttitle = $this->getRequest()->post('newProdTitle');
    $prod->productprice = $this->getRequest()->post('newProdPrice');
    $prod->id = $templProd->id;
    $prod->save();
    $this->redirect('/goods');
  }

  public function addAction() {
      $prod = new Product();
      $prod->producttitle = $this->getRequest()->post('inputProdTitle');
      $prod->productprice = $this->getRequest()->post('inputProdPrice');
      $prod->save();

      $this->redirect('/goods');
  }



}
