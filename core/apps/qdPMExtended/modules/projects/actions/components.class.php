<?php

class projectsComponents extends sfComponents
{
  public function executeListing(sfWebRequest $request)
  {
    if(!isset($this->reports_id)) $this->reports_id = false;
    
    
    $q = Doctrine_Core::getTable('Projects')->createQuery('p')
          ->leftJoin('p.ProjectsPriority pp')
          ->leftJoin('p.ProjectsStatus ps')
          ->leftJoin('p.ProjectsTypes pt')
          ->leftJoin('p.ProjectsGroups pg')
          ->leftJoin('p.Users')
          ->addWhere('in_trash is null');
          
    if(Users::hasAccess('view_own','projects',$this->getUser()))
    {       
      $q->addWhere("find_in_set('" . $this->getUser()->getAttribute('id') . "',p.team) or p.created_by='" . $this->getUser()->getAttribute('id') . "'");
    }
    
    if($this->reports_id>0)
    {
      $q = ProjectsReports::addFiltersToQuery($q,$this->reports_id, $this->getUser());      
    }                
    elseif($request->hasParameter('search'))
    {    
      $q = app::addSearchQuery($q, $request->getParameter('search'),'ProjectsComments','p',$request->getParameter('search_by_extrafields'));
      $q = app::addListingOrder($q,'projects',$this->getUser()->getAttribute('id'));
    }
    else
    {
      $q = Projects::addFiltersToQuery($q,$this->getUser()->getAttribute('projects_filter'));
      $q = app::addListingOrder($q,'projects',$this->getUser()->getAttribute('id'));
    }
    
    if(sfConfig::get('app_rows_limit')>0)
    {
      $this->pager = new sfDoctrinePager('Projects', sfConfig::get('app_rows_limit'));
      $this->pager->setQuery($q);
      $this->pager->setPage($request->getParameter('page', 1));
      $this->pager->init();
    }
                          
    $this->projects_list = $q->fetchArray();
                 
    if(isset($this->is_dashboard))
    {
      $this->url_params = 'redirect_to=dashboard';
      $this->display_insert_button = true;
    }
    elseif($this->reports_id>0)
    {
      $this->url_params = 'redirect_to=projectsReports' . $this->reports_id;
      $this->display_insert_button = true;
    }
    else
    {
      $this->url_params = '';                         
      $this->display_insert_button = true;
    }
    
    $this->tlId = rand(1111111,9999999);
  }
  
  public function executeFilters()
  {
    $m = array();
            
    $m = app::getFilterMenuItemsByTable($m,'ProjectsPriority','Priority','projects/index');
    $m = app::getFilterMenuStatusItemsByTable($m,'ProjectsStatus','Status','projects/index');
    $m = app::getFilterMenuItemsByTable($m,'ProjectsTypes','Type','projects/index');
    $m = app::getFilterMenuItemsByTable($m,'ProjectsGroups','Group','projects/index',false,array(),$this->getUser());
    
    if(!Users::hasAccess('view_own','projects',$this->getUser()))
    $m = app::getFilterMenuUsers($m,'Users','In Team','projects/index');
    
    $m = app::getFilterExtraFields($m,false,'projects','projects/index',false,array(),$this->getUser());
    
    $m = app::getSavedFilters($m,'projects/index',false,'ProjectsReports','filter',$this->getUser());
    
    $m[] = array('title'=>__('Save Filter'),'url'=>'projects/saveFilter','is_hr'=>true,'modalbox'=>true);
                    
    $this->m = array(array('title'=>__('Filters'),'submenu'=>$m));
  }
  
  public function executeFiltersPreview()
  {
    $this->filter_by = $this->getUser()->getAttribute('projects_filter');
    $this->filter_tables = array('ProjectsPriority'=>'Priority', 'ProjectsStatus'=>'Status','ProjectsTypes'=>'Type','ProjectsGroups'=>'Group','Users'=>'In Team');
    
    $extra_fields = Doctrine_Core::getTable('ExtraFields')
      ->createQuery('a')
      ->addWhere('bind_type=?','projects')
      ->whereIn('type',array('pull_down','checkbox','radiobox'))
      ->orderBy('sort_order, name')
      ->fetchArray();
      
    foreach($extra_fields as $f)
    {
      $this->filter_tables['extraField' . $f['id']] = $f['name'];
    }
  }
  
  public function executeTeam()
  {
    if($this->project->isNew())
    {
      $this->in_team = array();
      $this->in_role = array();
    }
    else
    {
      $this->in_team = explode(',',$this->project->getTeam());
      $this->project_id = $this->project->getId();  
    }
            
    $this->users_list = Users::getChoices();
    $this->roles_choices = UsersGroups::getChoicesByType('project_role',true);        
  }
  
  public function executeShortInfo()
  {
    $this->m = array();
    
    if($this->projects->getProjectsGroupsId()>0)
    {
      $q = Doctrine_Core::getTable('Projects')->createQuery('p')
          ->leftJoin('p.ProjectsPriority pp')
          ->leftJoin('p.ProjectsStatus ps')
          ->leftJoin('p.ProjectsTypes pt')
          ->leftJoin('p.ProjectsGroups pg')
          ->leftJoin('p.Users')
          ->addWhere('in_trash is null')
          ->addWhere('projects_groups_id=?',$this->projects->getProjectsGroupsId())
          ->orderBy('p.name');
          
      if(Users::hasAccess('view_own','projects',$this->getUser()))
      {       
        $q->addWhere("find_in_set('" . $this->getUser()->getAttribute('id') . "',p.team) or p.created_by='" . $this->getUser()->getAttribute('id') . "'");
      }
      
      foreach($q->fetchArray() as $p)
      {
        if($p['id']==$this->projects->getId()) $p['name'] = '<b>' . $p['name'] . '</b>';
        
        $this->m[] = array('title'=>$p['name'],'url'=>'projects/open?projects_id=' . $p['id']);
      } 
    }   
  }
  
  public function executeDetails()
  {
       
  }
  
  public function executeEmailBody()
  {
    $this->comments_history = Doctrine_Core::getTable('ProjectsComments')
      ->createQuery()
      ->addWhere('projects_id=?',$this->projects->getId())
      ->addWhere('in_trash is null')
      ->orderBy('created_at desc')
      ->limit((int)sfConfig::get('app_amount_previous_comments',2))
      ->execute();    
  }
}