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

class AgentsController extends Controller {

  public function indexAction() {
      $agents = Agent::find('all');
      return $this->render('agents.html', array('agents' => $agents));
  }

  public function removeAction($id) {
      $prods = Agent::delete($id);
      $this->redirect('/agents');
  }

  public function editAction($id) {
      $templAgent = Agent::find((int)$id);
      $agent = new Agent();
      $agent->fname = $this->getRequest()->post('newFname');
      $agent->lname = $this->getRequest()->post('newLname');
      $agent->id = $templAgent->id;
      $agent->save();

      $this->redirect('/agents');
  }

  public function addAction() {
      $agent = new Agent();
      $agent->fname = $this->getRequest()->post('inputAgentFname');
      $agent->lname = $this->getRequest()->post('inputAgentLname');
      $agent->save();

      $this->redirect('/agents');
  }



}
