<?php

/**
 * eventsTypes actions.
 *
 * @package    sf_sandbox
 * @subpackage eventsTypes
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class eventsTypesActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    app::setPageTitle('Events Types',$this->getResponse());
    
    $this->events_typess = Doctrine_Core::getTable('EventsTypes')
      ->createQuery('a')
      ->orderBy('sort_order, name')
      ->execute();
  }

  public function executeNew(sfWebRequest $request)
  {    
    $this->form = new EventsTypesForm();        
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new EventsTypesForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($events_types = Doctrine_Core::getTable('EventsTypes')->find(array($request->getParameter('id'))), sprintf('Object events_types does not exist (%s).', $request->getParameter('id')));
    $this->form = new EventsTypesForm($events_types);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($events_types = Doctrine_Core::getTable('EventsTypes')->find(array($request->getParameter('id'))), sprintf('Object events_types does not exist (%s).', $request->getParameter('id')));
    $this->form = new EventsTypesForm($events_types);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($events_types = Doctrine_Core::getTable('EventsTypes')->find(array($request->getParameter('id'))), sprintf('Object events_types does not exist (%s).', $request->getParameter('id')));
    $events_types->delete();

    $this->redirect('eventsTypes/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $form->setFieldValue('extra_fields',$this->form['extra_fields']->getValue());
      
      if($request->getParameter('set_off_extra_fields')==1)
      {
        $form->setFieldValue('extra_fields','set_off_extra_fields');
      }
      
      $events_types = $form->save();
      
      if($events_types->getDefaultValue()==1)
      {
        app::resetCfgDefaultValue($events_types->getId(),'EventsTypes');
      }

      $this->redirect('eventsTypes/index');
    }
  }
}
