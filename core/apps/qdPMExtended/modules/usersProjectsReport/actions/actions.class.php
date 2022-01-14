<?php

/**
 * usersProjectsReport actions.
 *
 * @package    sf_sandbox
 * @subpackage usersProjectsReport
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class usersProjectsReportActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    app::setPageTitle('Users per Projects',$this->getResponse());
     
    if(!$this->getUser()->hasAttribute('usersprojects_filter'))
    {
      $this->getUser()->setAttribute('usersprojects_filter', Projects::getDefaultFilter($this->getUser(),'users_projects_filter'));
    }
                     
    $this->filter_by = $this->getUser()->getAttribute('usersprojects_filter');
        
    if($fb = $request->getParameter('filter_by'))
    {
      $this->filter_by[key($fb)]=current($fb);
      $this->getUser()->setAttribute('usersprojects_filter', $this->filter_by);
      
      $this->redirect('usersProjectsReport/index');
    }
    
    if($request->hasParameter('remove_filter'))
    {
      unset($this->filter_by[$request->getParameter('remove_filter')]);    
      $this->getUser()->setAttribute('usersprojects_filter', $this->filter_by);
      
      $this->redirect('usersProjectsReport/index');
    }
     
    if($request->hasParameter('user_filter'))
    {
      $this->filter_by = Projects::useProjectsFilter($request->getParameter('user_filter'),$this->getUser(),'users_projects_filter');
      $this->getUser()->setAttribute('usersprojects_filter', $this->filter_by);
      
      $this->redirect('usersProjectsReport/index');
    }
        
    if($request->hasParameter('delete_user_filter'))
    {
      app::deleteUserFilter($request->getParameter('delete_user_filter'),'ProjectsReports',$this->getUser());
    
      $this->getUser()->setFlash('userNotices', t::__('Filter Deleted'));
      
      $this->redirect('usersProjectsReport/index');
    }
    
    if($request->hasParameter('edit_user_filter'))
    {
      $this->setTemplate('editFilter','app');
    }
    
    if($request->hasParameter('sort_filters'))
    {
      $this->setTemplate('sortFilters','app');
    }
  }
  
  public function executeSaveFilter(sfWebRequest $request)
  {
    $this->setTemplate('saveFilter','app');
  }
  
  public function executeDoSaveFilter(sfWebRequest $request)
  {
    Projects::saveProjectsFilter($request,$this->getUser()->getAttribute('usersprojects_filter'),$this->getUser(),'users_projects_filter');
    
    $this->getUser()->setFlash('userNotices', t::__('Filter Saved'));
    $this->redirect('usersProjectsReport/index');
  }  
}
