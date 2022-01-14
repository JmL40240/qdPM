<?php

/**
 * discussionsTypes actions.
 *
 * @package    sf_sandbox
 * @subpackage discussionsTypes
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class discussionsTypesActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    app::setPageTitle('Discussions Types',$this->getResponse());
    
    $this->discussions_typess = Doctrine_Core::getTable('DiscussionsTypes')
      ->createQuery('a')
      ->orderBy('sort_order, name')
      ->execute();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new DiscussionsTypesForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new DiscussionsTypesForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($discussions_types = Doctrine_Core::getTable('DiscussionsTypes')->find(array($request->getParameter('id'))), sprintf('Object discussions_types does not exist (%s).', $request->getParameter('id')));
    $this->form = new DiscussionsTypesForm($discussions_types);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($discussions_types = Doctrine_Core::getTable('DiscussionsTypes')->find(array($request->getParameter('id'))), sprintf('Object discussions_types does not exist (%s).', $request->getParameter('id')));
    $this->form = new DiscussionsTypesForm($discussions_types);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($discussions_types = Doctrine_Core::getTable('DiscussionsTypes')->find(array($request->getParameter('id'))), sprintf('Object discussions_types does not exist (%s).', $request->getParameter('id')));
    $discussions_types->delete();

    $this->redirect('discussionsTypes/index');
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
      
      $discussions_types = $form->save();
      
      if($discussions_types->getDefaultValue()==1)
      {
        app::resetCfgDefaultValue($discussions_types->getId(),'DiscussionsTypes');
      }

      $this->redirect('discussionsTypes/index');
    }
  }
}
