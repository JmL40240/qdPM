<?php

class ganttChartComponents extends sfComponents
{

  
  public function executeFilters(sfWebRequest $request)
  {  
    $m = array();
    
    $params = ((int)$request->getParameter('projects_id')>0 ? 'projects_id=' . $request->getParameter('projects_id') : false);
            
    $m = app::getFilterMenuItemsByTable($m,'TasksPriority','Priority','ganttChart/index',$params);
    $m = app::getFilterMenuStatusItemsByTable($m,'TasksStatus','Status','ganttChart/index',$params);
    $m = app::getFilterMenuItemsByTable($m,'TasksLabels','Label','ganttChart/index',$params);
    $m = app::getFilterMenuItemsByTable($m,'TasksTypes','Type','ganttChart/index',$params);  
    $m = app::getFilterMenuUsers($m,'TasksAssignedTo', 'Assigned To','ganttChart/index',$params);
    $m = app::getFilterMenuUsers($m,'TasksCreatedBy','Created By','ganttChart/index',$params);
    $m = app::getFilterExtraFields($m,false,'tasks','ganttChart/index',$params,array(),$this->getUser());
    
    if(!$params)
    {
      $m = app::getFilterProjects($m,'ganttChart/index',$params,array(),$this->getUser());
      $m = app::getFilterMenuItemsByTable($m,'ProjectsPriority','Project Priority','ganttChart/index',$params);
      $m = app::getFilterMenuStatusItemsByTable($m,'ProjectsStatus','Project Status','ganttChart/index',$params);
      $m = app::getFilterMenuItemsByTable($m,'ProjectsTypes','Project Type','ganttChart/index',$params);
      $m = app::getFilterMenuItemsByTable($m,'ProjectsGroups','Project Group','ganttChart/index',$params,array(),$this->getUser());
    }
    else
    {
      $m = app::getFilterMenuItemsByTable($m,'TasksGroups','Group','ganttChart/index',$params);  
      $m = app::getFilterMenuItemsByTable($m,'ProjectsPhases','Phase','ganttChart/index',$params);
      $m = app::getFilterMenuItemsByTable($m,'Versions','Version','ganttChart/index',$params);
    }
    
    $m = app::getSavedFilters($m,'ganttChart/index',$params,'UserReports',Tasks::getReportType($request,'ganttChart'),$this->getUser());
    
    $m[] = array('title'=>__('Save Filter'),'url'=>'ganttChart/saveFilter' . ($params ? '?' . $params:''),'is_hr'=>true,'modalbox'=>true);
                    
    $this->m = array(array('title'=>__('Filters'),'submenu'=>$m));
  }
  
  public function executeFiltersPreview(sfWebRequest $request)
  {
    $this->filter_by = $this->getUser()->getAttribute('gantt_filter' . ((int)$request->getParameter('projects_id')>0 ? $request->getParameter('projects_id') : ''));
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