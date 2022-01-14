<?php

/**
 * eventsPriority actions.
 *
 * @package    sf_sandbox
 * @subpackage eventsPriority
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class eventsPriorityActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    app::setPageTitle('Events Priorities',$this->getResponse());
    
    $this->events_prioritys = Doctrine_Core::getTable('EventsPriority')
      ->createQuery('a')
      ->orderBy('sort_order, name')
      ->execute();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new EventsPriorityForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new EventsPriorityForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($events_priority = Doctrine_Core::getTable('EventsPriority')->find(array($request->getParameter('id'))), sprintf('Object events_priority does not exist (%s).', $request->getParameter('id')));
    $this->form = new EventsPriorityForm($events_priority);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($events_priority = Doctrine_Core::getTable('EventsPriority')->find(array($request->getParameter('id'))), sprintf('Object events_priority does not exist (%s).', $request->getParameter('id')));
    $this->form = new EventsPriorityForm($events_priority);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($events_priority = Doctrine_Core::getTable('EventsPriority')->find(array($request->getParameter('id'))), sprintf('Object events_priority does not exist (%s).', $request->getParameter('id')));
    $events_priority->delete();

    $this->redirect('eventsPriority/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $events_priority = $form->save();
      
      if($events_priority->getDefaultValue()==1)
      {
        app::resetCfgDefaultValue($events_priority->getId(),'EventsPriority');
      }

      $this->redirect('eventsPriority/index');
    }
  }
}
