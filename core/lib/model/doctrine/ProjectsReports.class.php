<?php

/**
 * ProjectsReports
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    sf_sandbox
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class ProjectsReports extends BaseProjectsReports
{
  public static function getListingOrderChoices()
  {
    $choices = array();
    $choices['date_added'] = t::__('Date Added');
    $choices['date_last_commented'] = t::__('Date Last Commented');
    $choices['name'] = t::__('Name');
    if(app::countItemsByTable('ProjectsPriority')>0) $choices['priority'] = t::__('Priority');
    if(app::countItemsByTable('ProjectsStatus')>0)   $choices['status'] = t::__('Status');
    if(app::countItemsByTable('ProjectsTypes')>0)    $choices['type'] = t::__('Type');
    if(app::countItemsByTable('ProjectsGroups')>0)   $choices['group'] = t::__('Group');
    
    return $choices;
  }
    
  public static function addFiltersToQuery($q,$reports_id,$sf_user=false)
  {
    if($r = Doctrine_Core::getTable('ProjectsReports')->find($reports_id))
    { 
      if($r->getDisplayOnlyAssigned()==1)
      {
        $q->addWhere("find_in_set('" . $sf_user->getAttribute('id') . "',p.team) or p.created_by='" . $sf_user->getAttribute('id') . "'");
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
                  
          $sql = '(SELECT COUNT(*) FROM ExtraFieldsList efl' . $efId . ' WHERE  (' . implode(' OR ',$filter_sql_array) . ') AND efl' . $efId . '.bind_id=p.id AND efl' . $efId . '.extra_fields_id="' . $efId . '")>0';
                                                      
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
      
      if(strlen($r->getProjectsId())>0)
      {
        $q->whereIn('p.id',explode(',',$r->getProjectsId()));
      }
      
      if(strlen($r->getInTeam())>0)
      {        
        $filter_sql_array = array();
        foreach(explode(',',$r->getInTeam()) as $id)
        {
          $filter_sql_array[] = 'find_in_set(' . $id . ',p.team)';
        }
        
        $q->addWhere(implode(' or ',$filter_sql_array));
      }   
            
      switch($r->getListingOrder())
      {
        case 'date_added':           $q->orderBy('p.created_at desc');
          break;
        case 'date_last_commented':  $q->orderBy('p.last_comment_date desc');
          break;
        case 'name':                 $q->orderBy('p.name');
          break;
        case 'priority':             $q->orderBy('pp.sort_order,p.projects_priority_id, p.name');
          break;
        case 'status':               $q->orderBy('ps.status_group desc, ps.sort_order,p.projects_status_id, p.name');
          break;
        case 'type':                 $q->orderBy('pt.sort_order,p.projects_types_id, p.name');
          break;
        case 'group':                $q->orderBy('pg.sort_order,p.projects_groups_id, p.name');
          break;
        default:                     $q->orderBy('ps.status_group desc, ps.sort_order,p.projects_status_id, p.name');                    
          break; 
      }                  
    }
                  
    return $q;  
  }
}