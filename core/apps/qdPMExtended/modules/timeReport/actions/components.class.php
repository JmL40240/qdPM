<?php

class timeReportComponents extends sfComponents
{
  public function executeExtraFilters(sfWebRequest $request)
  { 
  
  }
  
  public function executeFilters(sfWebRequest $request)
  {  
    $m = array();
    
    $params = ((int)$request->getParameter('projects_id')>0 ? 'projects_id=' . $request->getParameter('projects_id') : false);
            
    $m = app::getFilterMenuItemsByTable($m,'TasksPriority','Priority','timeReport/' . $this->action_name,$params);
    $m = app::getFilterMenuStatusItemsByTable($m,'TasksStatus','Status','timeReport/' . $this->action_name,$params);
    $m = app::getFilterMenuItemsByTable($m,'TasksLabels','Label','timeReport/' . $this->action_name,$params);
    $m = app::getFilterMenuItemsByTable($m,'TasksTypes','Type','timeReport/' . $this->action_name,$params);  
    $m = app::getFilterMenuUsers($m,'TasksAssignedTo', 'Assigned To','timeReport/' . $this->action_name,$params);
    $m = app::getFilterMenuUsers($m,'TasksCreatedBy','Created By','timeReport/' . $this->action_name,$params);
    $m = app::getFilterExtraFields($m,false,'tasks','timeReport/' . $this->action_name,$params,array(),$this->getUser());
    
    if(!$params)
    {
      $m = app::getFilterProjects($m,'timeReport/' . $this->action_name,$params,array(),$this->getUser());
      $m = app::getFilterMenuItemsByTable($m,'ProjectsPriority','Projects Priorities','timeReport/' . $this->action_name,$params);
      $m = app::getFilterMenuStatusItemsByTable($m,'ProjectsStatus','Projects Status','timeReport/' . $this->action_name,$params);
      $m = app::getFilterMenuItemsByTable($m,'ProjectsTypes','Projects Types','timeReport/' . $this->action_name,$params);
      $m = app::getFilterMenuItemsByTable($m,'ProjectsGroups','Projects Groups','timeReport/' . $this->action_name,$params,array(),$this->getUser());
    }
    else
    {
      $m = app::getFilterMenuItemsByTable($m,'TasksGroups','Group','timeReport/index',$params);  
      $m = app::getFilterMenuItemsByTable($m,'ProjectsPhases','Phase','timeReport/index',$params);
      $m = app::getFilterMenuItemsByTable($m,'Versions','Version','timeReport/index',$params);
    }
    
    
    if($this->action_name!='myTimeReport')
    {
      $m = app::getSavedFilters($m,'timeReport/index',$params,'UserReports',Tasks::getReportType($request,'timeReport'),$this->getUser());
      
      $m[] = array('title'=>__('Save Filter'),'url'=>'timeReport/saveFilter' . ($params ? '?' . $params:''),'is_hr'=>true,'modalbox'=>true);  
    }
                    
    $this->m = array(array('title'=>__('Filters'),'submenu'=>$m));
  }
  
  public function executeFiltersPreview(sfWebRequest $request)
  {
    if($this->action_name=='myTimeReport')
    {
      $filter_name = 'my_time_report_filter';
    }
    else
    {
      $filter_name = 'time_report_filter';
    }
  
    $this->filter_by = $this->getUser()->getAttribute($filter_name . ((int)$request->getParameter('projects_id')>0 ? $request->getParameter('projects_id') : ''));
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
      
}