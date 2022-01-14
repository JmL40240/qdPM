<?php

class discussionsComponents extends sfComponents
{
  public function executeListing(sfWebRequest $request)
  {
    if(!isset($this->reports_id)) $this->reports_id = false;
    
    
    $q = Doctrine_Core::getTable('Discussions')->createQuery('d')
          ->leftJoin('d.DiscussionsPriority dp')
          ->leftJoin('d.DiscussionsStatus ds')          
          ->leftJoin('d.DiscussionsTypes dt')
          ->leftJoin('d.DiscussionsGroups dg')                   
          ->leftJoin('d.Projects p')
          ->leftJoin('d.Users')          
          ->addWhere('d.in_trash is null')
          ->addWhere('p.in_trash is null');
          
    if($request->hasParameter('projects_id'))
    {
      $q->addWhere('projects_id=?',$request->getParameter('projects_id'));
      
      if(Users::hasAccess('view_own','discussions',$this->getUser(),$request->getParameter('projects_id')))
      {                 
        $q->addWhere("find_in_set('" . $this->getUser()->getAttribute('id') . "',d.assigned_to) or d.users_id='" . $this->getUser()->getAttribute('id') . "'");
      }
    }
    else
    {
      if(Users::hasAccess('view_own','projects',$this->getUser()))
      {       
        $q->addWhere("find_in_set('" . $this->getUser()->getAttribute('id') . "',team) or p.created_by='" . $this->getUser()->getAttribute('id') . "'");
      }
      
      if(Users::hasAccess('view_own','discussions',$this->getUser()))
      {                 
        $q->addWhere("find_in_set('" . $this->getUser()->getAttribute('id') . "',d.assigned_to) or d.users_id='" . $this->getUser()->getAttribute('id') . "'");
      }
      
      if(count($list = ProjectsRoles::getNotAllowedProjectsByModule('discussions',$this->getUser()->getAttribute('id')))>0)
      {
        $q->whereNotIn('p.id',$list);
      }
    }      
                              
    if($this->reports_id>0)
    {
      $q = DiscussionsReports::addFiltersToQuery($q,$this->reports_id,$this->getUser());      
    }                
    elseif($request->hasParameter('search'))
    {    
      $q = app::addSearchQuery($q, $request->getParameter('search'),'DiscussionsComments','d',$request->getParameter('search_by_extrafields'));
      $q = app::addListingOrder($q,'discussions',$this->getUser()->getAttribute('id'));
    }
    else
    {
      $q = Discussions::addFiltersToQuery($q,$this->getUser()->getAttribute('discussions_filter' . ((int)$request->getParameter('projects_id')>0 ? $request->getParameter('projects_id') : '')));
      $q = app::addListingOrder($q,'discussions',$this->getUser()->getAttribute('id'), (int)$request->getParameter('projects_id'));            
    }
    
    if(sfConfig::get('app_rows_limit')>0)
    {
      $this->pager = new sfDoctrinePager('Discussions', sfConfig::get('app_rows_limit'));
      $this->pager->setQuery($q);
      $this->pager->setPage($request->getParameter('page', 1));
      $this->pager->init();
    }
                                  
    $this->discussions_list = $q->fetchArray();
            
    if(isset($this->is_dashboard))
    {
      $this->url_params = 'redirect_to=dashboard';
      $this->display_insert_button = true;
    }
    elseif($this->reports_id>0)
    {
      $this->url_params = 'redirect_to=discussionsReports' . $this->reports_id;
      $this->display_insert_button = true;
    }
    else
    {
      $this->url_params = '';
      if($request->hasParameter('projects_id')) $this->url_params = 'projects_id=' . $request->getParameter('projects_id');
      $this->display_insert_button = true;
    }
    
    $this->tlId = rand(1111111,9999999);
  }
  
  public function executeFilters(sfWebRequest $request)
  {  
    $m = array();
    
    $params = ((int)$request->getParameter('projects_id')>0 ? 'projects_id=' . $request->getParameter('projects_id') : false);
            
    $m = app::getFilterMenuItemsByTable($m,'DiscussionsPriority','Priority','discussions/index',$params);
    $m = app::getFilterMenuStatusItemsByTable($m,'DiscussionsStatus','Status','discussions/index',$params);
    $m = app::getFilterMenuItemsByTable($m,'DiscussionsGroups','Group','discussions/index',$params);
    $m = app::getFilterMenuItemsByTable($m,'DiscussionsTypes','Type','discussions/index',$params);  
    $m = app::getFilterMenuUsers($m,'DiscussionsAssignedTo', 'Assigned To','discussions/index',$params);
    $m = app::getFilterMenuUsers($m,'DiscussionsCreatedBy','Created By','discussions/index',$params);
    $m = app::getFilterExtraFields($m,false,'discussions','discussions/index',$params,array(),$this->getUser());
    
    if(!$params)
    {
      $m = app::getFilterProjects($m,'discussions/index',$params,array(),$this->getUser());
      $m = app::getFilterMenuItemsByTable($m,'ProjectsPriority','Projects Priorities','discussions/index',$params);
      $m = app::getFilterMenuStatusItemsByTable($m,'ProjectsStatus','Projects Status','discussions/index',$params);
      $m = app::getFilterMenuItemsByTable($m,'ProjectsTypes','Projects Types','discussions/index',$params);
      $m = app::getFilterMenuItemsByTable($m,'ProjectsGroups','Projects Groups','discussions/index',$params,array(),$this->getUser());
    }
    
    $m = app::getSavedFilters($m,'discussions/index',$params,'DiscussionsReports',Discussions::getReportType($request),$this->getUser());
    
    $m[] = array('title'=>__('Save Filter'),'url'=>'discussions/saveFilter' . ($params ? '?' . $params:''),'is_hr'=>true,'modalbox'=>true);
                    
    $this->m = array(array('title'=>__('Filters'),'submenu'=>$m));
  }
  
  public function executeFiltersPreview(sfWebRequest $request)
  {
    $this->filter_by = $this->getUser()->getAttribute('discussions_filter' . ((int)$request->getParameter('projects_id')>0 ? $request->getParameter('projects_id') : ''));
    $this->params = ((int)$request->getParameter('projects_id')>0 ? 'projects_id=' . $request->getParameter('projects_id') : false);
    $this->filter_tables = array('DiscussionsPriority'=>'Priority', 'DiscussionsStatus'=>'Status','DiscussionsTypes'=>'Type','DiscussionsAssignedTo'=>'Assigned To','DiscussionsCreatedBy'=>'Created By','DiscussionsGroups'=>'Group');
    
    $this->filter_tables['Projects']='Projects';
    $this->filter_tables['ProjectsPriority']='Project Priority';
    $this->filter_tables['ProjectsStatus']='Project Status';
    $this->filter_tables['ProjectsTypes']='Project Type';
    $this->filter_tables['ProjectsGroups']='Project Group';
    
    $extra_fields = Doctrine_Core::getTable('ExtraFields')
      ->createQuery('a')
      ->addWhere('bind_type=?','discussions')
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
    $this->comments_history = Doctrine_Core::getTable('DiscussionsComments')
      ->createQuery()
      ->addWhere('discussions_id=?',$this->discussions->getId())
      ->addWhere('in_trash is null')
      ->orderBy('created_at desc')
      ->limit((int)sfConfig::get('app_amount_previous_comments',2))
      ->execute();   
  }
  
  public function executeRelatedDiscussionsToTasks()
  {          
    $discussions = Doctrine_Core::getTable('TasksToDiscussions')->createQuery()->addSelect('group_concat(discussions_id) as discussions_list')->addWhere('tasks_id=?',$this->tasks_id)->groupBy('tasks_id')->fetchArray(); 
    
    $this->discussions_list = array();
    
    if(count($discussions)>0)
    {    
      $discussions = current($discussions);
       
      $this->discussions_list = $q = Doctrine_Core::getTable('Discussions')->createQuery('t')          
            ->leftJoin('t.DiscussionsStatus ts')
            ->leftJoin('t.DiscussionsTypes tt')          
            ->leftJoin('t.Projects p')    
            ->whereIn('id',explode(',',$discussions['discussions_list']))                
            ->addWhere('t.in_trash is null')
            ->addWhere('p.in_trash is null')
            ->fetchArray();
    }
  }
  
  public function executeRelatedDiscussionsToTickets()
  {          
    $discussions = Doctrine_Core::getTable('TicketsToDiscussions')->createQuery()->addSelect('group_concat(discussions_id) as discussions_list')->addWhere('tickets_id=?',$this->tickets_id)->groupBy('tickets_id')->fetchArray(); 
    
    $this->discussions_list = array();
    
    if(count($discussions)>0)
    {    
      $discussions = current($discussions);
       
      $this->discussions_list = $q = Doctrine_Core::getTable('Discussions')->createQuery('t')          
            ->leftJoin('t.DiscussionsStatus ts')
            ->leftJoin('t.DiscussionsTypes tt')          
            ->leftJoin('t.Projects p')    
            ->whereIn('id',explode(',',$discussions['discussions_list']))                
            ->addWhere('t.in_trash is null')
            ->addWhere('p.in_trash is null')
            ->fetchArray();
    }
  }
}