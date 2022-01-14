<?php

/**
 * extraFieldsTabs actions.
 *
 * @package    sf_sandbox
 * @subpackage extraFieldsTabs
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class extraFieldsTabsActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->forward404Unless($request->hasParameter('bind_type'), 'bind_type is not defined');
    
    $this->extra_fields_tabss = Doctrine_Core::getTable('ExtraFieldsTabs')
      ->createQuery('a')
      ->addWhere('bind_type=?',$request->getParameter('bind_type','projects'))
      ->orderBy('sort_order, name')
      ->execute();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new ExtraFieldsTabsForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->hasParameter('bind_type'), 'bind_type is not defined');
    
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new ExtraFieldsTabsForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($request->hasParameter('bind_type'), 'bind_type is not defined');
    
    $this->forward404Unless($extra_fields_tabs = Doctrine_Core::getTable('ExtraFieldsTabs')->find(array($request->getParameter('id'))), sprintf('Object extra_fields_tabs does not exist (%s).', $request->getParameter('id')));
    $this->form = new ExtraFieldsTabsForm($extra_fields_tabs);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->hasParameter('bind_type'), 'bind_type is not defined');
    
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($extra_fields_tabs = Doctrine_Core::getTable('ExtraFieldsTabs')->find(array($request->getParameter('id'))), sprintf('Object extra_fields_tabs does not exist (%s).', $request->getParameter('id')));
    $this->form = new ExtraFieldsTabsForm($extra_fields_tabs);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $this->forward404Unless($request->hasParameter('bind_type'), 'bind_type is not defined');
    
    $request->checkCSRFProtection();

    $this->forward404Unless($extra_fields_tabs = Doctrine_Core::getTable('ExtraFieldsTabs')->find(array($request->getParameter('id'))), sprintf('Object extra_fields_tabs does not exist (%s).', $request->getParameter('id')));
    $extra_fields_tabs->delete();

    $this->redirect('extraFieldsTabs/index?bind_type=' . $request->getParameter('bind_type'));
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $form->setFieldValue('users_groups_access',$form['users_groups_access']->getValue());
      
      $extra_fields_tabs = $form->save();

      $this->redirect('extraFieldsTabs/index?bind_type=' . $request->getParameter('bind_type'));
    }
  }
}
