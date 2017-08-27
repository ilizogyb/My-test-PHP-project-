<?php
/**
 *
 *
 *
 *
 */
namespace MySystem\Controller;

use Core\Controller\Controller;
use MySystem\Model\Agent;
use MySystem\Model\Address;

class AddressController extends Controller {

  public function indexAction() {
      $agents = Agent::find('all');
      $address = Address::find('all');
      return $this->render('address.html', array('agents' => $agents, 'address' => $address));
  }
  public function addAction($id) {
      $address = new Address();
      $address->agentsid = $id;
      $address->address = $this->getRequest()->post('newAgentAddr');
      $address->save();
      $this->redirect('/address');
  }

  public function removeAction($id) {
      //$prods = Address::delete($id);
      $addrTempl = Address::find('all');

      foreach ($addrTempl as $val) {
        if($val->agentsid == $id) {
          $templ = $val;
        }
      }
      Address::delete($templ->id);

      $this->redirect('/address');
  }

  public function editAction($id) {
      $addrTempl = Address::find('all');

      foreach ($addrTempl as $val) {
        if($val->agentsid == $id) {
          $templ = $val;
        }
      }


      $address = new Address();
      $address->address = $this->getRequest()->post('newAgentAddr');
      $address->agentsid = $templ->agentsid;
      $address->id = $templ->id;
      $address->save();

      $this->redirect('/address');
  }

}
