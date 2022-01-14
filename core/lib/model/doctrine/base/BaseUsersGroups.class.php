<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('UsersGroups', 'doctrine');

/**
 * BaseUsersGroups
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property string $allow_manage_projects
 * @property string $allow_manage_tasks
 * @property string $allow_manage_tickets
 * @property integer $allow_manage_users
 * @property integer $allow_manage_configuration
 * @property string $allow_manage_discussions
 * @property string $extra_fields
 * @property integer $default_value
 * @property string $allow_manage_reports
 * @property string $allow_manage_public_scheduler
 * @property integer $allow_manage_personal_scheduler
 * @property integer $allow_manage_patterns
 * @property integer $allow_manage_contacts
 * @property string $allow_manage_public_wiki
 * @property string $allow_manage_projects_wiki
 * @property integer $ldap_default
 * @property string $projects_custom_access
 * @property string $projects_comments_access
 * @property string $tasks_custom_access
 * @property string $tasks_comments_access
 * @property string $tickets_custom_access
 * @property string $tickets_comments_access
 * @property string $discussions_custom_access
 * @property string $discussions_comments_access
 * @property string $group_type
 * @property Doctrine_Collection $ProjectsRoles
 * @property Doctrine_Collection $Users
 * 
 * @method integer             getId()                              Returns the current record's "id" value
 * @method string              getName()                            Returns the current record's "name" value
 * @method string              getAllowManageProjects()             Returns the current record's "allow_manage_projects" value
 * @method string              getAllowManageTasks()                Returns the current record's "allow_manage_tasks" value
 * @method string              getAllowManageTickets()              Returns the current record's "allow_manage_tickets" value
 * @method integer             getAllowManageUsers()                Returns the current record's "allow_manage_users" value
 * @method integer             getAllowManageConfiguration()        Returns the current record's "allow_manage_configuration" value
 * @method string              getAllowManageDiscussions()          Returns the current record's "allow_manage_discussions" value
 * @method string              getExtraFields()                     Returns the current record's "extra_fields" value
 * @method integer             getDefaultValue()                    Returns the current record's "default_value" value
 * @method string              getAllowManageReports()              Returns the current record's "allow_manage_reports" value
 * @method string              getAllowManagePublicScheduler()      Returns the current record's "allow_manage_public_scheduler" value
 * @method integer             getAllowManagePersonalScheduler()    Returns the current record's "allow_manage_personal_scheduler" value
 * @method integer             getAllowManagePatterns()             Returns the current record's "allow_manage_patterns" value
 * @method integer             getAllowManageContacts()             Returns the current record's "allow_manage_contacts" value
 * @method string              getAllowManagePublicWiki()           Returns the current record's "allow_manage_public_wiki" value
 * @method string              getAllowManageProjectsWiki()         Returns the current record's "allow_manage_projects_wiki" value
 * @method integer             getLdapDefault()                     Returns the current record's "ldap_default" value
 * @method string              getProjectsCustomAccess()            Returns the current record's "projects_custom_access" value
 * @method string              getProjectsCommentsAccess()          Returns the current record's "projects_comments_access" value
 * @method string              getTasksCustomAccess()               Returns the current record's "tasks_custom_access" value
 * @method string              getTasksCommentsAccess()             Returns the current record's "tasks_comments_access" value
 * @method string              getTicketsCustomAccess()             Returns the current record's "tickets_custom_access" value
 * @method string              getTicketsCommentsAccess()           Returns the current record's "tickets_comments_access" value
 * @method string              getDiscussionsCustomAccess()         Returns the current record's "discussions_custom_access" value
 * @method string              getDiscussionsCommentsAccess()       Returns the current record's "discussions_comments_access" value
 * @method string              getGroupType()                       Returns the current record's "group_type" value
 * @method Doctrine_Collection getProjectsRoles()                   Returns the current record's "ProjectsRoles" collection
 * @method Doctrine_Collection getUsers()                           Returns the current record's "Users" collection
 * @method UsersGroups         setId()                              Sets the current record's "id" value
 * @method UsersGroups         setName()                            Sets the current record's "name" value
 * @method UsersGroups         setAllowManageProjects()             Sets the current record's "allow_manage_projects" value
 * @method UsersGroups         setAllowManageTasks()                Sets the current record's "allow_manage_tasks" value
 * @method UsersGroups         setAllowManageTickets()              Sets the current record's "allow_manage_tickets" value
 * @method UsersGroups         setAllowManageUsers()                Sets the current record's "allow_manage_users" value
 * @method UsersGroups         setAllowManageConfiguration()        Sets the current record's "allow_manage_configuration" value
 * @method UsersGroups         setAllowManageDiscussions()          Sets the current record's "allow_manage_discussions" value
 * @method UsersGroups         setExtraFields()                     Sets the current record's "extra_fields" value
 * @method UsersGroups         setDefaultValue()                    Sets the current record's "default_value" value
 * @method UsersGroups         setAllowManageReports()              Sets the current record's "allow_manage_reports" value
 * @method UsersGroups         setAllowManagePublicScheduler()      Sets the current record's "allow_manage_public_scheduler" value
 * @method UsersGroups         setAllowManagePersonalScheduler()    Sets the current record's "allow_manage_personal_scheduler" value
 * @method UsersGroups         setAllowManagePatterns()             Sets the current record's "allow_manage_patterns" value
 * @method UsersGroups         setAllowManageContacts()             Sets the current record's "allow_manage_contacts" value
 * @method UsersGroups         setAllowManagePublicWiki()           Sets the current record's "allow_manage_public_wiki" value
 * @method UsersGroups         setAllowManageProjectsWiki()         Sets the current record's "allow_manage_projects_wiki" value
 * @method UsersGroups         setLdapDefault()                     Sets the current record's "ldap_default" value
 * @method UsersGroups         setProjectsCustomAccess()            Sets the current record's "projects_custom_access" value
 * @method UsersGroups         setProjectsCommentsAccess()          Sets the current record's "projects_comments_access" value
 * @method UsersGroups         setTasksCustomAccess()               Sets the current record's "tasks_custom_access" value
 * @method UsersGroups         setTasksCommentsAccess()             Sets the current record's "tasks_comments_access" value
 * @method UsersGroups         setTicketsCustomAccess()             Sets the current record's "tickets_custom_access" value
 * @method UsersGroups         setTicketsCommentsAccess()           Sets the current record's "tickets_comments_access" value
 * @method UsersGroups         setDiscussionsCustomAccess()         Sets the current record's "discussions_custom_access" value
 * @method UsersGroups         setDiscussionsCommentsAccess()       Sets the current record's "discussions_comments_access" value
 * @method UsersGroups         setGroupType()                       Sets the current record's "group_type" value
 * @method UsersGroups         setProjectsRoles()                   Sets the current record's "ProjectsRoles" collection
 * @method UsersGroups         setUsers()                           Sets the current record's "Users" collection
 * 
 * @package    sf_sandbox
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseUsersGroups extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('users_groups');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
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
        $this->hasColumn('allow_manage_projects', 'string', 64, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 64,
             ));
        $this->hasColumn('allow_manage_tasks', 'string', 64, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 64,
             ));
        $this->hasColumn('allow_manage_tickets', 'string', 64, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 64,
             ));
        $this->hasColumn('allow_manage_users', 'integer', 1, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 1,
             ));
        $this->hasColumn('allow_manage_configuration', 'integer', 1, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 1,
             ));
        $this->hasColumn('allow_manage_discussions', 'string', 64, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 64,
             ));
        $this->hasColumn('extra_fields', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('default_value', 'integer', 1, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 1,
             ));
        $this->hasColumn('allow_manage_reports', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('allow_manage_public_scheduler', 'string', 64, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 64,
             ));
        $this->hasColumn('allow_manage_personal_scheduler', 'integer', 1, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 1,
             ));
        $this->hasColumn('allow_manage_patterns', 'integer', 1, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 1,
             ));
        $this->hasColumn('allow_manage_contacts', 'integer', 1, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 1,
             ));
        $this->hasColumn('allow_manage_public_wiki', 'string', 64, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 64,
             ));
        $this->hasColumn('allow_manage_projects_wiki', 'string', 64, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 64,
             ));
        $this->hasColumn('ldap_default', 'integer', 1, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 1,
             ));
        $this->hasColumn('projects_custom_access', 'string', 64, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 64,
             ));
        $this->hasColumn('projects_comments_access', 'string', 64, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 64,
             ));
        $this->hasColumn('tasks_custom_access', 'string', 64, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 64,
             ));
        $this->hasColumn('tasks_comments_access', 'string', 64, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 64,
             ));
        $this->hasColumn('tickets_custom_access', 'string', 64, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 64,
             ));
        $this->hasColumn('tickets_comments_access', 'string', 64, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 64,
             ));
        $this->hasColumn('discussions_custom_access', 'string', 64, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 64,
             ));
        $this->hasColumn('discussions_comments_access', 'string', 64, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 64,
             ));
        $this->hasColumn('group_type', 'string', 16, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 16,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('ProjectsRoles', array(
             'local' => 'id',
             'foreign' => 'users_groups_id'));

        $this->hasMany('Users', array(
             'local' => 'id',
             'foreign' => 'users_group_id'));
    }
}