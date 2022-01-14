<?php

/**
 * userReports actions.
 *
 * @package    sf_sandbox
 * @subpackage userReports
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class userReportsActions extends sfActions
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
    $this->user_reportss = Doctrine_Core::getTable('UserReports')
      ->createQuery()
      ->addWhere('users_id=?',$this->getUser()->getAttribute('id'))
      ->addWhere('report_type is null or length(report_type)=0')
      ->orderBy('name')
      ->execute();
      
    app::setPageTitle('Tasks Reports',$this->getResponse());
  }
  
  public function executeView(sfWebRequest $request)
  {
    $this->forward404Unless($this->tasks_reports = Doctrine_Core::getTable('UserReports')->find(array($request->getParameter('id'))), sprintf('Object tasks_reports does not exist (%s).', $request->getParameter('id')));
    
    $this->checkAccess($this->tasks_reports);
    
    app::setPageTitle($this->tasks_reports->getName(),$this->getResponse());
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new UserReportsForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new UserReportsForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($user_reports = Doctrine_Core::getTable('UserReports')->find(array($request->getParameter('id'))), sprintf('Object user_reports does not exist (%s).', $request->getParameter('id')));
    $this->checkAccess($user_reports);
    $this->form = new UserReportsForm($user_reports);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($user_reports = Doctrine_Core::getTable('UserReports')->find(array($request->getParameter('id'))), sprintf('Object user_reports does not exist (%s).', $request->getParameter('id')));
    $this->checkAccess($user_reports);
    $this->form = new UserReportsForm($user_reports);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($user_reports = Doctrine_Core::getTable('UserReports')->find(array($request->getParameter('id'))), sprintf('Object user_reports does not exist (%s).', $request->getParameter('id')));
    $this->checkAccess($user_reports);
    $user_reports->delete();

    switch($request->getParameter('redirect_to'))
    {
      case 'commonReports': $this->redirect('commonReports/index');
        break;
      default: $this->redirect('userReports/index');
        break;
    }
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
    
      $form->setFieldValue('tasks_type_id',$form['tasks_type_id']->getValue());            
      $form->setFieldValue('tasks_status_id',$form['tasks_status_id']->getValue());            
      $form->setFieldValue('tasks_priority_id',$form['tasks_priority_id']->getValue());            
      $form->setFieldValue('tasks_label_id',$form['tasks_label_id']->getValue());
      
      $form->setFieldValue('created_by',$form['created_by']->getValue());
      $form->setFieldValue('assigned_to',$form['assigned_to']->getValue());
      
      $form->setFieldValue('projects_type_id',$form['projects_type_id']->getValue());            
      $form->setFieldValue('projects_status_id',$form['projects_status_id']->getValue());            
      $form->setFieldValue('projects_priority_id',$form['projects_priority_id']->getValue());            
      $form->setFieldValue('projects_groups_id',$form['projects_groups_id']->getValue());            
      $form->setFieldValue('projects_id',$form['projects_id']->getValue());  
      
      $form->setFieldValue('users_groups_id',$form['users_groups_id']->getValue());         
      $form->setFieldValue('report_reminder',$form['report_reminder']->getValue());
            
      if(is_array($form['extra_fields']->getValue()))              
        $form->setFieldValue('extra_fields',serialize($form['extra_fields']->getValue()));
      
      $form->protectFieldsValue();
        
      $user_reports = $form->save();

      switch($request->getParameter('redirect_to'))
      {
        case 'commonReports': $user_reports->setReportType('common'); $user_reports->save(); $this->redirect('commonReports/index');
          break;
        case 'view': $this->redirect('userReports/view?id=' . $user_reports->getId());
          break;
        default: $this->redirect('userReports/index');
          break;
      }      
    }
  }
}
