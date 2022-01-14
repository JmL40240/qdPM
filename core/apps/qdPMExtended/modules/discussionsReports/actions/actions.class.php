<?php

/**
 * discussionsReports actions.
 *
 * @package    sf_sandbox
 * @subpackage discussionsReports
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class discussionsReportsActions extends sfActions
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
    $this->discussions_reportss = Doctrine_Core::getTable('DiscussionsReports')
      ->createQuery()
      ->addWhere('users_id=?',$this->getUser()->getAttribute('id'))
      ->addWhere('report_type is null or length(report_type)=0')
      ->orderBy('name')
      ->execute();
      
    app::setPageTitle('Discussions Reports',$this->getResponse());
  }
  
  public function executeView(sfWebRequest $request)
  {
    $this->forward404Unless($this->discussions_reports = Doctrine_Core::getTable('DiscussionsReports')->find(array($request->getParameter('id'))), sprintf('Object discussions_reports does not exist (%s).', $request->getParameter('id')));
    
    $this->checkAccess($this->discussions_reports);
    
    app::setPageTitle($this->discussions_reports->getName(),$this->getResponse());
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new DiscussionsReportsForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new DiscussionsReportsForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($discussions_reports = Doctrine_Core::getTable('DiscussionsReports')->find(array($request->getParameter('id'))), sprintf('Object discussions_reports does not exist (%s).', $request->getParameter('id')));
    $this->checkAccess($discussions_reports);
    $this->form = new DiscussionsReportsForm($discussions_reports);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($discussions_reports = Doctrine_Core::getTable('DiscussionsReports')->find(array($request->getParameter('id'))), sprintf('Object discussions_reports does not exist (%s).', $request->getParameter('id')));
    $this->checkAccess($discussions_reports);
    $this->form = new DiscussionsReportsForm($discussions_reports);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($discussions_reports = Doctrine_Core::getTable('DiscussionsReports')->find(array($request->getParameter('id'))), sprintf('Object discussions_reports does not exist (%s).', $request->getParameter('id')));
    $this->checkAccess($discussions_reports);
    $discussions_reports->delete();

    switch($request->getParameter('redirect_to'))
    {
      case 'commonReports': $this->redirect('commonReports/index');
        break;
      default: $this->redirect('discussionsReports/index');
        break;
    }
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $form->setFieldValue('discussions_types_id',$form['discussions_types_id']->getValue());            
      $form->setFieldValue('discussions_status_id',$form['discussions_status_id']->getValue());            
      $form->setFieldValue('discussions_priority_id',$form['discussions_priority_id']->getValue());            
      $form->setFieldValue('discussions_groups_id',$form['discussions_groups_id']->getValue());
      
      $form->setFieldValue('created_by',$form['created_by']->getValue());
      $form->setFieldValue('assigned_to',$form['assigned_to']->getValue());
      
      $form->setFieldValue('projects_type_id',$form['projects_type_id']->getValue());            
      $form->setFieldValue('projects_status_id',$form['projects_status_id']->getValue());            
      $form->setFieldValue('projects_priority_id',$form['projects_priority_id']->getValue());            
      $form->setFieldValue('projects_groups_id',$form['projects_groups_id']->getValue());            
      $form->setFieldValue('projects_id',$form['projects_id']->getValue());      
      
      $form->setFieldValue('users_groups_id',$form['users_groups_id']->getValue());     
            
      if(is_array($form['extra_fields']->getValue()))              
        $form->setFieldValue('extra_fields',serialize($form['extra_fields']->getValue()));
    
      $form->protectFieldsValue();
      
      $discussions_reports = $form->save();

      switch($request->getParameter('redirect_to'))
      {
        case 'commonReports': $discussions_reports->setReportType('common'); $discussions_reports->save(); $this->redirect('commonReports/index');
          break;
        case 'view': $this->redirect('discussionsReports/view?id=' . $discussions_reports->getId());
          break;
        default: $this->redirect('discussionsReports/index');
          break;
      }     
    }
  }
}
