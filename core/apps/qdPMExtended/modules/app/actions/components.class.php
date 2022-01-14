<?php

class appComponents extends sfComponents
{
  public function executeCopyToRelated(sfWebRequest $request)
  {
    $this->is_related = false;
    
    if($request->hasParameter('related_tasks_id') or $request->hasParameter('related_tickets_id') or $request->hasParameter('related_discussions_id'))
    {
      $this->is_related = true;          
    }  
    
    switch(true)
    {
      case $request->hasParameter('related_tasks_id'): $this->title='Copy from task';
        break;
      case $request->hasParameter('related_tickets_id'): $this->title='Copy from ticket';
        break;
      case $request->hasParameter('related_discussions_id'): $this->title='Copy from discussion';
        break;
    }      
  }

  public function executeSearchMenu()
  {
  
  }
  
  public function executeSearchMenuSimple()
  {
  
  }
  
  public function executeOrderByMenu(sfWebRequest $request)
  {
    $params = ($request->hasParameter('projects_id')?'&projects_id=' . $request->getParameter('projects_id'):'');
  
    $m = array();
    
    if(!$request->hasParameter('projects_id'))
    {
      $m[] = array('title'=>__('Projects'),'url'=>$this->module . '/index?set_order=projects' . $params);
    }
    
    $m[] = array('title'=>__('Date Added'),'url'=>$this->module . '/index?set_order=date_added' . $params);    
    switch($this->module)
    {
      case 'projects':
          if(Users::hasAccess('view','projectsComments',$this->getUser(),$request->getParameter('projects_id'))) $m[] = array('title'=>__('Date Last Commented'),'url'=>$this->module . '/index?set_order=date_last_commented');
          $m[] = array('title'=>__('Name'),'is_hr'=>true,'url'=>$this->module . '/index?set_order=name');
          if(app::countItemsByTable('ProjectsPriority')>0) $m[] = array('title'=>__('Priority'),'url'=>$this->module . '/index?set_order=priority');
          if(app::countItemsByTable('ProjectsStatus')>0)   $m[] = array('title'=>__('Status'),'url'=>$this->module . '/index?set_order=status');
          if(app::countItemsByTable('ProjectsTypes')>0)    $m[] = array('title'=>__('Type'),'url'=>$this->module . '/index?set_order=type');
          if(app::countItemsByTable('ProjectsGroups')>0)   $m[] = array('title'=>__('Group'),'url'=>$this->module . '/index?set_order=group');
        break;
      case 'tasks':
          if(Users::hasAccess('view','tasksComments',$this->getUser(),$request->getParameter('projects_id'))) $m[] = array('title'=>__('Date Last Commented'),'url'=>$this->module . '/index?set_order=date_last_commented' . $params);
          $m[] = array('title'=>__('Due Date'),'url'=>$this->module . '/index?set_order=due_date' . $params);
          $m[] = array('title'=>__('Name'),'is_hr'=>true,'url'=>$this->module . '/index?set_order=name' . $params);
          if(app::countItemsByTable('TasksPriority')>0) $m[] = array('title'=>__('Priority'),'url'=>$this->module . '/index?set_order=priority' . $params);
          if(app::countItemsByTable('TasksStatus')>0)   $m[] = array('title'=>__('Status'),'url'=>$this->module . '/index?set_order=status' . $params);
          if(app::countItemsByTable('TasksTypes')>0)    $m[] = array('title'=>__('Type'),'url'=>$this->module . '/index?set_order=type' . $params);
          if(app::countItemsByTable('TasksLabels')>0)   $m[] = array('title'=>__('Label'),'url'=>$this->module . '/index?set_order=label' . $params);
        break;
      case 'tickets':
          if(Users::hasAccess('view','ticketsComments',$this->getUser(),$request->getParameter('projects_id'))) $m[] = array('title'=>__('Date Last Commented'),'url'=>$this->module . '/index?set_order=date_last_commented' . $params);
          $m[] = array('title'=>__('Name'),'is_hr'=>true,'url'=>$this->module . '/index?set_order=name' . $params);
          if(app::countItemsByTable('TicketsPriority')>0) $m[] = array('title'=>__('Priority'),'url'=>$this->module . '/index?set_order=priority' . $params);
          if(app::countItemsByTable('TicketsStatus')>0)   $m[] = array('title'=>__('Status'),'url'=>$this->module . '/index?set_order=status' . $params);
          if(app::countItemsByTable('TicketsTypes')>0)    $m[] = array('title'=>__('Type'),'url'=>$this->module . '/index?set_order=type' . $params);
          if(app::countItemsByTable('TicketsGroups')>0)   $m[] = array('title'=>__('Group'),'url'=>$this->module . '/index?set_order=group' . $params);
          if(app::countItemsByTable('Departments')>0)   $m[] = array('title'=>__('Department'),'url'=>$this->module . '/index?set_order=department' . $params);
        break;
      case 'discussions':
          if(Users::hasAccess('view','discussionsComments',$this->getUser(),$request->getParameter('projects_id'))) $m[] = array('title'=>__('Date Last Commented'),'url'=>$this->module . '/index?set_order=date_last_commented' . $params);
          $m[] = array('title'=>__('Name'),'is_hr'=>true,'url'=>$this->module . '/index?set_order=name' . $params);
          if(app::countItemsByTable('DiscussionsPriority')>0) $m[] = array('title'=>__('Priority'),'url'=>$this->module . '/index?set_order=priority' . $params);
          if(app::countItemsByTable('DiscussionsStatus')>0)   $m[] = array('title'=>__('Status'),'url'=>$this->module . '/index?set_order=status' . $params);
          if(app::countItemsByTable('DiscussionsTypes')>0)    $m[] = array('title'=>__('Type'),'url'=>$this->module . '/index?set_order=type' . $params);
          if(app::countItemsByTable('DiscussionsGroups')>0)   $m[] = array('title'=>__('Group'),'url'=>$this->module . '/index?set_order=group' . $params);          
        break;
    }
    
    $this->m = array(array('title'=>__('Order By'),'submenu'=>$m));
  }
  
  public function executeExtraFieldsInSearch(sfWebRequest $request)
  {
    $this->extr_fields = $q = Doctrine_Core::getTable('ExtraFields')->createQuery()
                              ->addWhere('bind_type=?',$this->type)
                              ->whereIn('type',array('text','textarea','textarea_wysiwyg'))
                              ->orderBy('sort_order,name')
                              ->execute();  
  }
}