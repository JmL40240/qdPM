<?php

/**
 * dashboard actions.
 *
 * @package    sf_sandbox
 * @subpackage dashboard
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class dashboardActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    if($this->getUser()->getAttribute('users_group_id')==0)
    {
      $this->redirect('users/index');
    }
        
    $this->reports = array();
    
    if($user = Doctrine_Core::getTable('Users')->find($this->getUser()->getAttribute('id')))
    {
      if($user->getPersonalSchedulerEvensOnhome()==1){ $this->reports[]='personalEvents'; }
      if($user->getPublicSchedulerEvensOnhome()==1){ $this->reports[]='publicEvents'; }            
    }
    
    //users reports
    $projects_reports = Doctrine_Core::getTable('ProjectsReports')
      ->createQuery()
      ->addWhere('users_id=?',$this->getUser()->getAttribute('id'))
      ->addWhere('display_on_home=1')
      ->addWhere('report_type is null or length(report_type)=0')
      ->orderBy('name')
      ->execute();
      
    foreach($projects_reports as $v)
    {
      $this->reports[] = 'projectsReports' . $v->getId();
    }
      
    $user_reports = Doctrine_Core::getTable('UserReports')
      ->createQuery()
      ->addWhere('users_id=?',$this->getUser()->getAttribute('id'))
      ->addWhere('display_on_home=1')
      ->addWhere('report_type is null or length(report_type)=0')
      ->orderBy('name')
      ->execute();
      
    foreach($user_reports as $v)
    {
      $this->reports[] = 'userReports' . $v->getId();
    }
      
    $tickets_reports = Doctrine_Core::getTable('TicketsReports')
      ->createQuery()
      ->addWhere('users_id=?',$this->getUser()->getAttribute('id'))
      ->addWhere('display_on_home=1')
      ->addWhere('report_type is null or length(report_type)=0')
      ->orderBy('name')
      ->execute();
   
    foreach($tickets_reports as $v)
    {
      $this->reports[] = 'ticketsReports' . $v->getId();
    }
      
    $discussions_reports = Doctrine_Core::getTable('DiscussionsReports')
      ->createQuery()
      ->addWhere('users_id=?',$this->getUser()->getAttribute('id'))
      ->addWhere('display_on_home=1')
      ->addWhere('report_type is null or length(report_type)=0')
      ->orderBy('name')
      ->execute();
    
    foreach($discussions_reports as $v)
    {
      $this->reports[] = 'discussionsReports' . $v->getId();
    }  
    
    //common reports  
    $projects_reports = Doctrine_Core::getTable('ProjectsReports')
      ->createQuery()      
      ->addWhere('report_type=?','common')
      ->addWhere('find_in_set(' . $this->getUser()->getAttribute('users_group_id') .  ',users_groups_id)')
      ->addWhere('display_on_home=1')
      ->orderBy('name')
      ->execute();
    
    foreach($projects_reports as $v)
    {
      $this->reports[] = 'projectsReports' . $v->getId();
    }
          
    $user_reports = Doctrine_Core::getTable('UserReports')
      ->createQuery()      
      ->addWhere('report_type=?','common')
      ->addWhere('find_in_set(' . $this->getUser()->getAttribute('users_group_id') .  ',users_groups_id)')
      ->addWhere('display_on_home=1')
      ->orderBy('name')
      ->execute();
    
    foreach($user_reports as $v)
    {
      $this->reports[] = 'userReports' . $v->getId();
    }
      
    $tickets_reports = Doctrine_Core::getTable('TicketsReports')    
      ->createQuery()      
      ->addWhere('report_type=?','common')
      ->addWhere('find_in_set(' . $this->getUser()->getAttribute('users_group_id') .  ',users_groups_id)')
      ->addWhere('display_on_home=1')
      ->orderBy('name')
      ->execute();
    
    foreach($tickets_reports as $v)
    {
      $this->reports[] = 'ticketsReports' . $v->getId();
    }
      
    $discussions_reports = Doctrine_Core::getTable('DiscussionsReports')
      ->createQuery()      
      ->addWhere('report_type=?','common')
      ->addWhere('find_in_set(' . $this->getUser()->getAttribute('users_group_id') .  ',users_groups_id)')
      ->addWhere('display_on_home=1')
      ->orderBy('name')
      ->execute();
      
    foreach($discussions_reports as $v)
    {
      $this->reports[] = 'discussionsReports' . $v->getId();
    } 
    
    if($u = Doctrine_Core::getTable('Users')->find($this->getUser()->getAttribute('id')))
    {
        $this->hidden_common_reports = explode(',',$u->getHiddenCommonReports());
        $this->hidden_dashboard_reports = explode(',',$u->getHiddenDashboardReports());
        $sorted_reports = explode(',',$u->getSortedDashboardReports());
    }
    else
    {
        $this->hidden_common_reports = '';
        $this->hidden_dashboard_reports = '';
        $sorted_reports = '';
    }
    
    $reports_tmp = array();
    
    foreach($this->reports as $v)
    {
      if(!in_array($v,$sorted_reports))
      {
        $reports_tmp[] = $v;
      }
    }
    
    foreach($sorted_reports as $v)
    {
      if(in_array($v,$this->reports))
      {
        $reports_tmp[] = $v;
      }
    }
    
    $this->reports = $reports_tmp; 
    
    
    app::setPageTitle('Dashboard',$this->getResponse());
  }
  
  public function executeExpandReport(sfWebRequest $request)
  {
    $u = Doctrine_Core::getTable('Users')->find($this->getUser()->getAttribute('id'));
    $hidden_reports = explode(',',$u->getHiddenDashboardReports());
    
    if($request->getParameter('type')=='hide')
    {
      $hidden_reports[] = $request->getParameter('report');
      $u->setHiddenDashboardReports(implode(',',$hidden_reports));
      $u->save();
    }
    else
    {
      if($key = array_search($request->getParameter('report'),$hidden_reports))
      {
        unset($hidden_reports[$key]);
        
        $u->setHiddenDashboardReports(implode(',',$hidden_reports));
        $u->save();
      }
    }
    exit();
  } 
  
  public function executeConfigure(sfWebRequest $request)
  {     
    $this->projects_reports = Doctrine_Core::getTable('ProjectsReports')
      ->createQuery()
      ->addWhere('users_id=?',$this->getUser()->getAttribute('id'))      
      ->addWhere('report_type is null or length(report_type)=0')
      ->orderBy('name')
      ->execute();
            
    $this->user_reports = Doctrine_Core::getTable('UserReports')
      ->createQuery()
      ->addWhere('users_id=?',$this->getUser()->getAttribute('id'))      
      ->addWhere('report_type is null or length(report_type)=0')
      ->orderBy('name')
      ->execute();
      
    $this->tickets_reports = Doctrine_Core::getTable('TicketsReports')
      ->createQuery()
      ->addWhere('users_id=?',$this->getUser()->getAttribute('id'))      
      ->addWhere('report_type is null or length(report_type)=0')
      ->orderBy('name')
      ->execute();
       
    $this->discussions_reports = Doctrine_Core::getTable('DiscussionsReports')
      ->createQuery()
      ->addWhere('users_id=?',$this->getUser()->getAttribute('id'))      
      ->addWhere('report_type is null or length(report_type)=0')
      ->orderBy('name')
      ->execute();
      
    if($request->isMethod(sfRequest::PUT))
    {
      Doctrine_Query::create()->update('ProjectsReports')->set('display_on_home', 0)->where('users_id =?', $this->getUser()->getAttribute('id'))->addWhere('report_type is null or length(report_type)=0')->execute();
      Doctrine_Query::create()->update('UserReports')->set('display_on_home', 0)->where('users_id =?', $this->getUser()->getAttribute('id'))->addWhere('report_type is null or length(report_type)=0')->execute();
      Doctrine_Query::create()->update('TicketsReports')->set('display_on_home', 0)->where('users_id =?', $this->getUser()->getAttribute('id'))->addWhere('report_type is null or length(report_type)=0')->execute();
      Doctrine_Query::create()->update('DiscussionsReports')->set('display_on_home', 0)->where('users_id =?', $this->getUser()->getAttribute('id'))->addWhere('report_type is null or length(report_type)=0')->execute();
      
      if($request->hasParameter('projects_reports'))
      {
        Doctrine_Query::create()->update('ProjectsReports')->set('display_on_home', 1)->whereIn('id',$request->getParameter('projects_reports'))->addWhere('users_id =?', $this->getUser()->getAttribute('id'))->execute();                
      }
      
      if($request->hasParameter('user_reports'))
      {
        Doctrine_Query::create()->update('UserReports')->set('display_on_home', 1)->whereIn('id',$request->getParameter('user_reports'))->addWhere('users_id =?', $this->getUser()->getAttribute('id'))->execute();                
      }
      
      if($request->hasParameter('tickets_reports'))
      {
        Doctrine_Query::create()->update('TicketsReports')->set('display_on_home', 1)->whereIn('id',$request->getParameter('tickets_reports'))->addWhere('users_id =?', $this->getUser()->getAttribute('id'))->execute();                
      }
      
      if($request->hasParameter('discussions_reports'))
      {
        Doctrine_Query::create()->update('DiscussionsReports')->set('display_on_home', 1)->whereIn('id',$request->getParameter('discussions_reports'))->addWhere('users_id =?', $this->getUser()->getAttribute('id'))->execute();                
      }
      
      $this->redirect('dashboard/index');
    }
  }
  
  public function executeSortReports(sfWebRequest $request)
  { 
          
    $this->reports = explode(',',$request->getParameter('reports'));
                  
    $u = Doctrine_Core::getTable('Users')->find($this->getUser()->getAttribute('id'));
    $this->hidden_common_reports = explode(',',$u->getHiddenCommonReports());
    $sorted_reports = explode(',',$u->getSortedDashboardReports());
    
    $reports_tmp = array();
    
    foreach($this->reports as $v)
    {
      if(!in_array($v,$sorted_reports))
      {
        $reports_tmp[] = $v;
      }
    }
    
    foreach($sorted_reports as $v)
    {
      if(in_array($v,$this->reports))
      {
        $reports_tmp[] = $v;
      }
    }
    
    $this->reports = $reports_tmp;
    
    if($request->hasParameter('put'))
    {    
      if($request->hasParameter('list'))
      {
        $list = $request->getParameter('list');
        $list = json_decode($list,true);
      
        $this->reports = array();
        foreach($list as $v)
        {
          $this->reports[] = $v['id'];
        }                      
      }
                    
      $u->setSortedDashboardReports(implode(',',$this->reports));
      $u->save();
      
      exit();
    }
    
    
  }
}
