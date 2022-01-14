<?php

/**
 * usersTasksReport actions.
 *
 * @package    sf_sandbox
 * @subpackage usersTasksReport
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class usersTasksReportActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    app::setPageTitle('Users per Tasks',$this->getResponse());
    
    if(!$this->getUser()->hasAttribute('users_tasks_filter'))
    {
      $this->getUser()->setAttribute('users_tasks_filter', Tasks::getDefaultFilter($request,$this->getUser(),'usersTasksReport'));
    }
                     
    $this->filter_by = $this->getUser()->getAttribute('users_tasks_filter');
        
    if($fb = $request->getParameter('filter_by'))
    {
      foreach($fb as $k=>$v)
      {
        $this->filter_by[$k]=$v;
      }
      $this->getUser()->setAttribute('users_tasks_filter', $this->filter_by);
      
      $this->redirect('usersTasksReport/index' );
    }
    
    if($request->hasParameter('remove_filter'))
    {
      unset($this->filter_by[$request->getParameter('remove_filter')]);    
      $this->getUser()->setAttribute('users_tasks_filter', $this->filter_by);
      
      $this->redirect('usersTasksReport/index' );
    }
     
    if($request->hasParameter('user_filter'))
    {
      $this->filter_by = Tasks::useTasksFilter($request,$this->getUser(),'usersTasksReport');
      $this->getUser()->setAttribute('users_tasks_filter', $this->filter_by);
      
      $this->redirect('usersTasksReport/index' );
    }
        
    if($request->hasParameter('delete_user_filter'))
    {
      app::deleteUserFilter($request->getParameter('delete_user_filter'),'UserReports',$this->getUser());
    
      $this->getUser()->setFlash('userNotices', t::__('Filter Deleted'));
      
      $this->redirect('usersTasksReport/index' );
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
    Tasks::saveTasksFilter($request,$this->getUser()->getAttribute('users_tasks_filter'),$this->getUser(),'usersTasksReport');
    
    $this->getUser()->setFlash('userNotices', t::__('Filter Saved'));
    $this->redirect('usersTasksReport/index' );
  }  
}
