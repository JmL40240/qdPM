<?php

/**
 * ticketsTypes actions.
 *
 * @package    sf_sandbox
 * @subpackage ticketsTypes
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ticketsTypesActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    app::setPageTitle('Tickets Types',$this->getResponse());
    
    $this->tickets_typess = Doctrine_Core::getTable('TicketsTypes')
      ->createQuery('a')
      ->orderBy('sort_order, name')
      ->execute();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new TicketsTypesForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new TicketsTypesForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($tickets_types = Doctrine_Core::getTable('TicketsTypes')->find(array($request->getParameter('id'))), sprintf('Object tickets_types does not exist (%s).', $request->getParameter('id')));
    $this->form = new TicketsTypesForm($tickets_types);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($tickets_types = Doctrine_Core::getTable('TicketsTypes')->find(array($request->getParameter('id'))), sprintf('Object tickets_types does not exist (%s).', $request->getParameter('id')));
    $this->form = new TicketsTypesForm($tickets_types);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($tickets_types = Doctrine_Core::getTable('TicketsTypes')->find(array($request->getParameter('id'))), sprintf('Object tickets_types does not exist (%s).', $request->getParameter('id')));
    $tickets_types->delete();

    $this->redirect('ticketsTypes/index');
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
      
      $tickets_types = $form->save();
      
      if($tickets_types->getDefaultValue()==1)
      {
        app::resetCfgDefaultValue($tickets_types->getId(),'TicketsTypes');
      }

      $this->redirect('ticketsTypes/index');
    }
  }
}
