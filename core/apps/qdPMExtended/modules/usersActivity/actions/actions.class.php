<?php

/**
 * usersActivity actions.
 *
 * @package    sf_sandbox
 * @subpackage usersActivity
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class usersActivityActions extends sfActions
{
  protected function checkProjectsAccess($projects)
  {    
    Projects::checkViewOwnAccess($this,$this->getUser(),$projects);    
  }
  
  protected function add_pid($request,$sep='?')
  {
    if((int)$request->getParameter('projects_id')>0)
    {
      return $sep . 'projects_id=' . $request->getParameter('projects_id');
    }
    else
    {
      return '';
    }
  }
  
  protected function get_pid($request)
  {
    return ((int)$request->getParameter('projects_id')>0 ? $request->getParameter('projects_id') : '');
  }
  
  public function executeIndex(sfWebRequest $request)
  {    
    app::setPageTitle('Users Activity',$this->getResponse());
    
    if(!$this->getUser()->hasCredential('reports_access_activity'))
    {
      $this->redirect('accessForbidden/index');
    }
    
    if($request->hasParameter('projects_id'))
    {
      $this->forward404Unless($this->projects = Doctrine_Core::getTable('Projects')->createQuery()->addWhere('id=?',$request->getParameter('projects_id'))->addWhere('in_trash is null')->fetchOne(), sprintf('Object projects does not exist (%s).', $request->getParameter('projects_id')));
      
      $this->checkProjectsAccess($this->projects);     
    }
    
    
    if(!$this->getUser()->hasAttribute('users_activity_filters'. $this->get_pid($request)))
    {
      $this->getUser()->setAttribute('users_activity_filters'. $this->get_pid($request),array('users_id'=>0,'projects_id'=>0,'from'=>date('Y-m-d'),'to'=>'','days'=>0));
    }
    
    if($request->isMethod(sfRequest::PUT) and $request->hasParameter('filters'))
    {
      $this->getUser()->setAttribute('users_activity_filters'. $this->get_pid($request),$request->getParameter('filters'));
      $this->redirect('usersActivity/index'. $this->add_pid($request));
    }
    
    $this->filters = $this->getUser()->getAttribute('users_activity_filters'. $this->get_pid($request));
    
    if($request->getParameter('projects_id')>0)
    {
      $this->filters['projects_id'] = $request->getParameter('projects_id'); 
    }
    
    $this->atcivity_list = $this->getActivityList($this->filters);          
  }
  
  public function executePersonal(sfWebRequest $request)
  { 
    if(!$this->getUser()->hasCredential('reports_access_activity_personal'))
    {
      $this->redirect('accessForbidden/index');
    }
    
       
    if(!$this->getUser()->hasAttribute('personal_activity_filters'))
    {
      $this->getUser()->setAttribute('personal_activity_filters',array('users_id'=>0,'projects_id'=>0,'from'=>date('Y-m-d'),'to'=>''));
    }
    
    if($request->isMethod(sfRequest::PUT) and $request->hasParameter('filters'))
    {
      $this->getUser()->setAttribute('personal_activity_filters',$request->getParameter('filters'));
      $this->redirect('usersActivity/personal');
    }
    
    $this->filters = $this->getUser()->getAttribute('personal_activity_filters');
    
    $this->filters['users_id'] = $this->getUser()->getAttribute('id');
    
    $this->atcivity_list = $this->getActivityList($this->filters);          
  }
  
    
  protected function getActivityList($filters)
  {
    $include_projects = array(0);
    
    if(Users::hasAccess('view_own','projects',$this->getUser()))
    {
       $q = Doctrine_Core::getTable('Projects')->createQuery('p')
          ->leftJoin('p.ProjectsPriority pp')
          ->leftJoin('p.ProjectsStatus ps')
          ->leftJoin('p.ProjectsTypes pt')
          ->leftJoin('p.ProjectsGroups pg')
          ->leftJoin('p.Users')
          ->addWhere('in_trash is null');
                         
        $q->addWhere("find_in_set('" . $this->getUser()->getAttribute('id') . "',p.team) or p.created_by='" . $this->getUser()->getAttribute('id') . "'");
                
        foreach($q->fetchArray() as $p)
        {
          $include_projects[] = $p['id'];
        }
    }
  
    $l = array();
    
    $l[] = array('table'=>'Projects','users_id'=>'created_by','projects_id'=>'t.id');
    $l[] = array('table'=>'ProjectsComments','users_id'=>'created_by','projects_id'=>'p.id');
    $l[] = array('table'=>'Tasks','users_id'=>'created_by','projects_id'=>'t.projects_id');
    $l[] = array('table'=>'TasksComments','users_id'=>'created_by','projects_id'=>'p.projects_id');
    $l[] = array('table'=>'Tickets','users_id'=>'users_id','projects_id'=>'t.projects_id');
    $l[] = array('table'=>'TicketsComments','users_id'=>'users_id','projects_id'=>'p.projects_id');
    $l[] = array('table'=>'Discussions','users_id'=>'users_id','projects_id'=>'t.projects_id');
    $l[] = array('table'=>'DiscussionsComments','users_id'=>'users_id','projects_id'=>'p.projects_id');
    
    if($filters['days']>0)
    {
      $filters['from'] = date('Y-m-d',strtotime("-" . $filters['days'] . " day"));
    }
    elseif($filters['days']==0 and strlen($filters['from'])==0 and strlen($filters['to'])==0)
    {
      $filters['from'] = date('Y-m-d');
    }
            
    $a = array();
    foreach($l as $v)
    {
      $q = Doctrine_Core::getTable($v['table'])->createQuery('t');
      
      if(strstr($v['table'],'Comments'))
      {
        $q->leftJoin('t.' . str_replace('Comments','',$v['table']) . ' p');        
      }
      
      if($filters['users_id']>0)
      {
        $q->addWhere('t.' . $v['users_id'] . '=?',$filters['users_id']);
      }
      
      if(Users::hasAccess('view_own','projects',$this->getUser()))
      {        
        $q->whereIn($v['projects_id'],$include_projects);        
      }
      
      if($filters['projects_id']>0)
      {
        $q->addWhere($v['projects_id'].'=?',$filters['projects_id']);
      }
      
      if(strlen($filters['from'])>0 and strlen($filters['to'])>0)
      {
        $q->addWhere("date_format(t.created_at,'%Y-%m-%d') BETWEEN '" . $filters['from'] . "' AND '" . $filters['to'] . "'");
      }
      elseif(strlen($filters['from'])>0)
      {
        $q->addWhere("date_format(t.created_at,'%Y-%m-%d')>='" . $filters['from'] . "'");
      }
      elseif(strlen($filters['to'])>0)
      {
        $q->addWhere("date_format(t.created_at,'%Y-%m-%d')<='" . $filters['to'] . "'");
      }
      
      foreach($q->fetchArray() as $item)
      {
        $a[app::getDateTimestamp($item['created_at'])]=array('table'=>$v['table'],'id'=>$item['id']);
      }
    }
        
    krsort($a);
    
    return $a;
    
  }
}
