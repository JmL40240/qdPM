<?php

class tasksComponents extends sfComponents
{
  public function executeChildTasks(sfWebRequest $request)
  {
    $q = Doctrine_Core::getTable('Tasks')->createQuery('t')          
            ->leftJoin('t.TasksStatus ts')
            ->leftJoin('t.TasksLabels tl')          
            ->leftJoin('t.Projects p')    
            ->whereIn('parent_id',$this->tasks_id)                
            ->addWhere('t.in_trash is null')
            ->addWhere('p.in_trash is null');
            
    if(Users::hasAccess('view_own','tasks',$this->getUser(),$request->getParameter('projects_id')))
    {                 
      $q->addWhere("find_in_set('" . $this->getUser()->getAttribute('id') . "',t.assigned_to) or t.created_by='" . $this->getUser()->getAttribute('id') . "'");
    }
    
    $q->orderBy('t.name');        
            
    $this->tasks_list = $q->fetchArray();
  }
  
  
  public function executeListingTree(sfWebRequest $request)
  {
    $this->tasks_tree = TasksTree::getTasksTree($this->getUser(), $request->getParameter('projects_id'));
            
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
          
    $q->addWhere('projects_id=?',$request->getParameter('projects_id'));
    
    if(Users::hasAccess('view_own','tasks',$this->getUser(),$request->getParameter('projects_id')))
    {                 
      $q->addWhere("find_in_set('" . $this->getUser()->getAttribute('id') . "',t.assigned_to) or t.created_by='" . $this->getUser()->getAttribute('id') . "'");
    }
                                      
    $q = Tasks::addFiltersToQuery($q,$this->getUser()->getAttribute('tasks_filter' . ((int)$request->getParameter('projects_id')>0 ? $request->getParameter('projects_id') : '')));                  
        
    $q->whereIn('id',TasksTree::getTasksTreeIdOrder($this->tasks_tree));
    
    if(count($this->tasks_tree)>0)
    {
      $q->orderBy('FIELD(id,' . implode(',',TasksTree::getTasksTreeIdOrder($this->tasks_tree)) . ')');
    }
                                      
    $this->tasks_list = $q->fetchArray();
                
    $this->url_params = 'projects_id=' . $request->getParameter('projects_id');
    $this->display_insert_button = true;
    
    $this->tlId = rand(1111111,9999999);
    
    $this->users_schema = Users::getSchema();
        
  }
  
  public function executeListing(sfWebRequest $request)
  {
    if(!isset($this->reports_id)) $this->reports_id = false;
    
    
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
          
    if($request->hasParameter('projects_id'))
    {
      $q->addWhere('projects_id=?',$request->getParameter('projects_id'));
      
      if(Users::hasAccess('view_own','tasks',$this->getUser(),$request->getParameter('projects_id')))
      {                 
        $q->addWhere("find_in_set('" . $this->getUser()->getAttribute('id') . "',t.assigned_to) or t.created_by='" . $this->getUser()->getAttribute('id') . "'");
      }
    }
    else
    {
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
    }      
                              
    if($this->reports_id>0)
    {
      $q = UserReports::addFiltersToQuery($q,$this->reports_id,$this->getUser()->getAttribute('id'));
    }                
    elseif($request->hasParameter('search'))
    {    
      $q = app::addSearchQuery($q, $request->getParameter('search'),'TasksComments','t',$request->getParameter('search_by_extrafields'));
      $q = app::addListingOrder($q,'tasks',$this->getUser()->getAttribute('id'));
    }
    else
    {
      $q = Tasks::addFiltersToQuery($q,$this->getUser()->getAttribute('tasks_filter' . ((int)$request->getParameter('projects_id')>0 ? $request->getParameter('projects_id') : '')));
      $q = app::addListingOrder($q,'tasks',$this->getUser()->getAttribute('id'), (int)$request->getParameter('projects_id'));            
    }
    
    if(sfConfig::get('app_rows_limit')>0)
    {
      $this->pager = new sfDoctrinePager('Tasks', sfConfig::get('app_rows_limit'));
      $this->pager->setQuery($q);
      $this->pager->setPage($request->getParameter('page', 1));
      $this->pager->init();
    }
                                      
    $this->tasks_list = $q->fetchArray();
    
    
            
    if(isset($this->is_dashboard))
    {
      $this->url_params = 'redirect_to=dashboard';
      $this->display_insert_button = true;
    }
    elseif($this->reports_id>0)
    {
      $this->url_params = 'redirect_to=userReports' . $this->reports_id;
      $this->display_insert_button = true;
    }
    else
    {
      $this->url_params = '';
      if($request->hasParameter('projects_id')) $this->url_params = 'projects_id=' . $request->getParameter('projects_id');
      $this->display_insert_button = true;
    }
    
    $this->tlId = rand(1111111,9999999);
    
    $this->users_schema = Users::getSchema();
  }
  
  public function executeFilters(sfWebRequest $request)
  {  
    $m = array();
    
    $params = ((int)$request->getParameter('projects_id')>0 ? 'projects_id=' . $request->getParameter('projects_id') : false);
            
    $m = app::getFilterMenuItemsByTable($m,'TasksPriority','Priority','tasks/index',$params);
    $m = app::getFilterMenuStatusItemsByTable($m,'TasksStatus','Status','tasks/index',$params);
    $m = app::getFilterMenuItemsByTable($m,'TasksLabels','Label','tasks/index',$params);
    $m = app::getFilterMenuItemsByTable($m,'TasksTypes','Type','tasks/index',$params);  
    $m = app::getFilterMenuUsers($m,'TasksAssignedTo', 'Assigned To','tasks/index',$params);
    $m = app::getFilterMenuUsers($m,'TasksCreatedBy','Created By','tasks/index',$params);
    $m = app::getFilterExtraFields($m,false,'tasks','tasks/index',$params,array(),$this->getUser());
    
    if(!$params)
    {
      $m = app::getFilterProjects($m,'tasks/index',$params,array(),$this->getUser());
      $m = app::getFilterMenuItemsByTable($m,'ProjectsPriority','Projects Priorities','tasks/index',$params);
      $m = app::getFilterMenuStatusItemsByTable($m,'ProjectsStatus','Projects Status','tasks/index',$params);
      $m = app::getFilterMenuItemsByTable($m,'ProjectsTypes','Projects Types','tasks/index',$params);
      $m = app::getFilterMenuItemsByTable($m,'ProjectsGroups','Projects Groups','tasks/index',$params,array(),$this->getUser());
    }
    else
    {
      $m = app::getFilterMenuItemsByTable($m,'TasksGroups','Group','tasks/index',$params);  
      $m = app::getFilterMenuItemsByTable($m,'ProjectsPhases','Phase','tasks/index',$params);
      $m = app::getFilterMenuItemsByTable($m,'Versions','Version','tasks/index',$params);
    }
    
    $m = app::getSavedFilters($m,'tasks/index',$params,'UserReports',Tasks::getReportType($request),$this->getUser());
    
    $m[] = array('title'=>__('Save Filter'),'url'=>'tasks/saveFilter' . ($params ? '?' . $params:''),'is_hr'=>true,'modalbox'=>true);
                    
    $this->m = array(array('title'=>__('Filters'),'submenu'=>$m));
  }
  
  public function executeFiltersPreview(sfWebRequest $request)
  {
    $this->filter_by = $this->getUser()->getAttribute('tasks_filter' . ((int)$request->getParameter('projects_id')>0 ? $request->getParameter('projects_id') : ''));
    $this->params = ((int)$request->getParameter('projects_id')>0 ? 'projects_id=' . $request->getParameter('projects_id') : false);
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
      
  public function executeDetails()
  {
       
  }
  
  public function executeEmailBody()
  {
    $this->comments_history = Doctrine_Core::getTable('TasksComments')
      ->createQuery()
      ->addWhere('tasks_id=?',$this->tasks->getId())
      ->addWhere('in_trash is null')
      ->orderBy('created_at desc')
      ->limit((int)sfConfig::get('app_amount_previous_comments',2))
      ->execute();    
  }
  
  public function executeRelatedTasksToDiscussions()
  {          
    $tasks = Doctrine_Core::getTable('TasksToDiscussions')->createQuery()->addSelect('group_concat(tasks_id) as tasks_list')->addWhere('discussions_id=?',$this->discussions_id)->groupBy('discussions_id')->fetchArray(); 
    
    $this->tasks_list = array();
    
    if(count($tasks)>0)
    {    
      $tasks = current($tasks);
       
      $this->tasks_list = $q = Doctrine_Core::getTable('Tasks')->createQuery('t')          
            ->leftJoin('t.TasksStatus ts')
            ->leftJoin('t.TasksLabels tl')          
            ->leftJoin('t.Projects p')    
            ->whereIn('id',explode(',',$tasks['tasks_list']))                
            ->addWhere('t.in_trash is null')
            ->addWhere('p.in_trash is null')
            ->fetchArray();
    }
  }
  
  public function executeRelatedTasksToTickets()
  {          
    $tasks = Doctrine_Core::getTable('TasksToTickets')->createQuery()->addSelect('group_concat(tasks_id) as tasks_list')->addWhere('tickets_id=?',$this->tickets_id)->groupBy('tickets_id')->fetchArray(); 
    
    $this->tasks_list = array();
    
    if(count($tasks)>0)
    {    
      $tasks = current($tasks);
       
      $this->tasks_list = $q = Doctrine_Core::getTable('Tasks')->createQuery('t')          
            ->leftJoin('t.TasksStatus ts')
            ->leftJoin('t.TasksLabels tl')          
            ->leftJoin('t.Projects p')    
            ->whereIn('id',explode(',',$tasks['tasks_list']))                
            ->addWhere('t.in_trash is null')
            ->addWhere('p.in_trash is null')
            ->fetchArray();
    }
  }
  
  public function executeViewType()
  {
    $s = array();
    $s[] = array('title'=>__('List'),'url'=>'tasks/index?projects_id=' . $this->projects->getId() . '&setViewType=list');
    $s[] = array('title'=>__('Tree'),'url'=>'tasks/index?projects_id=' . $this->projects->getId() . '&setViewType=tree');
    $this->m = array(array('title'=>__('View Type'),'submenu'=>$s));
  }
}