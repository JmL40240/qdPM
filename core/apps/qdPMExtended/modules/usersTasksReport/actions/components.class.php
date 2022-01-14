<?php

class usersTasksReportComponents extends sfComponents
{  
  public function executeListing(sfWebRequest $request)
  {
            
    $q = Doctrine_Core::getTable('Tasks')->createQuery('t')
          ->leftJoin('t.TasksPriority tp')
          ->leftJoin('t.TasksStatus ts')
          ->leftJoin('t.TasksLabels tl')
          ->leftJoin('t.TasksTypes tt')
          ->leftJoin('t.TasksGroups tg')
          ->leftJoin('t.ProjectsPhases pp')
          ->leftJoin('t.Versions v')
          ->leftJoin('t.Projects p')
          ->leftJoin('t.Users')          
          ->addWhere('t.in_trash is null')
          ->addWhere('p.in_trash is null');
          

    if(Users::hasAccess('view_own','projects',$this->getUser()))
    {       
      $q->addWhere("find_in_set('" . $this->getUser()->getAttribute('id') . "',team) or p.created_by='" . $this->getUser()->getAttribute('id') . "'");
    }
    
    if(Users::hasAccess('view_own','tasks',$this->getUser()))
    {                 
      $q->addWhere("find_in_set('" . $this->getUser()->getAttribute('id') . "',t.assigned_to) or t.created_by='" . $this->getUser()->getAttribute('id') . "'");
    }
    
    if(count($list = ProjectsRoles::getNotAllowedProjectsByModule('tasks',$this->getUser()->getAttribute('id')))>0)
    {
      $q->whereNotIn('p.id',$list);
    }
                                
    $q = Tasks::addFiltersToQuery($q,$this->getUser()->getAttribute('users_tasks_filter'));
                                                      
    $tasks_list = $q->orderBy('t.name')->fetchArray();
    
    $this->userstasks = array();
    $this->tasksnames = array();
    $this->usersnames = Users::getSchema();
    $this->userscounttasks = array();
    $this->taskstoprojects = array();
    
    foreach($tasks_list as $t)
    {
      foreach(explode(',',$t['assigned_to']) as $uid)
      {
        $this->tasksnames[$t['id']] = $t['name'];
        $this->taskstoprojects[$t['id']] = $t['projects_id'];
        
        if($uid>0)
        {                
          if(!isset($this->userstasks[$uid]))
          {
            $this->userstasks[$uid] = array();
          }
          
          array_push($this->userstasks[$uid],$t['id']);
        }
      }
    } 
    
    foreach($this->userstasks as $id=>$tlist)
    {
      $this->userscounttasks[$id] = count($tlist);
    } 
            

  }
  
  public function executeFilters(sfWebRequest $request)
  {  
    $m = array();
    
    $params = false;
            
    $m = app::getFilterMenuItemsByTable($m,'TasksPriority','Priority','timeReport/index',$params);
    $m = app::getFilterMenuStatusItemsByTable($m,'TasksStatus','Status','usersTasksReport/index',$params);
    $m = app::getFilterMenuItemsByTable($m,'TasksLabels','Label','usersTasksReport/index',$params);
    $m = app::getFilterMenuItemsByTable($m,'TasksTypes','Type','usersTasksReport/index',$params);  
    $m = app::getFilterMenuUsers($m,'TasksAssignedTo', 'Assigned To','usersTasksReport/index',$params);
    $m = app::getFilterMenuUsers($m,'TasksCreatedBy','Created By','usersTasksReport/index',$params);
    $m = app::getFilterExtraFields($m,false,'tasks','usersTasksReport/index',$params,array(),$this->getUser());
    

    $m = app::getFilterProjects($m,'usersTasksReport/index',$params,array(),$this->getUser());
    $m = app::getFilterMenuItemsByTable($m,'ProjectsPriority','Projects Priorities','usersTasksReport/index',$params);
    $m = app::getFilterMenuStatusItemsByTable($m,'ProjectsStatus','Projects Status','usersTasksReport/index',$params);
    $m = app::getFilterMenuItemsByTable($m,'ProjectsTypes','Projects Types','usersTasksReport/index',$params);
    $m = app::getFilterMenuItemsByTable($m,'ProjectsGroups','Projects Groups','usersTasksReport/index',$params,array(),$this->getUser());

    
    $m = app::getSavedFilters($m,'usersTasksReport/index',$params,'UserReports',Tasks::getReportType($request,'usersTasksReport'),$this->getUser());
    
    $m[] = array('title'=>__('Save Filter'),'url'=>'usersTasksReport/saveFilter' . ($params ? '?' . $params:''),'is_hr'=>true,'modalbox'=>true);
                    
    $this->m = array(array('title'=>__('Filters'),'submenu'=>$m));
  }
  
  public function executeFiltersPreview(sfWebRequest $request)
  {
    $this->filter_by = $this->getUser()->getAttribute('users_tasks_filter');
    $this->params = false;
    $this->filter_tables = array('TasksPriority'=>'Priority', 'TasksStatus'=>'Status','TasksTypes'=>'Type','TasksLabels'=>'Label','TasksAssignedTo'=>'Assigned To','TasksCreatedBy'=>'Created By','TasksGroups'=>'Group','ProjectsPhases'=>'Phase','Versions'=>'Version');
    
    $this->filter_tables['Projects']='Projects';
    $this->filter_tables['ProjectsPriority']='Project Priority';
    $this->filter_tables['ProjectsStatus']='Project Status';
    $this->filter_tables['ProjectsTypes']='Project Type';
    $this->filter_tables['ProjectsGroups']='Project Group';
    
    $extra_fields = Doctrine_Core::getTable('ExtraFields')
      ->createQuery('a')
      ->addWhere('bind_type=?','tasks')
      ->whereIn('type',array('pull_down','checkbox','radiobox'))
      ->orderBy('sort_order, name')
      ->execute();
      
    foreach($extra_fields as $f)
    {
      $this->filter_tables['extraField' . $f->getId()] = $f->getName();
    }
  }
      
}