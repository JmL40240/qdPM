<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Users', 'doctrine');

/**
 * BaseUsers
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $users_group_id
 * @property string $name
 * @property string $photo
 * @property string $email
 * @property string $culture
 * @property string $password
 * @property integer $active
 * @property integer $public_scheduler_email_evens
 * @property integer $public_scheduler_evens_onhome
 * @property integer $personal_scheduler_email_evens
 * @property integer $personal_scheduler_evens_onhome
 * @property string $default_home_page
 * @property string $skin
 * @property string $hidden_common_reports
 * @property string $hidden_dashboard_reports
 * @property string $sorted_dashboard_reports
 * @property integer $public_scheduler_evens_onmenu
 * @property integer $personal_scheduler_evens_onmenu
 * @property UsersGroups $UsersGroups
 * @property Doctrine_Collection $Attachments
 * @property Doctrine_Collection $Departments
 * @property Doctrine_Collection $Discussions
 * @property Doctrine_Collection $DiscussionsComments
 * @property Doctrine_Collection $DiscussionsReports
 * @property Doctrine_Collection $Events
 * @property Doctrine_Collection $Patterns
 * @property Doctrine_Collection $Projects
 * @property Doctrine_Collection $ProjectsComments
 * @property Doctrine_Collection $ProjectsReports
 * @property Doctrine_Collection $ProjectsRoles
 * @property Doctrine_Collection $Tasks
 * @property Doctrine_Collection $TasksComments
 * @property Doctrine_Collection $TasksTimer
 * @property Doctrine_Collection $Tickets
 * @property Doctrine_Collection $TicketsComments
 * @property Doctrine_Collection $TicketsReports
 * @property Doctrine_Collection $UserReports
 * @property Doctrine_Collection $UsersListingsOrder
 * @property Doctrine_Collection $Wiki
 * @property Doctrine_Collection $WikiHistory
 * 
 * @method integer             getId()                              Returns the current record's "id" value
 * @method integer             getUsersGroupId()                    Returns the current record's "users_group_id" value
 * @method string              getName()                            Returns the current record's "name" value
 * @method string              getPhoto()                           Returns the current record's "photo" value
 * @method string              getEmail()                           Returns the current record's "email" value
 * @method string              getCulture()                         Returns the current record's "culture" value
 * @method string              getPassword()                        Returns the current record's "password" value
 * @method integer             getActive()                          Returns the current record's "active" value
 * @method integer             getPublicSchedulerEmailEvens()       Returns the current record's "public_scheduler_email_evens" value
 * @method integer             getPublicSchedulerEvensOnhome()      Returns the current record's "public_scheduler_evens_onhome" value
 * @method integer             getPersonalSchedulerEmailEvens()     Returns the current record's "personal_scheduler_email_evens" value
 * @method integer             getPersonalSchedulerEvensOnhome()    Returns the current record's "personal_scheduler_evens_onhome" value
 * @method string              getDefaultHomePage()                 Returns the current record's "default_home_page" value
 * @method string              getSkin()                            Returns the current record's "skin" value
 * @method string              getHiddenCommonReports()             Returns the current record's "hidden_common_reports" value
 * @method string              getHiddenDashboardReports()          Returns the current record's "hidden_dashboard_reports" value
 * @method string              getSortedDashboardReports()          Returns the current record's "sorted_dashboard_reports" value
 * @method integer             getPublicSchedulerEvensOnmenu()      Returns the current record's "public_scheduler_evens_onmenu" value
 * @method integer             getPersonalSchedulerEvensOnmenu()    Returns the current record's "personal_scheduler_evens_onmenu" value
 * @method UsersGroups         getUsersGroups()                     Returns the current record's "UsersGroups" value
 * @method Doctrine_Collection getAttachments()                     Returns the current record's "Attachments" collection
 * @method Doctrine_Collection getDepartments()                     Returns the current record's "Departments" collection
 * @method Doctrine_Collection getDiscussions()                     Returns the current record's "Discussions" collection
 * @method Doctrine_Collection getDiscussionsComments()             Returns the current record's "DiscussionsComments" collection
 * @method Doctrine_Collection getDiscussionsReports()              Returns the current record's "DiscussionsReports" collection
 * @method Doctrine_Collection getEvents()                          Returns the current record's "Events" collection
 * @method Doctrine_Collection getPatterns()                        Returns the current record's "Patterns" collection
 * @method Doctrine_Collection getProjects()                        Returns the current record's "Projects" collection
 * @method Doctrine_Collection getProjectsComments()                Returns the current record's "ProjectsComments" collection
 * @method Doctrine_Collection getProjectsReports()                 Returns the current record's "ProjectsReports" collection
 * @method Doctrine_Collection getProjectsRoles()                   Returns the current record's "ProjectsRoles" collection
 * @method Doctrine_Collection getTasks()                           Returns the current record's "Tasks" collection
 * @method Doctrine_Collection getTasksComments()                   Returns the current record's "TasksComments" collection
 * @method Doctrine_Collection getTasksTimer()                      Returns the current record's "TasksTimer" collection
 * @method Doctrine_Collection getTickets()                         Returns the current record's "Tickets" collection
 * @method Doctrine_Collection getTicketsComments()                 Returns the current record's "TicketsComments" collection
 * @method Doctrine_Collection getTicketsReports()                  Returns the current record's "TicketsReports" collection
 * @method Doctrine_Collection getUserReports()                     Returns the current record's "UserReports" collection
 * @method Doctrine_Collection getUsersListingsOrder()              Returns the current record's "UsersListingsOrder" collection
 * @method Doctrine_Collection getWiki()                            Returns the current record's "Wiki" collection
 * @method Doctrine_Collection getWikiHistory()                     Returns the current record's "WikiHistory" collection
 * @method Users               setId()                              Sets the current record's "id" value
 * @method Users               setUsersGroupId()                    Sets the current record's "users_group_id" value
 * @method Users               setName()                            Sets the current record's "name" value
 * @method Users               setPhoto()                           Sets the current record's "photo" value
 * @method Users               setEmail()                           Sets the current record's "email" value
 * @method Users               setCulture()                         Sets the current record's "culture" value
 * @method Users               setPassword()                        Sets the current record's "password" value
 * @method Users               setActive()                          Sets the current record's "active" value
 * @method Users               setPublicSchedulerEmailEvens()       Sets the current record's "public_scheduler_email_evens" value
 * @method Users               setPublicSchedulerEvensOnhome()      Sets the current record's "public_scheduler_evens_onhome" value
 * @method Users               setPersonalSchedulerEmailEvens()     Sets the current record's "personal_scheduler_email_evens" value
 * @method Users               setPersonalSchedulerEvensOnhome()    Sets the current record's "personal_scheduler_evens_onhome" value
 * @method Users               setDefaultHomePage()                 Sets the current record's "default_home_page" value
 * @method Users               setSkin()                            Sets the current record's "skin" value
 * @method Users               setHiddenCommonReports()             Sets the current record's "hidden_common_reports" value
 * @method Users               setHiddenDashboardReports()          Sets the current record's "hidden_dashboard_reports" value
 * @method Users               setSortedDashboardReports()          Sets the current record's "sorted_dashboard_reports" value
 * @method Users               setPublicSchedulerEvensOnmenu()      Sets the current record's "public_scheduler_evens_onmenu" value
 * @method Users               setPersonalSchedulerEvensOnmenu()    Sets the current record's "personal_scheduler_evens_onmenu" value
 * @method Users               setUsersGroups()                     Sets the current record's "UsersGroups" value
 * @method Users               setAttachments()                     Sets the current record's "Attachments" collection
 * @method Users               setDepartments()                     Sets the current record's "Departments" collection
 * @method Users               setDiscussions()                     Sets the current record's "Discussions" collection
 * @method Users               setDiscussionsComments()             Sets the current record's "DiscussionsComments" collection
 * @method Users               setDiscussionsReports()              Sets the current record's "DiscussionsReports" collection
 * @method Users               setEvents()                          Sets the current record's "Events" collection
 * @method Users               setPatterns()                        Sets the current record's "Patterns" collection
 * @method Users               setProjects()                        Sets the current record's "Projects" collection
 * @method Users               setProjectsComments()                Sets the current record's "ProjectsComments" collection
 * @method Users               setProjectsReports()                 Sets the current record's "ProjectsReports" collection
 * @method Users               setProjectsRoles()                   Sets the current record's "ProjectsRoles" collection
 * @method Users               setTasks()                           Sets the current record's "Tasks" collection
 * @method Users               setTasksComments()                   Sets the current record's "TasksComments" collection
 * @method Users               setTasksTimer()                      Sets the current record's "TasksTimer" collection
 * @method Users               setTickets()                         Sets the current record's "Tickets" collection
 * @method Users               setTicketsComments()                 Sets the current record's "TicketsComments" collection
 * @method Users               setTicketsReports()                  Sets the current record's "TicketsReports" collection
 * @method Users               setUserReports()                     Sets the current record's "UserReports" collection
 * @method Users               setUsersListingsOrder()              Sets the current record's "UsersListingsOrder" collection
 * @method Users               setWiki()                            Sets the current record's "Wiki" collection
 * @method Users               setWikiHistory()                     Sets the current record's "WikiHistory" collection
 * 
 * @package    sf_sandbox
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseUsers extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('users');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('users_group_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'default' => '',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('photo', 'string', 64, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 64,
             ));
        $this->hasColumn('email', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'default' => '',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('culture', 'string', 5, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 5,
             ));
        $this->hasColumn('password', 'string', 64, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'default' => '',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 64,
             ));
        $this->hasColumn('active', 'integer', 1, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 1,
             ));
        $this->hasColumn('public_scheduler_email_evens', 'integer', 1, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 1,
             ));
        $this->hasColumn('public_scheduler_evens_onhome', 'integer', 1, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 1,
             ));
        $this->hasColumn('personal_scheduler_email_evens', 'integer', 1, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 1,
             ));
        $this->hasColumn('personal_scheduler_evens_onhome', 'integer', 1, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 1,
             ));
        $this->hasColumn('default_home_page', 'string', 64, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 64,
             ));
        $this->hasColumn('skin', 'string', 64, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 64,
             ));
        $this->hasColumn('hidden_common_reports', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('hidden_dashboard_reports', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('sorted_dashboard_reports', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('public_scheduler_evens_onmenu', 'integer', 1, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 1,
             ));
        $this->hasColumn('personal_scheduler_evens_onmenu', 'integer', 1, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 1,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('UsersGroups', array(
             'local' => 'users_group_id',
             'foreign' => 'id'));

        $this->hasMany('Attachments', array(
             'local' => 'id',
             'foreign' => 'users_id'));

        $this->hasMany('Departments', array(
             'local' => 'id',
             'foreign' => 'users_id'));

        $this->hasMany('Discussions', array(
             'local' => 'id',
             'foreign' => 'users_id'));

        $this->hasMany('DiscussionsComments', array(
             'local' => 'id',
             'foreign' => 'users_id'));

        $this->hasMany('DiscussionsReports', array(
             'local' => 'id',
             'foreign' => 'users_id'));

        $this->hasMany('Events', array(
             'local' => 'id',
             'foreign' => 'users_id'));

        $this->hasMany('Patterns', array(
             'local' => 'id',
             'foreign' => 'users_id'));

        $this->hasMany('Projects', array(
             'local' => 'id',
             'foreign' => 'created_by'));

        $this->hasMany('ProjectsComments', array(
             'local' => 'id',
             'foreign' => 'created_by'));

        $this->hasMany('ProjectsReports', array(
             'local' => 'id',
             'foreign' => 'users_id'));

        $this->hasMany('ProjectsRoles', array(
             'local' => 'id',
             'foreign' => 'users_id'));

        $this->hasMany('Tasks', array(
             'local' => 'id',
             'foreign' => 'created_by'));

        $this->hasMany('TasksComments', array(
             'local' => 'id',
             'foreign' => 'created_by'));

        $this->hasMany('TasksTimer', array(
             'local' => 'id',
             'foreign' => 'users_id'));

        $this->hasMany('Tickets', array(
             'local' => 'id',
             'foreign' => 'users_id'));

        $this->hasMany('TicketsComments', array(
             'local' => 'id',
             'foreign' => 'users_id'));

        $this->hasMany('TicketsReports', array(
             'local' => 'id',
             'foreign' => 'users_id'));

        $this->hasMany('UserReports', array(
             'local' => 'id',
             'foreign' => 'users_id'));

        $this->hasMany('UsersListingsOrder', array(
             'local' => 'id',
             'foreign' => 'users_id'));

        $this->hasMany('Wiki', array(
             'local' => 'id',
             'foreign' => 'users_id'));

        $this->hasMany('WikiHistory', array(
             'local' => 'id',
             'foreign' => 'users_id'));
    }
}