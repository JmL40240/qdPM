<?php

class usersProjectsReportComponents extends sfComponents
{
  public function executeListing(sfWebRequest $request)
  {           
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
    
    $q = Projects::addFiltersToQuery($q,$this->getUser()->getAttribute('usersprojects_filter'));
    
    $q->orderBy('name');
                                       
    $projects_list = $q->fetchArray();
    
    $this->usersprojects = array();
    $this->projectsnames = array();
    $this->usersnames = Users::getSchema();
    $this->userscountprojects = array();
    
    foreach($projects_list as $p)
    {
      foreach(explode(',',$p['team']) as $uid)
      {
        $this->projectsnames[$p['id']] = $p['name'];
        
        if($uid>0)
        {                
          if(!isset($this->usersprojects[$uid]))
          {
            $this->usersprojects[$uid] = array();
          }
          
          array_push($this->usersprojects[$uid],$p['id']);
        }
      }
    } 
    
    foreach($this->usersprojects as $id=>$plist)
    {
      $this->userscountprojects[$id] = count($plist);
    } 
    
    arsort($this->userscountprojects);
    
    //echo '<pre>';
    //print_r($this->userscountprojects);                              
  }
  
  public function executeFilters()
  {
    $m = array();
            
    $m = app::getFilterMenuItemsByTable($m,'ProjectsPriority','Priority','usersProjectsReport/index');
    $m = app::getFilterMenuStatusItemsByTable($m,'ProjectsStatus','Status','usersProjectsReport/index');
    $m = app::getFilterMenuItemsByTable($m,'ProjectsTypes','Type','usersProjectsReport/index');
    $m = app::getFilterMenuItemsByTable($m,'ProjectsGroups','Group','usersProjectsReport/index','',array(),$this->getUser());
    $m = app::getFilterMenuUsers($m,'Users','In Team','usersProjectsReport/index');
    $m = app::getFilterExtraFields($m,false,'projects','usersProjectsReport/index',false,array(),$this->getUser());
    
    $m = app::getSavedFilters($m,'usersProjectsReport/index',false,'ProjectsReports','users_projects_filter',$this->getUser());
    
    $m[] = array('title'=>__('Save Filter'),'url'=>'usersProjectsReport/saveFilter','is_hr'=>true,'modalbox'=>true);
                    
    $this->m = array(array('title'=>__('Filters'),'submenu'=>$m));
  }
  
  public function executeFiltersPreview()
  {
    $this->filter_by = $this->getUser()->getAttribute('usersprojects_filter');
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

}