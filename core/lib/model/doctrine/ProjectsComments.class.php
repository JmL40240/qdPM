<?php

/**
 * ProjectsComments
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    sf_sandbox
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class ProjectsComments extends BaseProjectsComments
{
  public static function sendNotification($c,$comment,$sf_user)
  {
    $to = array();
    foreach(explode(',',$comment->getProjects()->getTeam()) as $v)
    {
      if($u = Doctrine_Core::getTable('Users')->find($v))
      {
        if(strlen($u->getUsersGroups()->getProjectsCommentsAccess())>0)
        {
          $to[$u->getEmail()]=$u->getName();
        }
      }
    }
          
    $user = $sf_user->getAttribute('user');
    $from[$user->getEmail()] = $user->getName();
    $to[$comment->getProjects()->getUsers()->getEmail()] = $comment->getProjects()->getUsers()->getName();
    $to[$user->getEmail()] = $user->getName();
    
    $projects_comments = Doctrine_Core::getTable('ProjectsComments')
      ->createQuery()
      ->addWhere('projects_id=?',$comment->getProjectsId())
      ->addWhere('in_trash is null')
      ->orderBy('created_at desc')
      ->execute();
      
    foreach($projects_comments as $v)
    {      
      $to[$v->getUsers()->getEmail()]=$v->getUsers()->getName();      
    }
    
    if(sfConfig::get('app_send_email_to_owner')=='off')
    {
      unset($to[$user->getEmail()]);             
    }
                 
    $subject = t::__('New Project Comment') . ': ' . $comment->getProjects()->getName() . ($comment->getProjects()->getProjectsStatusId()>0 ? ' [' . $comment->getProjects()->getProjectsStatus()->getName() . ']':'');
    $body  = $c->getComponent('projectsComments','emailBody',array('projects'=>$comment->getProjects()));
                
    Users::sendEmail($from,$to,$subject,$body,$sf_user);
  }
}