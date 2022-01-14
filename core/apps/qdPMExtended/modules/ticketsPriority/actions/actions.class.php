<?php

/**
 * ticketsPriority actions.
 *
 * @package    sf_sandbox
 * @subpackage ticketsPriority
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ticketsPriorityActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    app::setPageTitle('Tickets Priorities',$this->getResponse());
    
    $this->tickets_prioritys = Doctrine_Core::getTable('TicketsPriority')
      ->createQuery('a')
      ->orderBy('sort_order, name')
      ->execute();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new TicketsPriorityForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new TicketsPriorityForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($tickets_priority = Doctrine_Core::getTable('TicketsPriority')->find(array($request->getParameter('id'))), sprintf('Object tickets_priority does not exist (%s).', $request->getParameter('id')));
    $this->form = new TicketsPriorityForm($tickets_priority);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($tickets_priority = Doctrine_Core::getTable('TicketsPriority')->find(array($request->getParameter('id'))), sprintf('Object tickets_priority does not exist (%s).', $request->getParameter('id')));
    $this->form = new TicketsPriorityForm($tickets_priority);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($tickets_priority = Doctrine_Core::getTable('TicketsPriority')->find(array($request->getParameter('id'))), sprintf('Object tickets_priority does not exist (%s).', $request->getParameter('id')));
    $tickets_priority->delete();

    $this->redirect('ticketsPriority/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $tickets_priority = $form->save();
      
      if($tickets_priority->getDefaultValue()==1)
      {
        app::resetCfgDefaultValue($tickets_priority->getId(),'TicketsPriority');
      }

      $this->redirect('ticketsPriority/index');
    }
  }
}
