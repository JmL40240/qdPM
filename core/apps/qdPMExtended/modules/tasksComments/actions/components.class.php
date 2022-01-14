<?php

class tasksCommentsComponents extends sfComponents
{
  public function executeBreadcrump(sfWebRequest $request)
  {
    if($this->tasks->getParentId()>0)
    {
      $this->breadcrump = TasksTree::getBreadcrumb($this->tasks->getId());
    }
    else
    {
      $this->breadcrump = array();
    }
    
    $this->breadcrump = array_reverse($this->breadcrump);
  }
  
  public function executeInfo(sfWebRequest $request)
  {
  
  }
  
  public function executeEmailBody()
  {    
    $this->comments_history = Doctrine_Core::getTable('TasksComments')
      ->createQuery()
      ->addWhere('tasks_id=?',$this->tasks->getId())
      ->addWhere('in_trash is null')
      ->orderBy('created_at desc')
      ->limit((int)sfConfig::get('app_amount_previous_comments',2)+1)
      ->execute();  
  }
  
  public function executeGoto(sfWebRequest $request)
  {
    
    if($this->projects->getTasksView()=='tree')
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
        
        if(strlen($id_order = implode(',',TasksTree::getTasksTreeIdOrder($this->tasks_tree)))>0)
        {
          $q->orderBy('FIELD(id,' .  $id_order . ')');
        }        
        
        $this->menu = array();   
        $tasks_ids = array();                               
        foreach($q->fetchArray() as $tasks)
        {
          $level = $this->tasks_tree[$tasks['id']]['level'];
          
          if(strlen($sn=app::getArrayName($tasks,'TasksStatus'))>0){ $sn = ' (' . $sn . ')';}else{ $sn ='';}
          
          if($request->getParameter('tasks_id')==$tasks['id']) $tasks['name'] = '<b>' . $tasks['name'] . '</b>'; 
          
          $this->menu[] = array('title'=>($level>0 ? str_repeat('&nbsp;&nbsp; - ',$level):'') . $tasks['name'] . $sn,'url'=>'tasksComments/index?projects_id=' . $request->getParameter('projects_id') . '&tasks_id=' . $tasks['id']);
          
          $tasks_ids[] = $tasks['id'];                               
        }          
    }
    else
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
              
        $q->addWhere('projects_id=?',$request->getParameter('projects_id'));
        
        if(Users::hasAccess('view_own','tasks',$this->getUser(),$request->getParameter('projects_id')))
        {                 
          $q->addWhere("find_in_set('" . $this->getUser()->getAttribute('id') . "',t.assigned_to) or t.created_by='" . $this->getUser()->getAttribute('id') . "'");
        }
                                      
        $q = Tasks::addFiltersToQuery($q,$this->getUser()->getAttribute('tasks_filter' . ((int)$request->getParameter('projects_id')>0 ? $request->getParameter('projects_id') : '')));                  
        
        $q = app::addListingOrder($q,'tasks',$this->getUser()->getAttribute('id'), (int)$request->getParameter('projects_id'));
        
        $this->menu = array();   
        $tasks_ids = array();                               
        foreach($q->fetchArray() as $tasks)
        {
                    
          if(strlen($sn=app::getArrayName($tasks,'TasksStatus'))>0){ $sn = $sn . ': ';}else{ $sn ='';}
          
          if($request->getParameter('tasks_id')==$tasks['id']) $tasks['name'] = '<b>' . $tasks['name'] . '</b>'; 
          
          $this->menu[] = array('title'=>$sn . $tasks['name'],'url'=>'tasksComments/index?projects_id=' . $request->getParameter('projects_id') . '&tasks_id=' . $tasks['id']);
          
          $tasks_ids[] = $tasks['id'];                               
        }  
    }
    
    
    $current_key = array_search($request->getParameter('tasks_id'),$tasks_ids);
    $this->previous_tasks_id = false;
    $this->next_tasks_id = false;
    if(isset($tasks_ids[$current_key-1])) $this->previous_tasks_id = $tasks_ids[$current_key-1];
    if(isset($tasks_ids[$current_key+1])) $this->next_tasks_id = $tasks_ids[$current_key+1];
  
    
  }
  
  public function executeTasksTimer(sfWebRequest $request)
  {
    $this->timer = Doctrine_Core::getTable('TasksTimer')->createQuery('')
                    ->addWhere('users_id=?',$this->getUser()->getAttribute('id'))
                    ->addWhere('tasks_id=?',$this->tasks->getId())
                    ->fetchOne();
                    
    
    $this->display_timer = false;
    
    if($this->timer)
    {
      if($this->timer->getVisible()==1)
      {
        $this->display_timer = true;
      }
    }                
    
  }
}