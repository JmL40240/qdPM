<?php

class menuController
{
  public $sf_user;
  
  public $sf_request;
  
  public function __construct($sf_user,$sf_request)
	{
	  $this->sf_user = $sf_user;
	  $this->user = $sf_user->getAttribute('user');
	  $this->sf_request = $sf_request;
	  
    $this->access = array();
    
    if($sf_user->isAuthenticated())
    {
	    $this->access['projects'] = Users::getAccessSchema('projects',$sf_user);
	    $this->access['tasks'] = Users::getAccessSchema('tasks',$sf_user);
      $this->access['tickets'] = Users::getAccessSchema('tickets',$sf_user);
      $this->access['discussions'] = Users::getAccessSchema('discussions',$sf_user);            
	  }
	}
	
	public function buildUserMenu()
	{
	  if(!$this->sf_user->isAuthenticated())
    {
      return array();
    }
       
    if($this->sf_user->getAttribute('users_group_id')==0)
    {
      return array(array('title'=>__('Logoff'),'url'=>'login/logoff'));
    }
    
    $user = $this->sf_user->getAttribute('user');
    
    $m = array();              
    $s = array();
    $s[] = array('title'=>__('My Details'),'url'=>'myAccount/index','class'=>'fa-user');    
    
    if($this->sf_user->hasCredential('reports_access_time_personal')){$s[] = array('title'=>__('My Time Report'),'url'=>'timeReport/myTimeReport','class'=>'fa-clock-o');}        
    if($this->sf_user->hasCredential('reports_access_activity_personal')){ $s[] = array('title'=>__('My Activity Report'),'url'=>'usersActivity/personal','class'=>'fa-tasks'); }
    if($this->sf_user->hasCredential('allow_manage_patterns')){ $s[] = array('title'=>__('My Patterns'),'url'=>'patterns/index','class'=>'fa-file-text-o'); }
    
    $s[] = array('title'=>__('My Common Reports'),'url'=>'myCommonReports/index','class'=>'fa-list-alt');
    
    
                    
    if($this->sf_user->hasCredential('allow_manage_personal_scheduler'))
    { 
      $count = '';
      
      if(($count = Events::getCountTodaysEvents($this->sf_user->getAttribute('id')))>0)
      {
        $count = $count; 
      }
      else
      {
        $count = null;
      }
                        
      $s[] = array('title'=>__('My Scheduler') ,'url'=>'scheduler/personal','class'=>'fa-calendar','counts'=>$count); 
    }
    
    if(sfConfig::get('app_use_skins')=='on')$s[] = array('title'=>__('Change Skin'),'url'=>'skins/index','modalbox'=>true,'class'=>'fa-picture-o');
    
    $s[] = array('title'=>__('Logoff'),'url'=>'login/logoff','is_hr'=>true,'class'=>'fa-sign-out');    
      
    return $s;
	}
	
	public function buildProjectsMenu()
	{
	  $s = array();
	  
	  $reports = Doctrine_Core::getTable('ProjectsReports')
      ->createQuery()
      ->addWhere('(users_id="' . $this->sf_user->getAttribute('id') . '" and (report_type is null or length(report_type)=0)) or (report_type="common" and find_in_set(' . $this->sf_user->getAttribute('users_group_id') .  ',users_groups_id))')
      ->addWhere('display_in_menu=1')
      ->orderBy('report_type, name')
      ->execute();
    
    $is_hr = false;
    
    foreach($reports as $r)
    {
      $is_hr = true;
      /*
      $q = Doctrine_Core::getTable('Projects')->createQuery('p')
          ->leftJoin('p.ProjectsPriority pp')
          ->leftJoin('p.ProjectsStatus ps')
          ->leftJoin('p.ProjectsTypes pt')
          ->leftJoin('p.ProjectsGroups pg')
          ->leftJoin('p.Users')
          ->addWhere('in_trash is null');
          
      $q = ProjectsReports::addFiltersToQuery($q,$r->getId(),$this->sf_user);
      
      $pm = array();
      foreach($q->fetchArray() as $p)
      {
        $pm[] = array('title'=>$p['name'],'url'=>'projects/open?projects_id=' . $p['id']);
      } 
      */
    
      $s[] = array('title'=>$r->getName(),'url'=>'projectsReports/view?id=' . $r->getId(),'submenu'=>$pm);
    }    
	  
	  
	  if($this->access['projects']['insert'])
	  {	                 
      $s[] = array('title'=>__('Add Project'),'url'=>'projects/new','modalbox'=>true,'is_hr'=>$is_hr);
      $is_hr = false;
    }

    $s[] = array('title'=>__('View All'),'url'=>'projects/index','is_hr'=>$is_hr);
	  
    return array('title'=>__('Projects'),'url'=>'projects/index','submenu'=>$s,'class'=>'fa-sitemap');
	}
	
	public function buildTasksMenu()
	{
	  $s = array();
	  
	  $reports = Doctrine_Core::getTable('UserReports')
      ->createQuery()
      ->addWhere('(users_id="' . $this->sf_user->getAttribute('id') . '" and (report_type is null or length(report_type)=0)) or (report_type="common" and find_in_set(' . $this->sf_user->getAttribute('users_group_id') .  ',users_groups_id))')
      ->addWhere('display_in_menu=1')
      ->orderBy('report_type, name')
      ->fetchArray();
      
    $is_hr = false;
    foreach($reports as $r)
    { 
      $is_hr = true;        
      $s[] = array('title'=>$r['name'],'url'=>'userReports/view?id=' . $r['id']);
    }    
	  	  
	  if($this->access['tasks']['insert'])
	  {	                 
      $s[] = array('title'=>__('Add Task'),'url'=>'tasks/new','modalbox'=>true,'is_hr'=>$is_hr);
      $is_hr = false;
    }

    $s[] = array('title'=>__('View All'),'url'=>'tasks/index','is_hr'=>$is_hr);
	
    return array('title'=>__('Tasks'),'url'=>'tasks/index','submenu'=>$s,'class'=>'fa-tasks');
	}
	
	public function buildTicketsMenu()
	{
    $s = array();
	  
	  $reports = Doctrine_Core::getTable('TicketsReports')
      ->createQuery()
      ->addWhere('(users_id="' . $this->sf_user->getAttribute('id') . '" and (report_type is null or length(report_type)=0)) or (report_type="common" and find_in_set(' . $this->sf_user->getAttribute('users_group_id') .  ',users_groups_id))')
      ->addWhere('display_in_menu=1')
      ->orderBy('report_type, name')
      ->fetchArray();
      
    $is_hr = false;
    foreach($reports as $r)
    { 
      $is_hr = true;        
      $s[] = array('title'=>$r['name'],'url'=>'ticketsReports/view?id=' . $r['id']);
    }    
	  	  
	  if($this->access['tickets']['insert'])
	  {	                 
      //$s[] = array('title'=>__('Add Ticket'),'url'=>'tickets/new','modalbox'=>true,'is_hr'=>$is_hr);
      //$is_hr = false;
    }

    $s[] = array('title'=>__('View All'),'url'=>'tickets/index','is_hr'=>$is_hr);
	
    return array('title'=>__('Tickets'),'url'=>'tickets/index','submenu'=>$s,'class'=>'fa-bell');
	}
	
	public function buildDiscussionsMenu()
	{
    $s = array();
	  
	  $reports = Doctrine_Core::getTable('DiscussionsReports')
      ->createQuery()
      ->addWhere('(users_id="' . $this->sf_user->getAttribute('id') . '" and (report_type is null or length(report_type)=0)) or (report_type="common" and find_in_set(' . $this->sf_user->getAttribute('users_group_id') .  ',users_groups_id))')
      ->addWhere('display_in_menu=1')
      ->orderBy('report_type, name')
      ->fetchArray();
      
    $is_hr = false;
    foreach($reports as $r)
    { 
      $is_hr = true;        
      $s[] = array('title'=>$r['name'],'url'=>'discussionsReports/view?id=' . $r['id']);
    }    
	  	  
	  if($this->access['discussions']['insert'])
	  {	                 
      $s[] = array('title'=>__('Add Discussion'),'url'=>'discussions/new','modalbox'=>true,'is_hr'=>$is_hr);
      $is_hr = false;
    }

    $s[] = array('title'=>__('View All'),'url'=>'discussions/index','is_hr'=>$is_hr);
	
    return array('title'=>__('Discussions'),'url'=>'discussions/index','submenu'=>$s,'class'=>'fa-comments');
	}
	
	public function buildReportsMenuByTable($t)
	{
	  $url_action = $t;
	  $url_action[0] = strtolower($url_action[0]);
    
    $rm = array();
    if(count($reports = app::getUsersReportsChoicesByTable($t,$this->sf_user))>0)
    {
      foreach($reports as $id=>$name)
      {
        $rm[] = array('title'=>$name,'url'=>$url_action . '/view?id=' . $id);
      }
    }
    
    return $rm;
  }
	
	public function buildReportsMenu()
	{
	  $s = array();
	  
	  if($this->sf_user->hasCredential('reports_access_projects'))
	  {	    	
      $s[] = array('title'=>__('Project Reports'),'url'=>'projectsReports/index');      
    }
    
    if($this->sf_user->hasCredential('reports_access_tasks'))
	  {	    
	    
      $s[] = array('title'=>__('Tasks Reports'),'url'=>'userReports/index');      
    }
    
    if($this->sf_user->hasCredential('reports_access_tickets'))
	  {	    
	    
      $s[] = array('title'=>__('Tickets Reports'),'url'=>'ticketsReports/index');
      
    }
    
    if($this->sf_user->hasCredential('reports_access_discussions'))
	  {	    	    
      $s[] = array('title'=>__('Discussions Reports'),'url'=>'discussionsReports/index');      
    }
    
	//////////////////
	$s[] = array('title'=>__('Capacitaire'),'url'=>'http://localhost/extensions/qdpm/capacite.php');
	//////////////////	
	
    if($this->sf_user->hasCredential('reports_access_time'))
	{
	    $s[] = array('title'=>__('Imputations'),'url'=>'timeReport/index');	
	}	
    
    if($this->sf_user->hasCredential('reports_access_activity'))
	  {
	    $s[] = array('title'=>__('Users Activity'),'url'=>'usersActivity/index');	
	  }
    
    if($this->sf_user->hasCredential('reports_access_projectsusers'))
    {
      //$s[] = array('title'=>__('Users per Projects'),'url'=>'usersProjectsReport/index');
    }
    
    if($this->sf_user->hasCredential('reports_access_tasksusers'))
    {
      //$s[] = array('title'=>__('Users per Tasks'),'url'=>'usersTasksReport/index');
    }
	  
	if($this->sf_user->hasCredential('reports_access_gantt'))
	{
	   $s[] = array('title'=>__('Gantt Chart'),'url'=>'ganttChart/index');	
	}   
        	    
	if(count($s)>0)
    {
      return array('title'=>__('Reports'),'url'=>'projectsReports/index','submenu'=>$s,'class'=>'fa-bar-chart-o');
    }
    else
    {
      return false;
    }
  }
	
	public function buildUsersMenu()
	{		  
	  $s = array();	  	  
    $s[] = array('title'=>__('Add User'),'url'=>'users/new','modalbox'=>true);    
    $s[] = array('title'=>__('View All'),'url'=>'users/index');
    
    if($this->sf_user->getAttribute('users_group_id')!=0)
    {
      $s[] = array('title'=>__('Send Email'),'url'=>'users/sendEmail','is_hr'=>true);
    }
    
    return array('title'=>__('Users'),'url'=>'users/index','submenu'=>$s,'class'=>'fa-user');    
	}
	
	public function buildContactsMenu()
	{
    $s = array();	  	  
    $s[] = array('title'=>__('Add Contact'),'url'=>'contacts/new','modalbox'=>true);    
    $s[] = array('title'=>__('View All'),'url'=>'contacts/index');
    
    return array('title'=>__('Contacts'),'url'=>'contacts/index','submenu'=>$s,'class'=>'fa-list');
	}
	
	public function buildConfigurationMenu()
	{
    return array('title'=>__('Configuration'),
                 'class'=>'fa-gear', 
                 'url'=>'configuration/index',
                 'submenu'=>array(
                    array('title'=>__('General'),
                      'url'=>'configuration/index',
                      'submenu'=>array(
                        array('title'=>__('General'),'url'=>'configuration/index?type=general'),
                        array('title'=>__('Features'),'url'=>'configuration/index?type=features'),
                        array('title'=>__('Email Options'),'url'=>'configuration/index?type=email_options'),
                        array('title'=>__('LDAP'),'url'=>'configuration/index?type=ldap'),
                        array('title'=>__('Login Page'),'url'=>'configuration/index?type=login'),
                        array('title'=>__('New User Creation'),'url'=>'configuration/index?type=user'),                        
                      )),
                    array('title'=>__('Users'),
                      'url'=>'usersGroups/index',  
                      'submenu'=>array(
                        array('title'=>__('Users Groups'),'url'=>'usersGroups/index'),
                        array('title'=>__('Projects Roles'),'url'=>'projectRoles/index'),
                        array('title'=>__('Extra Fields'),'url'=>'extraFields/index?bind_type=users','is_hr'=>true),
                        array('title'=>__('Extra Fields per Group'),'url'=>'extraFields/extraFieldsByGroup?t=UsersGroups'),
                      )),
                    array('title'=>__('Projects'),
                      'url'=>'projectsStatus/index',
                      'submenu'=>array(
                        array('title'=>__('Status'),'url'=>'projectsStatus/index'),
                        array('title'=>__('Types'),'url'=>'projectsTypes/index'),
                        array('title'=>__('Groups'),'url'=>'projectsGroups/index'),
                        array('title'=>__('Priority'),'url'=>'projectsPriority/index'),
                        array('title'=>__('Default Phases'),'url'=>'phases/index'),
                        array('title'=>__('Phases Status'),'url'=>'phasesStatus/index'),
                        array('title'=>__('Versions Status'),'url'=>'versionsStatus/index'),
                        array('title'=>__('Extra Fields'),'url'=>'extraFields/index?bind_type=projects','is_hr'=>true),
                        array('title'=>__('Extra Fields per Type'),'url'=>'extraFields/extraFieldsByGroup?t=ProjectsTypes'),
                      )),
                    array('title'=>__('Tasks'),
                      'url'=>'tasksStatus/index',
                      'submenu'=>array(
                        array('title'=>__('Status'),'url'=>'tasksStatus/index'),
                        array('title'=>__('Types'),'url'=>'tasksTypes/index'),
                        array('title'=>__('Labels'),'url'=>'tasksLabels/index'),
                        array('title'=>__('Priority'),'url'=>'tasksPriority/index'),
                        array('title'=>__('Tasks Listing'),'url'=>'configuration/index?type=tasks_columns_list'),
                        array('title'=>__('Extra Fields'),'url'=>'extraFields/index?bind_type=tasks','is_hr'=>true),
                        array('title'=>__('Extra Fields per Type'),'url'=>'extraFields/extraFieldsByGroup?t=TasksTypes'),
                      )),
                    array('title'=>__('Tickets'),
                      'url'=>'departments/index',
                      'submenu'=>array(
                        array('title'=>__('Departments'),'url'=>'departments/index'),
                        array('title'=>__('Status'),'url'=>'ticketsStatus/index'),
                        array('title'=>__('Types'),'url'=>'ticketsTypes/index'),
                        array('title'=>__('Groups'),'url'=>'ticketsGroups/index'),
                        array('title'=>__('Priority'),'url'=>'ticketsPriority/index'),
                        array('title'=>__('Public Tickets'),'url'=>'configuration/index?type=public_tickets','is_hr'=>true),
                        array('title'=>__('Extra Fields'),'url'=>'extraFields/index?bind_type=tickets','is_hr'=>true),
                        array('title'=>__('Extra Fields per Type'),'url'=>'extraFields/extraFieldsByGroup?t=TicketsTypes'),
                      )),
                    array('title'=>__('Discussions'),
                      'url'=>'discussionsStatus/index',
                      'submenu'=>array(
                        array('title'=>__('Status'),'url'=>'discussionsStatus/index'),
                        array('title'=>__('Types'),'url'=>'discussionsTypes/index'),
                        array('title'=>__('Groups'),'url'=>'discussionsGroups/index'),
                        array('title'=>__('Priority'),'url'=>'discussionsPriority/index'),
                        array('title'=>__('Extra Fields'),'url'=>'extraFields/index?bind_type=discussions','is_hr'=>true),
                        array('title'=>__('Extra Fields per Type'),'url'=>'extraFields/extraFieldsByGroup?t=DiscussionsTypes'),
                      )),
                    array('title'=>__('Contacts'),
                      'url'=>'contactsGroups/index',
                      'submenu'=>array(
                        array('title'=>__('Groups'),'url'=>'contactsGroups/index'),
                        array('title'=>__('Extra Fields'),'url'=>'extraFields/index?bind_type=contacts'),
                      )),
                    array('title'=>__('Events in Scheduler'),
                      'url'=>'eventsPriority/index',
                      'submenu'=>array(
                        array('title'=>__('Priority'),'url'=>'eventsPriority/index'),
                        array('title'=>__('Types'),'url'=>'eventsTypes/index'),
                        array('title'=>__('Extra Fields'),'url'=>'extraFields/index?bind_type=events'),
                      )),
                      
                      
                    ($this->sf_user->getAttribute('users_group_id')!=0?   
                    array('title'=>__('Common Reports'),'url'=>'commonReports/index'):''),  
                 ));
  }
  
  
	public function buildToolsMenu()
	{
     return array('title'=>__('Tools'),
                 'class'=>'fa-wrench', 
                 'url'=>'tools/backup',
                 'submenu'=>array(                    
                    array('title'=>__('Backups'),'url'=>'tools/backup'),
                    array('title'=>__('Trash'),'url'=>'tools/trash'),   
                    array('title'=>__('Import Tasks from XLS file'),'url'=>'tools/xlsTasksImport'),
                    array('title'=>__('Import Tasks from MS Project'),'url'=>'tools/msProjectImport'),                                                                 
                   ));
  }
  
  public function buildMenu()
  {
    if(!$this->sf_user->isAuthenticated())
    {
      return $this->buildPublicMenu();
    }
    
    $m = array();
    
    if($this->sf_user->getAttribute('users_group_id')==0)
    {
      $m[] = $this->buildUsersMenu();
      $m[] = $this->buildConfigurationMenu();
      
      return $m;
    }
    
    $m[] = array('title'=>__('Dashboard'),'url'=>'dashboard/index','class'=>'fa-home');
	$m[] = array('title'=>__('Imputation'),'url'=>'http://localhost/extensions/qdpm/saisieheures.php','class'=>'fa-clock-o');
	
	
    
    if($this->access['projects']['view'] or $this->access['projects']['view_own']) 
    {
      $m[] = $this->buildProjectsMenu();
    }
    
    if($this->access['tasks']['view'] or $this->access['tasks']['view_own']) 
    {
      $m[] = $this->buildTasksMenu();
    }
    
    if($this->access['tickets']['view'] or $this->access['tickets']['view_own']) 
    {
      $m[] = $this->buildTicketsMenu();
    }
    
    if($this->access['discussions']['view'] or $this->access['discussions']['view_own']) 
    {
      $m[] = $this->buildDiscussionsMenu();
    }
    
    if($rm = $this->buildReportsMenu())
    {  
      $m[] = $rm;      
    }
    
   /* if(Users::hasAccess('view','publicWiki',$this->sf_user))
    {    
      $m[] = array('title'=>__('Wiki'),'url'=>'wiki/index','class'=>'fa-file-text-o');
    }*/
    
    if($this->sf_user->hasCredential('public_scheduler_access_full_access') or $this->sf_user->hasCredential('public_scheduler_access_view_only'))
    {
      $count = '';
     
      if(($count = Events::getCountTodaysEvents())>0)
      {
        $count =  $count ; 
      }
      else
      {
        $count = null;
      }
            
           
      $m[] = array('title'=>__('Scheduler'),'url'=>'scheduler/index','class'=>'fa-calendar','counts'=>$count);
    }
    
    if($this->sf_user->hasCredential('allow_manage_users')) $m[] = $this->buildUsersMenu();    
    if($this->sf_user->hasCredential('allow_manage_contacts')) $m[] = $this->buildContactsMenu();
    if($this->sf_user->hasCredential('allow_manage_configuration'))
    {
      $m[] = $this->buildConfigurationMenu();
      $m[] = $this->buildToolsMenu();
    }
                 
    return $m;
  }
  
  public function buildPublicMenu()
  {
    $m = array();
    $m[] = array('title'=>__('Login'),'url'=>'login/index');
    
    if(sfConfig::get('app_use_public_tickets')=='on')
    {
      $m[] = array('title'=>__('Submit Ticket'),'url'=>'publicTickets/index');
    }
    
    return $m;
  }
  
}
