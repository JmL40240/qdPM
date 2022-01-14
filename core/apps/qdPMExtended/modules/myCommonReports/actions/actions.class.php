<?php

/**
 * commonReports actions.
 *
 * @package    sf_sandbox
 * @subpackage commonReports
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class myCommonReportsActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->projects_reports = Doctrine_Core::getTable('ProjectsReports')
      ->createQuery()      
      ->addWhere('report_type=?','common')
      ->addWhere('find_in_set(' . $this->getUser()->getAttribute('users_group_id') .  ',users_groups_id)')
      ->orderBy('name')
      ->execute();
          
    $this->user_reports = Doctrine_Core::getTable('UserReports')
      ->createQuery()      
      ->addWhere('report_type=?','common')
      ->addWhere('find_in_set(' . $this->getUser()->getAttribute('users_group_id') .  ',users_groups_id)')
      ->orderBy('name')
      ->execute();
      
    $this->tickets_reports = Doctrine_Core::getTable('TicketsReports')    
      ->createQuery()      
      ->addWhere('report_type=?','common')
      ->addWhere('find_in_set(' . $this->getUser()->getAttribute('users_group_id') .  ',users_groups_id)')
      ->orderBy('name')
      ->execute();
      
   $this->discussions_reports = Doctrine_Core::getTable('DiscussionsReports')
      ->createQuery()      
      ->addWhere('report_type=?','common')
      ->addWhere('find_in_set(' . $this->getUser()->getAttribute('users_group_id') .  ',users_groups_id)')
      ->orderBy('name')
      ->execute();
            
    $this->hidden_reports = Users::getHiddenReports($this->getUser()->getAttribute('id'));
    
    if($request->getParameter('hide'))
    {
      $hidden = array();
      foreach($request->getParameter('hidden') as $k=>$v)
      {
        $hidden[] = $k.$v;
      }
    
      $u = Doctrine_Core::getTable('Users')->find($this->getUser()->getAttribute('id'));
      $u->setHiddenCommonReports(implode(',',$hidden));
      $u->save();
      
      $this->redirect('myCommonReports/index');
    }
    
    app::setPageTitle('Common Reports',$this->getResponse());     
  }     
}
