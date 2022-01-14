<?php

/**
 * projectsPriority actions.
 *
 * @package    sf_sandbox
 * @subpackage projectsPriority
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class projectsPriorityActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->projects_prioritys = Doctrine_Core::getTable('ProjectsPriority')
      ->createQuery('a')
      ->orderBy('sort_order, name')
      ->execute();
      
    app::setPageTitle('Projects Priorities',$this->getResponse());
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new ProjectsPriorityForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new ProjectsPriorityForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($projects_priority = Doctrine_Core::getTable('ProjectsPriority')->find(array($request->getParameter('id'))), sprintf('Object projects_priority does not exist (%s).', $request->getParameter('id')));
    $this->form = new ProjectsPriorityForm($projects_priority);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($projects_priority = Doctrine_Core::getTable('ProjectsPriority')->find(array($request->getParameter('id'))), sprintf('Object projects_priority does not exist (%s).', $request->getParameter('id')));
    $this->form = new ProjectsPriorityForm($projects_priority);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($projects_priority = Doctrine_Core::getTable('ProjectsPriority')->find(array($request->getParameter('id'))), sprintf('Object projects_priority does not exist (%s).', $request->getParameter('id')));
    $projects_priority->delete();

    $this->redirect('projectsPriority/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $projects_priority = $form->save();
      
      if($projects_priority->getDefaultValue()==1)
      {
        app::resetCfgDefaultValue($projects_priority->getId(),'ProjectsPriority');
      }

      $this->redirect('projectsPriority/index');
    }
  }
}
