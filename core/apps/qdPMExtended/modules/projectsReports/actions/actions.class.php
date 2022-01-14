<?php

/**
 * projectsReports actions.
 *
 * @package    sf_sandbox
 * @subpackage projectsReports
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class projectsReportsActions extends sfActions
{
  public function checkAccess($reports)
  {
    if($reports->getReportType()=='common')
    {      
      if(!in_array($this->getUser()->getAttribute('users_group_id'),explode(',',$reports->getUsersGroupsId())) and !$this->getUser()->hasCredential('allow_manage_configuration'))
      {
        $this->redirect('accessForbidden/index');
      }
    }
    elseif($reports->getUsersId()!=$this->getUser()->getAttribute('id'))
    {
      $this->redirect('accessForbidden/index');
    }
  }
  
  public function executeIndex(sfWebRequest $request)
  {
    $this->projects_reportss = Doctrine_Core::getTable('ProjectsReports')
      ->createQuery()
      ->addWhere('users_id=?',$this->getUser()->getAttribute('id'))
      ->addWhere('report_type is null')
      ->orderBy('name')
      ->execute();
      
    app::setPageTitle('Projects Reports',$this->getResponse());
  }

  public function executeView(sfWebRequest $request)
  {
    $this->forward404Unless($this->projects_reports = Doctrine_Core::getTable('ProjectsReports')->find(array($request->getParameter('id'))), sprintf('Object projects_reports does not exist (%s).', $request->getParameter('id')));
    
    $this->checkAccess($this->projects_reports);
    
    app::setPageTitle($this->projects_reports->getName(),$this->getResponse());
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new ProjectsReportsForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new ProjectsReportsForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($projects_reports = Doctrine_Core::getTable('ProjectsReports')->find(array($request->getParameter('id'))), sprintf('Object projects_reports does not exist (%s).', $request->getParameter('id')));
    $this->checkAccess($projects_reports);
    $this->form = new ProjectsReportsForm($projects_reports);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($projects_reports = Doctrine_Core::getTable('ProjectsReports')->find(array($request->getParameter('id'))), sprintf('Object projects_reports does not exist (%s).', $request->getParameter('id')));
    $this->checkAccess($projects_reports);
    $this->form = new ProjectsReportsForm($projects_reports);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($projects_reports = Doctrine_Core::getTable('ProjectsReports')->find(array($request->getParameter('id'))), sprintf('Object projects_reports does not exist (%s).', $request->getParameter('id')));
    $this->checkAccess($projects_reports);
    $projects_reports->delete();

    switch($request->getParameter('redirect_to'))
    {
      case 'commonReports': $this->redirect('commonReports/index');
        break;
      default: $this->redirect('projectsReports/index');
        break;
    }
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      
      $form->setFieldValue('projects_type_id',$form['projects_type_id']->getValue());            
      $form->setFieldValue('projects_status_id',$form['projects_status_id']->getValue());            
      $form->setFieldValue('projects_priority_id',$form['projects_priority_id']->getValue());            
      $form->setFieldValue('projects_groups_id',$form['projects_groups_id']->getValue());            
      $form->setFieldValue('projects_id',$form['projects_id']->getValue());           
      $form->setFieldValue('in_team',$form['in_team']->getValue());
      
      $form->setFieldValue('users_groups_id',$form['users_groups_id']->getValue());
      
      if(is_array($form['extra_fields']->getValue()))              
        $form->setFieldValue('extra_fields',serialize($form['extra_fields']->getValue()));
    
      $form->protectFieldsValue();
      
      $projects_reports = $form->save();

      switch($request->getParameter('redirect_to'))
      {
        case 'commonReports': $projects_reports->setReportType('common'); $projects_reports->save(); $this->redirect('commonReports/index');
          break;
        case 'view': $this->redirect('projectsReports/view?id=' . $projects_reports->getId());
          break;
        default: $this->redirect('projectsReports/index');
          break;
      }
    }
  }
}
