<?php

class ticketsComponents extends sfComponents
{
  public function executeListing(sfWebRequest $request)
  {
    if(!isset($this->reports_id)) $this->reports_id = false;
        
    $q = Doctrine_Core::getTable('Tickets')->createQuery('t')
          ->leftJoin('t.TicketsPriority tp')
          ->leftJoin('t.TicketsStatus ts')          
          ->leftJoin('t.TicketsTypes tt')
          ->leftJoin('t.TicketsGroups tg')                    
          ->leftJoin('t.Departments td')
          ->leftJoin('t.Projects p')
          ->leftJoin('t.Users')          
          ->addWhere('t.in_trash is null')
          ->addWhere('p.in_trash is null');
          
    if($request->hasParameter('projects_id'))
    {
      $q->addWhere('projects_id=?',$request->getParameter('projects_id'));
      
      if(Users::hasAccess('view_own','tickets',$this->getUser(),$request->getParameter('projects_id')))
      {                 
        $q->addWhere("t.departments_id in (" . implode(',',Departments::getDepartmentIdByUserId($this->getUser()->getAttribute('id'))). ") or t.users_id='" . $this->getUser()->getAttribute('id') . "'");
      }
    }
    else
    {
      if(Users::hasAccess('view_own','projects',$this->getUser()))
      {       
        $q->addWhere("find_in_set('" . $this->getUser()->getAttribute('id') . "',team) or p.created_by='" . $this->getUser()->getAttribute('id') . "'");
      }
      
      if(Users::hasAccess('view_own','tickets',$this->getUser()))
      {                 
        $q->addWhere("t.departments_id in (" . implode(',',Departments::getDepartmentIdByUserId($this->getUser()->getAttribute('id'))). ") or t.users_id='" . $this->getUser()->getAttribute('id') . "'");
      }
      
      if(count($list = ProjectsRoles::getNotAllowedProjectsByModule('tickets',$this->getUser()->getAttribute('id')))>0)
      {
        $q->whereNotIn('p.id',$list);
      }
    }      
                              
    if($this->reports_id>0)
    {
      $q = TicketsReports::addFiltersToQuery($q,$this->reports_id,$this->getUser());      
    }                
    elseif($request->hasParameter('search'))
    {    
      $q = app::addSearchQuery($q, $request->getParameter('search'),'TicketsComments','t',$request->getParameter('search_by_extrafields'));
      $q = app::addListingOrder($q,'tickets',$this->getUser()->getAttribute('id'));
    }
    else
    {
      $q = Tickets::addFiltersToQuery($q,$this->getUser()->getAttribute('tickets_filter' . ((int)$request->getParameter('projects_id')>0 ? $request->getParameter('projects_id') : '')));
      $q = app::addListingOrder($q,'tickets',$this->getUser()->getAttribute('id'), (int)$request->getParameter('projects_id'));            
    }
    
    if(sfConfig::get('app_rows_limit')>0)
    {
      $this->pager = new sfDoctrinePager('Tickets', sfConfig::get('app_rows_limit'));
      $this->pager->setQuery($q);
      $this->pager->setPage($request->getParameter('page', 1));
      $this->pager->init();
    }
                                  
    $this->tickets_list = $q->fetchArray();
            
    if(isset($this->is_dashboard))
    {
      $this->url_params = 'redirect_to=dashboard';
      $this->display_insert_button = true;
    }
    elseif($this->reports_id>0)
    {
      $this->url_params = 'redirect_to=ticketsReports' . $this->reports_id;
      $this->display_insert_button = true;
    }
    else
    {
      $this->url_params = 'redirect_to=ticketsList';
      if($request->hasParameter('projects_id')) $this->url_params = 'projects_id=' . $request->getParameter('projects_id');
      $this->display_insert_button = true;
    }
    
    $this->tlId = rand(1111111,9999999);
  }
  
  public function executeFilters(sfWebRequest $request)
  {  
    $m = array();
    
    $params = ((int)$request->getParameter('projects_id')>0 ? 'projects_id=' . $request->getParameter('projects_id') : false);
            
    //$m = app::getFilterMenuItemsByTable($m,'TicketsPriority','Priority','tickets/index',$params);
    $m = app::getFilterMenuStatusItemsByTable($m,'TicketsStatus','Status','tickets/index',$params);
    $m = app::getFilterMenuItemsByTable($m,'TicketsGroups','Groups','tickets/index',$params);
    $m = app::getFilterMenuItemsByTable($m,'TicketsTypes','Type','tickets/index',$params);  
    $m = app::getFilterMenuItemsByTable($m,'Departments', 'Domaine DSI','tickets/index',$params);
	$m = app::getFilterMenuUsers($m,'TicketsCreatedBy','Responsable DSI','tickets/index',$params);
    $m = app::getFilterExtraFields($m,false,'tickets','tickets/index',$params,array(),$this->getUser());
    
    if(!$params)
    {
      $m = app::getFilterProjects($m,'tickets/index',$params,array(),$this->getUser());
      $m = app::getFilterMenuItemsByTable($m,'ProjectsPriority','Projects Priorities','tickets/index',$params);
      $m = app::getFilterMenuStatusItemsByTable($m,'ProjectsStatus','Projects Status','tickets/index',$params);
      $m = app::getFilterMenuItemsByTable($m,'ProjectsTypes','Projects Types','tickets/index',$params);
      $m = app::getFilterMenuItemsByTable($m,'ProjectsGroups','Projects Groups','tickets/index',$params,array(),$this->getUser());
    }

    
    $m = app::getSavedFilters($m,'tickets/index',$params,'TicketsReports',Tickets::getReportType($request),$this->getUser());
    
    $m[] = array('title'=>__('Save Filter'),'url'=>'tickets/saveFilter' . ($params ? '?' . $params:''),'is_hr'=>true,'modalbox'=>true);
                    
    $this->m = array(array('title'=>__('Filters'),'submenu'=>$m));
  }
  
  public function executeFiltersPreview(sfWebRequest $request)
  {
    $this->filter_by = $this->getUser()->getAttribute('tickets_filter' . ((int)$request->getParameter('projects_id')>0 ? $request->getParameter('projects_id') : ''));
    $this->params = ((int)$request->getParameter('projects_id')>0 ? 'projects_id=' . $request->getParameter('projects_id') : false);
    $this->filter_tables = array('TicketsPriority'=>'Priority', 'TicketsStatus'=>'Status','TicketsTypes'=>'Type','TicketsGroups'=>'Group','Departments'=>'Department','TicketsCreatedBy'=>'Created By');
    
    $this->filter_tables['Projects']='Projects';
    $this->filter_tables['ProjectsPriority']='Project Priority';
    $this->filter_tables['ProjectsStatus']='Project Status';
    $this->filter_tables['ProjectsTypes']='Project Type';
    $this->filter_tables['ProjectsGroups']='Project Group';
    
    $extra_fields = Doctrine_Core::getTable('ExtraFields')
      ->createQuery('a')
      ->addWhere('bind_type=?','tickets')
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
    $this->comments_history = Doctrine_Core::getTable('TicketsComments')
      ->createQuery()
      ->addWhere('tickets_id=?',$this->tickets->getId())
      ->addWhere('in_trash is null')
      ->orderBy('created_at desc')
      ->limit((int)sfConfig::get('app_amount_previous_comments',2))
      ->execute();   
  }
  
  
  public function executeRelatedTicketsToTasks()
  {          
    $tickets = Doctrine_Core::getTable('TasksToTickets')->createQuery()->addSelect('group_concat(tickets_id) as tickets_list')->addWhere('tasks_id=?',$this->tasks_id)->groupBy('tasks_id')->fetchArray(); 
    
    $this->tickets_list = array();
    
    if(count($tickets)>0)
    {    
      $tickets = current($tickets);
       
      $this->tickets_list = $q = Doctrine_Core::getTable('Tickets')->createQuery('t')          
            ->leftJoin('t.TicketsStatus ts')
            ->leftJoin('t.TicketsTypes tt')          
            ->leftJoin('t.Projects p')    
            ->whereIn('id',explode(',',$tickets['tickets_list']))                
            ->addWhere('t.in_trash is null')
            ->addWhere('p.in_trash is null')
            ->fetchArray();
    }
  }
  
  public function executeRelatedTicketsToDiscussions()
  {          
    $tickets = Doctrine_Core::getTable('TicketsToDiscussions')->createQuery()->addSelect('group_concat(tickets_id) as tickets_list')->addWhere('discussions_id=?',$this->discussions_id)->groupBy('discussions_id')->fetchArray(); 
    
    $this->tickets_list = array();
    
    if(count($tickets)>0)
    {    
      $tickets = current($tickets);
       
      $this->tickets_list = $q = Doctrine_Core::getTable('Tickets')->createQuery('t')          
            ->leftJoin('t.TicketsStatus ts')
            ->leftJoin('t.TicketsTypes tt')          
            ->leftJoin('t.Projects p')    
            ->whereIn('id',explode(',',$tickets['tickets_list']))                
            ->addWhere('t.in_trash is null')
            ->addWhere('p.in_trash is null')
            ->fetchArray();
    }
         
  }
  
  public function executeRelatedTicketsToTasksComments()
  {          
    $tickets = Doctrine_Core::getTable('TasksToTickets')->createQuery()->addSelect('group_concat(tickets_id) as tickets_list')->addWhere('tasks_id=?',$this->tasks_id)->groupBy('tasks_id')->fetchArray(); 
    
    $this->tickets_list = array();
    
    if(count($tickets)>0)
    {    
      $tickets = current($tickets);
       
      $this->tickets_list = $q = Doctrine_Core::getTable('Tickets')->createQuery('t')          
            ->leftJoin('t.TicketsStatus ts')
            ->leftJoin('t.TicketsTypes tt')          
            ->leftJoin('t.Projects p')    
            ->whereIn('id',explode(',',$tickets['tickets_list']))                
            ->addWhere('t.in_trash is null')
            ->addWhere('p.in_trash is null')
            ->fetchArray();
    }
  }    
  
}