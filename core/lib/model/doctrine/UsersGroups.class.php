<?php

/**
 * UsersGroups
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    sf_sandbox
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class UsersGroups extends BaseUsersGroups
{
  public static function getLdapDafaultGroupId()
  {
    if($ug = Doctrine_Core::getTable('UsersGroups')->createQuery()->addWhere('ldap_default=1')->fetchOne())
    {
      return $ug->getId();
    }
    else
    {
      return false;
    }

  }
  
  public static function countUsersByGroupId($id)
  {
    return Doctrine_Core::getTable('Users')->createQuery()->addWhere('users_group_id=?',$id)->count();
  }
  
  public static function getNameById($id,$separator='<br>')
  {
    $n = array();
    foreach(explode(',',$id) as $v)
    {
      if($ug = Doctrine_Core::getTable('UsersGroups')->find($v))
      {
        $n[] = $ug->getName();
      }
    }
    
    return implode($separator,$n);
  }

  public static function getChoicesByType($type=false,$add_empty = false)
  {
    $q = Doctrine_Core::getTable('UsersGroups')
      ->createQuery();
    
    if($type)
    {
      $q->addWhere('group_type=?',$type);
    }
    else
    {
      $q->addWhere('group_type is null or length(group_type)=0');
    }
    
    $groups = $q->orderBy('name')->execute();
    
    $choices = array();
    
    if($add_empty)
    {
      $choices[''] = '';
    }
        
    foreach($groups as $v)
    {
      $choices[$v->getId()]=$v->getName(); 
    }
    
    return $choices;
  }
  
  public static function is_checked_reports_field($k,$ug)
  {
    if(is_object($ug))
    if(in_array($k,explode(',',$ug->getAllowManageReports())))
    {
      return 'checked="checked"';
    }
    else
    {
      return '';
    }
  }
  
  
  public static function getAccessNameByKey($k)
  {
    
    $a = '<i style="color:#cbcbcb">' .__('none') . '</i>';
        
    switch($k)
    {
      case 'insert_only': 
          $a = t::__('Insert and View');
        break;
      case 'full_access': 
          $a = t::__('Full Access');
        break;
      case 'manage_own_lnly': 
          $a = t::__('Manage Own');
        break;  
      case 'view_own_only': 
          $a = t::__('View Own');
        break;
      case 'view_only': 
          $a = t::__('View Only');
        break;
      case 'custom': 
          $a = t::__('Custom Access');
        break;                      
      case 1: 
          $a = t::__('Yes');
        break;       
    }
    
    return $a ;
  } 
  
  
  public static function getReportAccessNameByKey($k,$ug)
  {
    if(in_array($k,explode(',',$ug->getAllowManageReports())))
    {
      return t::__('Yes');;
    }
    else
    {
      return '<i style="color:#cbcbcb">' .__('none') . '</i>';
    }    
  }
    
  public static function getAccessTable($ug, $type='',$include_reports = true)
  {
    $html = '';
            
    switch($type)
    {
      case 'projects':
         $html = '
            <table class="listingDataTable">
              <tr>
                <td><b>' . t::__('Projects'). ':</b></td>
                <td>' . UsersGroups::getAccessNameByKey($ug->getAllowManageProjects()) . '</td>
              </tr>              
              <tr>
                <td>' . t::__('Comments'). ':</td>
                <td>' . UsersGroups::getAccessNameByKey($ug->getProjectsCommentsAccess()).   '</td>
              </tr>
              </table>
              <table class="listingDataTable">' .
              ($include_reports ?
              '<tr>
                <td>' . t::__('Projects Reports'). ':</td>
                <td>' . UsersGroups::getReportAccessNameByKey('projects',$ug) . '</td>
              </tr>'
               :'') .
              '<tr>
                <td>' . t::__('Projects Wiki'). ':</td>
                <td>' . UsersGroups::getAccessNameByKey($ug->getAllowManageProjectsWiki()) . '</td>
              </tr> 
             </table>'; 
        break;
       case 'tasks':
         $html = '
            <table class="listingDataTable">
              <tr>
                <td ><b>' . t::__('Tasks'). ':</b></td>
                <td>' . UsersGroups::getAccessNameByKey($ug->getAllowManageTasks()) . '</td>
              </tr>
              <tr>
                <td>' . t::__('Comments'). ':</td>
                <td>' . UsersGroups::getAccessNameByKey($ug->getTasksCommentsAccess()).   '</td>
              </tr>
              </table>' .
              ($include_reports ?
              '<table class="listingDataTable">
              <tr>
                <td>' . t::__('Tasks Reports'). ':</td>
                <td>' . UsersGroups::getReportAccessNameByKey('tasks',$ug) . '</td>
              </tr>
              <tr>
                <td>' . t::__('Gantt Chart'). ':</td>
                <td>' . UsersGroups::getReportAccessNameByKey('gantt',$ug) . '</td>
              </tr>
              <tr>
                <td>' . t::__('Time Report'). ':</td>
                <td>' . UsersGroups::getReportAccessNameByKey('time',$ug) . '</td>
              </tr>
              <tr>
                <td>' . t::__('Personal Time Report'). ':</td>
                <td>' . UsersGroups::getReportAccessNameByKey('time_personal',$ug) . '</td>
              </tr> 
             </table>':''); 
        break;
       case 'tickets':
         $html = '
            <table class="listingDataTable">
              <tr>
                <td style="font-size: 11px;"><b>' . t::__('Tickets'). ':</b></td>
                <td>' . UsersGroups::getAccessNameByKey($ug->getAllowManageTickets()) . '</td>
              </tr>
              <tr>
                <td>' . t::__('Comments'). ':</td>
                <td>' . UsersGroups::getAccessNameByKey($ug->getTicketsCommentsAccess()).   '</td>
              </tr>
              </table>' .
              ($include_reports ?
              '<table class="listingDataTable">
              <tr>
                <td>' . t::__('Tickets Reports'). ':</td>
                <td>' . UsersGroups::getReportAccessNameByKey('tickets',$ug) . '</td>
              </tr> 
             </table>':''); 
        break;
       case 'discussions':
         $html = '
            <table class="listingDataTable">
              <tr>
                <td><b>' . t::__('Discussions'). ':</b></td>
                <td>' . UsersGroups::getAccessNameByKey($ug->getAllowManageDiscussions()) . '</td>
              </tr>
              <tr>
                <td>' . t::__('Comments'). ':</td>
                <td>' . UsersGroups::getAccessNameByKey($ug->getDiscussionsCommentsAccess()).   '</td>
              </tr>
              </table>' .
              ($include_reports ?
              '<table class="listingDataTable">
              <tr>
                <td>' . t::__('Discussions Reports'). ':</td>
                <td>' . UsersGroups::getReportAccessNameByKey('discussions',$ug) . '</td>
              </tr> 
             </table>':''); 
        break;
        case 'extra':
         $html = '
            <table class="listingDataTable">
              <tr>
                <td><b>' . t::__('Configuration'). ':</b></td>
                <td>' . UsersGroups::getAccessNameByKey($ug->getAllowManageConfiguration()) . '</td>
              </tr>
              <tr>
                <td>' . t::__('Users'). ':</td>
                <td>' . UsersGroups::getAccessNameByKey($ug->getAllowManageUsers()) . '</td>
              </tr>
              <tr>
                <td>' . t::__('Users Activity'). ':</td>
                <td>' . UsersGroups::getReportAccessNameByKey('activity',$ug) . '</td>
              </tr> 
              <tr>
                <td>' . t::__('Personal User Activity'). ':</td>
                <td>' . UsersGroups::getReportAccessNameByKey('activity_personal',$ug) . '</td>
              </tr>               
              <tr>
                <td>' . t::__('Contacts'). ':</td>
                <td>' . UsersGroups::getAccessNameByKey($ug->getAllowManageContacts()) . '</td>
              </tr>
              <tr>
                <td>' . t::__('Patterns'). ':</td>
                <td>' . UsersGroups::getAccessNameByKey($ug->getAllowManagePatterns()) . '</td>
              </tr>
              <tr>
                <td>' . t::__('Public Wiki'). ':</td>
                <td>' . UsersGroups::getAccessNameByKey($ug->getAllowManagePublicWiki()) . '</td>
              </tr>              
              <tr>
                <td>' . t::__('Public Scheduler'). ':</td>
                <td>' . UsersGroups::getAccessNameByKey($ug->getAllowManagePublicScheduler()) . '</td>
              </tr>
              <tr>
                <td>' . t::__('Personal Scheduler'). ':</td>
                <td>' . UsersGroups::getAccessNameByKey($ug->getAllowManagePersonalScheduler()) . '</td>
              </tr>
             </table>'; 
        break;
    }
    
    $html = str_replace('<td>','<td style="white-space:normal">',$html);
    
    return $html;
  }
}