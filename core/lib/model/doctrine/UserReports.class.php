<?php

/**
 * UserReports
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    sf_sandbox
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class UserReports extends BaseUserReports
{
  public static function sendCommonReminder($r)
  {
    $users = Doctrine_Core::getTable('Users')
          ->createQuery('u')->leftJoin('u.UsersGroups ug')
          ->whereIn('ug.id',explode(',',$r['users_groups_id']))->fetchArray(); 
      
    foreach($users as $u)
    {
      //echo $u['id'] . ', ';
      
        $projects_view_own = false;
        $tasks_view_own = false;
        
        if($user = Doctrine_Core::getTable('Users')->find($u['id']))
        {
          $access = $user->getUsersGroups()->getAllowManageProjects();
          $custom_access = explode(',',$user->getUsersGroups()->getProjectsCustomAccess());
          
          if($access=='custom')
          {
            if(in_array('view_own_only',$custom_access))
            {
              $projects_view_own = true;
            }
          }
          else
          {
            switch($access)
            {
              case 'manage_own_lnly':
              case 'view_own_only':
                  $projects_view_own = true;
                break;
            }
          }
          
          $access = $user->getUsersGroups()->getAllowManageTasks();
          $custom_access = explode(',',$user->getUsersGroups()->getTasksCustomAccess());
  
          if($access=='custom')
          {
            if(in_array('view_own_only',$custom_access))
            {
              $tasks_view_own = true;
            }
          }
          else
          {
            switch($access)
            {
              case 'manage_own_lnly':
              case 'view_own_only':
                  $tasks_view_own = true;
                break;
            }
          }
        }
        
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
  
        if($projects_view_own)
        {
          $q->addWhere("find_in_set('" . $u['id'] . "',team) or p.created_by='" . $u['id'] . "'");
        }
  
        if($tasks_view_own)
        {
          $q->addWhere("find_in_set('" . $u['id']. "',t.assigned_to) or t.created_by='" . $u['id'] . "'");
        }
  
        if(count($list = ProjectsRoles::getNotAllowedProjectsByModule('tasks',$u['id']))>0)
        {
          $q->whereNotIn('p.id',$list);
        }
  
        $q = UserReports::addFiltersToQuery($q,$r['id'],$u['id']);
  
        $tasks = $q->orderBy('LTRIM(p.name), ts.status_group desc, ts.sort_order, LTRIM(ts.name), LTRIM(t.name)')->fetchArray();
  
        $html = '';
        $pname = '';
        foreach($tasks as $t)
        {
          if($pname == '')
          {
            $pname = $t['Projects']['name'];
            $html .= '<div><b>' . $pname . '</b></div><ul>';
          }
          elseif($pname != $t['Projects']['name'])
          {
            $pname = $t['Projects']['name'];
            $html .= '</ul><br><div><b>' . $pname . '</b></div><ul>';
          }
          
          $html .= '<li><a href="' . genBatchUrl('tasksComments/index?projects_id=' . $t['projects_id'] . '&tasks_id=' . $t['id']) . '">' . (isset($t['TasksTypes']['name']) ? $t['TasksTypes']['name'] . ': ':'')  . $t['name']  . (isset($t['TasksStatus']['name']) ? ' [' . $t['TasksStatus']['name'] . ']':'') . '</a></li>';
  
        }
        
        $html .= '</ul>';
        
        if(count($tasks)>0)
        {                
          if($user->getCulture())
          {
            sfContext::getInstance()->getI18N()->setCulture($user->getCulture());
          }
                      
          $subject = t::__('Reminder') . ': ' . $r['name'];
          $body = $html;
          $from = array(sfConfig::get('app_administrator_email')=>sfConfig::get('app_app_name'));
          $to = array($user->getEmail()=>$user->getName());
          
          //echo $body;
  
          Users::sendEmail($from, $to, $subject, $body);
        } 
    }     
  }
    
  public static function sendReminder()
  {
    $reports = Doctrine_Core::getTable('UserReports')->createQuery()->addWhere('length(report_reminder)>0')->fetchArray();
    
    foreach($reports as $r)
    {
      if(!in_array(date('w'),explode(',',$r['report_reminder']))) continue;
      
      
        
      if(strlen($r['users_groups_id'])>0)
      {        
        UserReports::sendCommonReminder($r);
      }
      else
      {
          
        $projects_view_own = false;
        $tasks_view_own = false;
        
        if($user = Doctrine_Core::getTable('Users')->find($r['users_id']))
        {
          $access = $user->getUsersGroups()->getAllowManageProjects();
          $custom_access = explode(',',$user->getUsersGroups()->getProjectsCustomAccess());
          
          if($access=='custom')
          {
            if(in_array('view_own_only',$custom_access))
            {
              $projects_view_own = true;
            }
          }
          else
          {
            switch($access)
            {
              case 'manage_own_lnly':
              case 'view_own_only':
                  $projects_view_own = true;
                break;
            }
          }
          
          $access = $user->getUsersGroups()->getAllowManageTasks();
          $custom_access = explode(',',$user->getUsersGroups()->getTasksCustomAccess());
  
          if($access=='custom')
          {
            if(in_array('view_own_only',$custom_access))
            {
              $tasks_view_own = true;
            }
          }
          else
          {
            switch($access)
            {
              case 'manage_own_lnly':
              case 'view_own_only':
                  $tasks_view_own = true;
                break;
            }
          }
        }
        
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
  
        if($projects_view_own)
        {
          $q->addWhere("find_in_set('" . $r['users_id'] . "',team) or p.created_by='" . $r['users_id'] . "'");
        }
  
        if($tasks_view_own)
        {
          $q->addWhere("find_in_set('" . $r['users_id']. "',t.assigned_to) or t.created_by='" . $r['users_id'] . "'");
        }
  
        if(count($list = ProjectsRoles::getNotAllowedProjectsByModule('tasks',$r['users_id']))>0)
        {
          $q->whereNotIn('p.id',$list);
        }
  
        $q = UserReports::addFiltersToQuery($q,$r['id'],$r['users_id']);
  
        $tasks = $q->orderBy('LTRIM(p.name), ts.status_group desc, ts.sort_order, LTRIM(ts.name), LTRIM(t.name)')->fetchArray();
  
        $html = '';
        $pname = '';
        foreach($tasks as $t)
        {
          if($pname == '')
          {
            $pname = $t['Projects']['name'];
            $html .= '<div><b>' . $pname . '</b></div><ul>';
          }
          elseif($pname != $t['Projects']['name'])
          {
            $pname = $t['Projects']['name'];
            $html .= '</ul><br><div><b>' . $pname . '</b></div><ul>';
          }
          
          $html .= '<li><a href="' . genBatchUrl('tasksComments/index?projects_id=' . $t['projects_id'] . '&tasks_id=' . $t['id']) . '">' . (isset($t['TasksTypes']['name']) ? $t['TasksTypes']['name'] . ': ':'')  . $t['name']  . (isset($t['TasksStatus']['name']) ? ' [' . $t['TasksStatus']['name'] . ']':'') . '</a></li>';
  
        }
        
        $html .= '</ul>';
        
        if(count($tasks)>0)
        {                
          if($user->getCulture())
          {
            sfContext::getInstance()->getI18N()->setCulture($user->getCulture());
          }
                      
          $subject = t::__('Reminder') . ': ' . $r['name'];
          $body = $html;
          $from = array(sfConfig::get('app_administrator_email')=>sfConfig::get('app_app_name'));
          $to = array($user->getEmail()=>$user->getName());
  
          Users::sendEmail($from, $to, $subject, $body);
        }
      
      }
    
    }

  }
  
  
  public static function getListingOrderChoices()
  {
    $choices = array();
    $choices['projects'] = t::__('Projects');
    $choices['date_added'] = t::__('Date Added');
    $choices['date_last_commented'] = t::__('Date Last Commented');
    $choices['due_date'] = t::__('Due Date');
    $choices['name'] = t::__('Name');
    if(app::countItemsByTable('TasksPriority')>0) $choices['priority'] = t::__('Priority');
    if(app::countItemsByTable('TasksStatus')>0)   $choices['status'] = t::__('Status');
    if(app::countItemsByTable('TasksTypes')>0)    $choices['type'] = t::__('Type');
    if(app::countItemsByTable('TasksGroups')>0)   $choices['group'] = t::__('Group');
    
    return $choices;
  }
    
  public static function addFiltersToQuery($q,$reports_id,$users_id=false)
  {
    if($r = Doctrine_Core::getTable('UserReports')->find($reports_id))
    { 
      if($r->getDisplayOnlyAssigned()==1)
      {
        $q->addWhere("find_in_set('" . $users_id . "',t.assigned_to) or t.created_by='" . $users_id . "'");
      }
      
      if(strlen($r->getTasksPriorityId())>0)
      {
        $q->whereIn('t.tasks_priority_id',explode(',',$r->getTasksPriorityId()));
      }
      
      if(strlen($r->getTasksStatusId())>0)
      {
        $q->whereIn('t.tasks_status_id',explode(',',$r->getTasksStatusId()));
      }
       
      if(strlen($r->getTasksTypeId())>0)
      {
        $q->whereIn('t.tasks_type_id',explode(',',$r->getTasksTypeId()));
      }
        
      if(strlen($r->getTasksLabelId())>0)
      {
        $q->whereIn('t.tasks_label_id',explode(',',$r->getTasksLabelId()));
      }
      
      if($r->getHasRelatedTicket()==1)
      {
        $sql = '(SELECT COUNT(*) FROM TasksToTickets ttt WHERE  ttt.tasks_id=t.id)>0';
                                                      
        $q->addWhere($sql);
      }
      
      if($r->getHasEstimatedTime()==1)
      {
        $q->addWhere('t.estimated_time>0');
      }
      
      if($r->getOverdueTasks()==1)
      {
        $q->addWhere('t.due_date<=date_format(now(),"%Y-%m-%d")');
      }
      
      if((int)$r->getDaysBeforeDueDate()>0)
      {
        $q->addWhere('t.due_date=date_add(date_format(now(),"%Y-%m-%d"),INTERVAL ' . (int)$r->getDaysBeforeDueDate() . ' DAY)');
      }
      
      
      if(strlen($r->getDueDateFrom())>0)
      {
        $q->addWhere('date_format(t.due_date,"%Y-%m-%d")>="' . $r->getDueDateFrom() . '"');
      }      
      if(strlen($r->getDueDateTo())>0)
      {
        $q->addWhere('date_format(t.due_date,"%Y-%m-%d")<="' . $r->getDueDateTo() . '"');
      }
                  
      if(strlen($r->getCreatedFrom())>0)
      {
        $q->addWhere('date_format(t.created_at,"%Y-%m-%d")>="' . $r->getCreatedFrom() . '"');
      }      
      if(strlen($r->getCreatedTo())>0)
      {
        $q->addWhere('date_format(t.created_at,"%Y-%m-%d")<="' . $r->getCreatedTo() . '"');
      }
      
      if(strlen($r->getClosedFrom())>0)
      {
        $q->addWhere('date_format(t.closed_date,"%Y-%m-%d")>="' . $r->getClosedFrom() . '"');
      }    
      if(strlen($r->getClosedTo())>0)
      {
        $q->addWhere('date_format(t.closed_date,"%Y-%m-%d")<="' . $r->getClosedTo() . '"');
      }
      
      
      if(strlen($r->getExtraFields())>0)
      {            
        $extra_fields = unserialize($r->getExtraFields());                        
        $count_e = 0;
                                
        foreach($extra_fields as $efId=>$values)
        {
          $filter_sql_array = array();
          foreach($values as $id)
          {
            $filter_sql_array[] = 'find_in_set("' . $id . '",REPLACE(e' . ($count_e>0?$count_e:''). '.value,"\n",","))';
          }
                  
          $sql = '(SELECT COUNT(*) FROM ExtraFieldsList efl' . $efId . ' WHERE  (' . implode(' OR ',$filter_sql_array) . ') AND efl' . $efId . '.bind_id=t.id AND efl' . $efId . '.extra_fields_id="' . $efId . '")>0';
                                                      
          $q->addWhere($sql);
          
          if($count_e==0)
          {
            $count_e=2;
          }
          else
          {
            $count_e++;
          }
        }
      }
      
      if(strlen($r->getAssignedTo())>0)
      {        
        $filter_sql_array = array();
        foreach(explode(',',$r->getAssignedTo()) as $id)
        {
          $filter_sql_array[] = 'find_in_set(' . $id . ',t.assigned_to)';
        }
        
        $q->addWhere(implode(' or ',$filter_sql_array));
      } 
      
      if(strlen($r->getCreatedBy())>0)
      {
        $q->whereIn('t.created_by',explode(',',$r->getCreatedBy()));
      }
       
         
      if(strlen($r->getProjectsPriorityId())>0)
      {
        $q->whereIn('p.projects_priority_id',explode(',',$r->getProjectsPriorityId()));
      }
      
      if(strlen($r->getProjectsStatusId())>0)
      {
        $q->whereIn('p.projects_status_id',explode(',',$r->getProjectsStatusId()));
      }
       
      if(strlen($r->getProjectsTypeId())>0)
      {
        $q->whereIn('p.projects_types_id',explode(',',$r->getProjectsTypeId()));
      }
        
      if(strlen($r->getProjectsGroupsId())>0)
      {
        $q->whereIn('p.projects_groups_id',explode(',',$r->getProjectsGroupsId()));
      }
                
      if(strlen($r->getProjectsId())>0)
      {
        $q->whereIn('p.id',explode(',',$r->getProjectsId()));
      }
      
      $q = Tasks::getListingOrderByType($q,$r->getListingOrder());
                                    
    }
                  
    return $q;  
  }
}