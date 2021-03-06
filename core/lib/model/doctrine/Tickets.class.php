<?php

/**
 * Tickets
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    sf_sandbox
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Tickets extends BaseTickets
{
  public static function hasViewOwnAccess($sf_user,$tickets,$project=false)
  {
    if($project)
    {
      $has_access =Users::hasAccess('view_own','tickets',$sf_user,$project->getId());
    }
    else
    {
      $has_access =Users::hasAccess('view_own','tickets',$sf_user);
    }
     
    if($has_access)
    {      
      if(!in_array($tickets->getDepartmentsId(),Departments::getDepartmentIdByUserId($sf_user->getAttribute('id'))) and $tickets->getUsersId()!=$sf_user->getAttribute('id'))
      {
        return false;
      }
      else
      {
        return true;
      }
    }
    else
    {
      return true;
    }
  }
  
  public static function checkViewOwnAccess($c,$sf_user,$tickets,$project=false)
  {
    if($project)
    {
      $has_access =Users::hasAccess('view_own','tickets',$sf_user,$project->getId());
    }
    else
    {
      $has_access =Users::hasAccess('view_own','tickets',$sf_user);
    }
     
    if($has_access)
    {      
      if(!in_array($tickets->getDepartmentsId(),Departments::getDepartmentIdByUserId($sf_user->getAttribute('id'))) and $tickets->getUsersId()!=$sf_user->getAttribute('id'))
      {
        $c->redirect('accessForbidden/index');
      }
    }
  }
    
  
  public static function sendNotification($c,$tickets,$send_to,$sf_user, $extra_notification = array())
  {
    if(count($send_to)==0) return false;
    
    foreach($send_to as $type=>$users)
    {
      switch($type)
      {
        case 'status': $subject = t::__('Tickets Status Updated');
          break;
        default: $subject = t::__('New Ticket');
          break;
      }
      
      $to = array();
                  
      foreach($users as $v)
      {
        if($u = Doctrine_Core::getTable('Users')->find($v))
        {
          $to[$u->getEmail()]=$u->getName();
        }
      } 
      
      foreach($extra_notification as $v)
      {
        if($u = Doctrine_Core::getTable('Users')->find($v))
        {
          $to[$u->getEmail()]=$u->getName();
        }
      }
          
      $user = $sf_user->getAttribute('user');
      
      $from[$user->getEmail()] = $user->getName();            
      $to[$user->getEmail()] = $user->getName();
      
      //$to[$tickets->getUsers()->getEmail()] = $tickets->getUsers()->getName();
      
      if(sfConfig::get('app_send_email_to_owner')=='off')
      {
        unset($to[$user->getEmail()]);             
      }
       
      $subject .= ': ' . $tickets->getProjects()->getName() . ' - '  .  $tickets->getName() . ($tickets->getTicketsStatusId()>0 ? ' [' . $tickets->getTicketsStatus()->getName() . ']':'');
      $body  = $c->getComponent('tickets','emailBody',array('tickets'=>$tickets));
                  
      Users::sendEmail($from,$to,$subject,$body,$sf_user);
    }                
  }
    
  public static function addFiltersToQuery($q,$filters)
  {    
    $count_e = 0;
    
    foreach($filters as $table=>$fstr)
    {
      $ids = explode(',',$fstr);
      
      switch($table)
      {
        case 'TicketsPriority':
            $q->whereIn('t.tickets_priority_id',$ids);
          break;
        case 'TicketsStatus':
            $q->whereIn('t.tickets_status_id',$ids);
          break;
        case 'TicketsTypes':
            $q->whereIn('t.tickets_types_id',$ids);
          break;
        case 'TicketsGroups':
            $q->whereIn('t.tickets_groups_id',$ids);
          break;  
        case 'Departments':
            $q->whereIn('t.departments_id',$ids);
          break;

        case 'TicketsCreatedBy':
            $filter_sql_array = array();
            foreach($ids as $id)
            {
              $filter_sql_array[] = 'find_in_set(' . $id . ',t.users_id)';
            }
            
            $q->addWhere(implode(' or ',$filter_sql_array));
          break; 
          
        case 'Projects':
            $q->whereIn('t.projects_id',$ids);
          break; 
        case 'ProjectsPriority':
            $q->whereIn('p.projects_priority_id',$ids);
          break;
        case 'ProjectsStatus':
            $q->whereIn('p.projects_status_id',$ids);
          break;
        case 'ProjectsTypes':
            $q->whereIn('p.projects_types_id',$ids);
          break;
        case 'ProjectsGroups':
            $q->whereIn('p.projects_groups_id',$ids);
          break;
        
      }
      
      if(strstr($table,'extraField'))
      {
        $efId = str_replace('extraField','',$table);
        
        $filter_sql_array = array();
        foreach($ids as $id)
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
          
    return $q;  
  }
  
  public static function getReportType($request)
  {
    if((int)$request->getParameter('projects_id')>0)
    {
      return 'filter' . $request->getParameter('projects_id');
    }
    else
    {
      return 'filter';
    }
  }
  
  public static function saveTicketsFilter($request, $filters,$sf_user)
  {  
    $report_type = Tickets::getReportType($request);
    
    if($request->getParameter('update_user_filter')>0)
    {            
      $r = Doctrine_Core::getTable('TicketsReports')->createQuery()
            ->addWhere('id=?',$request->getParameter('update_user_filter'))
            ->addWhere('users_id=?',$sf_user->getAttribute('id'))
            ->addWhere('report_type=?',$report_type)
            ->fetchOne();
            
      if($r)
      {
        $r->setName($request->getParameter('name'));  
        $r->setIsDefault($request->getParameter('is_default'));
      }
      else
      {
        return false;
      }
    }
    else
    {    
      $r = new TicketsReports();
      $r->setName($request->getParameter('name'));
      $r->setUsersId($sf_user->getAttribute('id'));
      $r->setReportType($report_type);
      $r->setIsDefault($request->getParameter('is_default'));
    }
    
    if(!$request->hasParameter('update_user_filter') or ($request->hasParameter('update_user_filter') and $request->hasParameter('update_values')))
    {
      foreach($filters as $table=>$fstr)
      {            
        switch($table)
        {
          case 'TicketsPriority':
              $r->setTicketsPriorityId($fstr);            
            break;
          case 'TicketsStatus':
              $r->setTicketsStatusId($fstr);            
            break;
          case 'TicketsTypes':
              $r->setTicketsTypeId($fstr);            
            break;
          case 'TicketsGroups':
              $r->setTicketsGroupsId($fstr);            
            break;                              
          case 'TicketsCreatedBy':
              $r->setCreatedBy($fstr);            
            break; 
         case 'Departments':
              $r->setDepartmentsId($fstr);            
            break;     
        
        
          case 'Projects':
              $r->setProjectsId($fstr);            
            break;
          case 'ProjectsPriority':
              $r->setProjectsPriorityId($fstr);            
            break;
          case 'ProjectsStatus':
              $r->setProjectsStatusId($fstr);            
            break;
          case 'ProjectsTypes':
              $r->setProjectsTypeId($fstr);            
            break;
          case 'ProjectsGroups':
              $r->setProjectsGroupsId($fstr);            
            break;

        }
      }
    }
          
    $r->save();
    
    if($r->getIsDefault()==1)
    {
      Doctrine_Query::create()
      ->update('TicketsReports')
      ->set('is_default', 0)
      ->addWhere('id != ?', $r->getId())
      ->addWhere('report_type=?',$report_type)
      ->execute();
    }  
  }
  
  public static function useTicketsFilter($request,$sf_user)
  {
    $id = $request->getParameter('user_filter');
    
    $report_type = Tickets::getReportType($request);
    
    $f = array();
    
    $r = Doctrine_Core::getTable('TicketsReports')
                ->createQuery()
                ->addWhere('id=?',$id)
                ->addWhere('report_type=?',$report_type)
                ->addWhere('users_id=?',$sf_user->getAttribute('id'))
                ->fetchOne();
    
    if(strlen($r->getTicketsPriorityId())>0)
    {
      $f['TicketsPriority'] = $r->getTicketsPriorityId(); 
    }
    
    if(strlen($r->getTicketsStatusId())>0)
    {
      $f['TicketsStatus'] = $r->getTicketsStatusId(); 
    }
                
    if(strlen($r->getTicketsTypesId())>0)
    {
      $f['TicketsTypes'] = $r->getTicketsTypseId(); 
    }
      
    if(strlen($r->getTicketsGroupsId())>0)
    {
      $f['TicketsGroups'] = $r->getTicketsGroupsId(); 
    }
        
    if(strlen($r->getCreatedBy())>0)
    {
      $f['TicketsCreatedBy'] = $r->getCreatedBy(); 
    }
    
    if(strlen($r->getDepartmentsId())>0)
    {
      $f['Departments'] = $r->getDepartmentsId(); 
    }
    
    if(strlen($r->getProjectsId())>0)
    {
      $f['Projects'] = $r->getProjectsId(); 
    }
    
    if(strlen($r->getProjectsPriorityId())>0)
    {
      $f['ProjectsPriority'] = $r->getProjectsPriorityId(); 
    }
    
    if(strlen($r->getProjectsStatusId())>0)
    {
      $f['ProjectsStatus'] = $r->getProjectsStatusId(); 
    }
                
    if(strlen($r->getProjectsTypeId())>0)
    {
      $f['ProjectsTypes'] = $r->getProjectsTypeId(); 
    }
    
    if(strlen($r->getProjectsGroupsId())>0)
    {
      $f['ProjectsGroups'] = $r->getProjectsGroupsId(); 
    }
    
    return $f;
  }
  
  public static function getDefaultFilter($request,$sf_user)
  {
    if((int)$request->getParameter('projects_id')>0)
    {
      $report_type = 'filter' . $request->getParameter('projects_id');
    }
    else
    {
      $report_type = 'filter';
    }
    
    $r = Doctrine_Core::getTable('TicketsReports')
                ->createQuery()
                ->addWhere('is_default=?',1)
                ->addWhere('report_type=?',$report_type)
                ->addWhere('users_id=?',$sf_user->getAttribute('id'))
                ->fetchOne();
    if($r)
    {
      $request->setParameter('user_filter',$r->getId());
      return Tickets::useTicketsFilter($request,$sf_user);
    }
    else
    {
      $f = array();
      
      if(count($s=app::getStatusByGroup('open','TicketsStatus'))>0)
      {
        $f['TicketsStatus'] = implode(',',$s);
      }
                  
      return $f;
    }
  }
  
  public static function  getListingOrderByType($q,$type)
  {
   switch($type)
   {
     case 'projects':             $q->orderBy('LTRIM(p.name), ts.status_group desc, ts.sort_order, LTRIM(ts.name),  LTRIM(t.name)');
       break;
     case 'date_added':           $q->orderBy('t.created_at desc');
       break;
     case 'date_last_commented':  $q->orderBy('t.last_comment_date desc');
       break;
     case 'name':                 $q->orderBy('LTRIM(t.name)');
       break;
     case 'priority':             $q->orderBy('tp.sort_order, LTRIM(tp.name), LTRIM(p.name), LTRIM(t.name)');
       break;                                  
     case 'status':               $q->orderBy('ts.status_group desc, ts.sort_order, LTRIM(ts.name), LTRIM(p.name),  LTRIM(t.name)');
       break;
     case 'type':                 $q->orderBy('tt.sort_order, LTRIM(tt.name), LTRIM(p.name),  LTRIM(t.name)');
       break;
     case 'group':                $q->orderBy('tg.sort_order, LTRIM(tg.name), LTRIM(p.name),  LTRIM(t.name)');
       break; 
     case 'department':           $q->orderBy('td.sort_order, LTRIM(td.name), LTRIM(p.name),  LTRIM(t.name)');
       break;
     default:                     $q->orderBy('ts.status_group desc, ts.sort_order, LTRIM(ts.name), LTRIM(p.name),  LTRIM(t.name)');
      break;             
   }
   
   return $q;
  }
  
}