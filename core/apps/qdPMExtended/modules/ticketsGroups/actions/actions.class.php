<?php

/**
 * ticketsGroups actions.
 *
 * @package    sf_sandbox
 * @subpackage ticketsGroups
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ticketsGroupsActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    app::setPageTitle('Tickets Groups',$this->getResponse());
    
    $this->tickets_groupss = Doctrine_Core::getTable('TicketsGroups')
      ->createQuery('a')
      ->orderBy('sort_order, name')
      ->execute();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new TicketsGroupsForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new TicketsGroupsForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($tickets_groups = Doctrine_Core::getTable('TicketsGroups')->find(array($request->getParameter('id'))), sprintf('Object tickets_groups does not exist (%s).', $request->getParameter('id')));
    $this->form = new TicketsGroupsForm($tickets_groups);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($tickets_groups = Doctrine_Core::getTable('TicketsGroups')->find(array($request->getParameter('id'))), sprintf('Object tickets_groups does not exist (%s).', $request->getParameter('id')));
    $this->form = new TicketsGroupsForm($tickets_groups);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($tickets_groups = Doctrine_Core::getTable('TicketsGroups')->find(array($request->getParameter('id'))), sprintf('Object tickets_groups does not exist (%s).', $request->getParameter('id')));
    $tickets_groups->delete();

    $this->redirect('ticketsGroups/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $tickets_groups = $form->save();
      
      if($tickets_groups->getDefaultValue()==1)
      {
        app::resetCfgDefaultValue($tickets_groups->getId(),'TicketsGroups');
      }

      $this->redirect('ticketsGroups/index');
    }
  }
}
