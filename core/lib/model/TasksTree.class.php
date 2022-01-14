<?php

class TasksTree
{
  public static function sortList($list,$parent_id=0)
  {
    $sort_order = 0;
    foreach($list as $v)
    {
      if($task = Doctrine_Core::getTable('Tasks')->find($v['id']))
      {
        $task->setParentId($parent_id);
        $task->setSortOrder($sort_order);
        $task->save();
        
        $sort_order++;
      }
      
      if(isset($v['children']))
      {
        TasksTree::sortList($v['children'],$v['id']);
      }
    }
  }
  
  
  public static function getTasksHtmlTree($tree,$parent_id=0,$html='')
  {
    if($parent_id>0) $html .='<ol class="dd-list">';
    
           
    foreach($tree as $v)
    {
      if($v['parent_id']==$parent_id)
      {
        $html .= '<li class="dd-item" data-id="' . $v['id'] . '"><div class="dd-handle">' . $v['name'] . '</div>';
        $html = TasksTree::getTasksHtmlTree($tree,$v['id'],$html);
        $html .= '</li>';          
      }
    }
    
    if($parent_id>0) $html .='</ol>';
        
    return str_replace('<ol class="dd-list"></ol>','',$html);
  }
  
  public static function getTasksTree($sf_user, $projects_id, $parent_id = 0,$tree = array(),$level = 0,$path = array(),$order=0,$check_parent = array())
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
      
    $q->addWhere('projects_id=?',$projects_id);
    
    if($parent_id>0)
    {
      $q->addWhere('parent_id=?',$parent_id);
    }
    else
    {
      $q->addWhere('parent_id=0 or parent_id is null');
    }
    
    if(Users::hasAccess('view_own','tasks',$sf_user,$projects_id))
    {                 
      $q->addWhere("find_in_set('" . $sf_user->getAttribute('id') . "',t.assigned_to) or t.created_by='" . $sf_user->getAttribute('id') . "'");
    }
    
    $q = Tasks::addFiltersToQuery($q,$sf_user->getAttribute('tasks_filter' . $projects_id));
    
    $q->orderBy('t.sort_order, t.name');
    
    $check_parent[] = $parent_id;
    
    foreach($q->fetchArray() as $tasks)
    {
      $tree[$tasks['id']] = array('id'=>$tasks['id'],
                                  'parent_id'=>$parent_id,
                                  'name'=>$tasks['name'],
                                  'path'=>implode('_',$path), 
                                  'status'=>app::getArrayName($tasks,'TasksStatus'),
                                  'order'=>$order,
                                  'level'=>$level);
                                  
      $order=count($tree);
      
      
      if(!in_array($tasks['id'],$check_parent))                                   
      $tree = TasksTree::getTasksTree($sf_user, $projects_id, $tasks['id'],$tree,$level+1,array_merge($path,array($tasks['id'])),$order,$check_parent);
      
      $order=count($tree); 
    }
    
    return $tree;
  }
  
  public static function getTasksTreeTdPadding($tree,$tasks_id, $collapsed_tasks)
  {
    $html = '';
          
    $parent_id = $tree[$tasks_id]['parent_id'];
    
    if(count(array_filter(explode('_',$tree[$tasks_id]['path'])))>0)
    {
      $html .= '<img src="' . app::public_path('images/icons/tree/empty.gif') . '">';
    }
    
    foreach(array_filter(explode('_',$tree[$tasks_id]['path'])) as $id)
    {              
       if(TasksTree::hasSubTasksByOrder($tree,$id,$tree[$tasks_id]['order']) and ($tree[$tasks_id]['level']-$tree[$id]['level'])>1)
       {
         $html .= '<img src="' . app::public_path('images/icons/tree/line.gif') . '">';   
       }
       elseif(($tree[$tasks_id]['level']-$tree[$id]['level'])>1)
       {
         $html .= '<img src="' . app::public_path('images/icons/tree/empty.gif') . '">';
       }
    }
        
    $rel = (array_search($tasks_id,$collapsed_tasks)!==false ? 'rel="collapsed"':'');    
    
    if($tree[$tasks_id]['parent_id']==0)
    {
     if(TasksTree::hasSubTasks($tree,$tasks_id))
     {
       $html .= '<img src="' . app::public_path('images/icons/tree/minustop.gif') . '" onClick="expandChildTasks(' . $tasks_id . ')" id="folder' . $tasks_id . '" ' . $rel . ' class="tasksTreePlus">';
     }
     else
     {
       $html .= '<img src="' . app::public_path('images/icons/tree/emptytop.gif') . '">';
     }
    }
    else
    {
       if(TasksTree::hasSubTasks($tree,$tasks_id))
       {
         if(TasksTree::hasSubTasksByOrder($tree,$tree[$tasks_id]['parent_id'],$tree[$tasks_id]['order']))
         {
           $html .= '<img src="' . app::public_path('images/icons/tree/minus.gif') . '" onClick="expandChildTasks(' . $tasks_id . ')" id="folder' . $tasks_id . '" ' . $rel . ' class="tasksTreePlus">';
         }
         else
         {
           $html .= '<img src="' . app::public_path('images/icons/tree/minusbottom.gif') . '" onClick="expandChildTasks(' . $tasks_id . ')" id="folder' . $tasks_id . '" ' . $rel . ' class="tasksTreePlus">';
         }
       }
       else
       {
         if(TasksTree::getNextLevelInTasksTree($tree,$tree[$tasks_id]['order'])<$tree[$tasks_id]['level'])
         {
           $html .= '<img src="' . app::public_path('images/icons/tree/joinbottom.gif') . '">'; 
         }
         else
         {
           $html .= '<img src="' . app::public_path('images/icons/tree/join.gif') . '">';
         }
       }
    }
    
    return $html;
  }

  public static function getNextLevelInTasksTree($tree,$order)
  {
    foreach($tree as $v)
    {
      if($v['order']==$order+1)
      {
        return $v['level'];
      }
    }
    
    return false;
  }
  
  public static function hasSubTasksByOrder($tree,$tasks_id,$order)
  {
    foreach($tree as $v)
    {
      if($v['parent_id']==$tasks_id and $v['order']>$order)
      {
        return true;
      }
    }
    
    return false;
  }
  
  public static function hasSubTasks($tree,$tasks_id)
  {
    foreach($tree as $v)
    {
      if($v['parent_id']==$tasks_id)
      {
        return true;
      }
    }
    
    return false;
  }
  
  public static function getTasksTreeIdOrder($tree)
  {
    $ids = array();
  
    foreach($tree as $v)
    {
      $ids[] = $v['id'];
    }
        
    return $ids;
  }
  
  public static function getTasksTreeTrClasses($tree,$id)
  {
    if(isset($tree[$id]))
    {
      $class = array();
      foreach(explode('_',$tree[$id]['path']) as $v)
      {
        $class[] = 'taskRow' . $v;
      }
      
      return 'class="' . implode(' ',$class) . '"';
    }
  }
  
  public static function getChoicesByProjectId($sf_user,$projects_id)
  {    
    $tree = TasksTree::getTasksTree($sf_user, $projects_id);
    
    $choices = array('');      
    foreach($tree as $v)
    {
      $choices[$v['id']] = str_repeat('&nbsp;&nbsp;-&nbsp;',$v['level']) . $v['name'];        
    }
    
    return $choices;    
  }
  
  public static function getBreadcrumb($id,$breadcrump = array(), $check_parent = array())
  {
    if($task = Doctrine_Core::getTable('Tasks')->find($id))
    {
      $check_parent[] = $id;
      
      $breadcrump[] = array('id'=>$task->getId(),'name'=>$task->getName());
      
      if(!in_array($task->getParentId(),$check_parent))
      $breadcrump = TasksTree::getBreadcrumb($task->getParentId(),$breadcrump,$check_parent);
    }
    
    return $breadcrump;
  }      

}