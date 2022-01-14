<?php

/**
 * Patterns
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    sf_sandbox
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Patterns extends BasePatterns
{
  public static function getPatternsTypesList($sf_user)
  {    
    $list = array();
        
    if(Users::hasAccess('insert|edit','projects',$sf_user)) $list['projects_description'] = t::__('Project Description');
    if(Users::hasAccess('insert|edit','projectsComments',$sf_user)) $list['projects_comments'] = t::__('Project Comment');
    if(Users::hasAccess('insert|edit','tasks',$sf_user)) $list['tasks_description'] = t::__('Task Description');
    if(Users::hasAccess('insert|edit','tasksComments',$sf_user)) $list['tasks_comments'] = t::__('Task Comment');
    if(Users::hasAccess('insert|edit','tickets',$sf_user)) $list['tickets_description'] = t::__('Ticket Description');
    if(Users::hasAccess('insert|edit','ticketsComments',$sf_user)) $list['tickets_comments'] = t::__('Ticket Comments');
    if(Users::hasAccess('insert|edit','discussions',$sf_user)) $list['discussions_description'] = t::__('Discussion Description');
    if(Users::hasAccess('insert|edit','discussionsComments',$sf_user)) $list['discussions_comments'] = t::__('Discussion Comment');
    
    return $list;
  }
  
  public static function getPatternsTypeById($id, $sf_user)
  {
    $list  = Patterns::getPatternsTypesList($sf_user);
    
    if(isset($list[$id]))
    {
      return $list[$id];
    }
    else
    {
      return $id; 
    }
  }
}