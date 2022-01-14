<?php

/**
 * projectsGroups actions.
 *
 * @package    sf_sandbox
 * @subpackage projectsGroups
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class projectsGroupsActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {        
    $this->projects_groupss = Doctrine_Core::getTable('ProjectsGroups')
      ->createQuery('a')
      ->orderBy('sort_order, name')
      ->execute();
      
    app::setPageTitle('Projects Groups',$this->getResponse());
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new ProjectsGroupsForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new ProjectsGroupsForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($projects_groups = Doctrine_Core::getTable('ProjectsGroups')->find(array($request->getParameter('id'))), sprintf('Object projects_groups does not exist (%s).', $request->getParameter('id')));
    $this->form = new ProjectsGroupsForm($projects_groups);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($projects_groups = Doctrine_Core::getTable('ProjectsGroups')->find(array($request->getParameter('id'))), sprintf('Object projects_groups does not exist (%s).', $request->getParameter('id')));
    $this->form = new ProjectsGroupsForm($projects_groups);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($projects_groups = Doctrine_Core::getTable('ProjectsGroups')->find(array($request->getParameter('id'))), sprintf('Object projects_groups does not exist (%s).', $request->getParameter('id')));
    $projects_groups->delete();

    $this->redirect('projectsGroups/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
        $form->protectFieldsValue();
        
      $projects_groups = $form->save();
      
      if($projects_groups->getDefaultValue()==1)
      {
        app::resetCfgDefaultValue($projects_groups->getId(),'ProjectsGroups');
      }

      $this->redirect('projectsGroups/index');
    }
  }
}
