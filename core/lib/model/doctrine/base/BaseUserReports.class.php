<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('UserReports', 'doctrine');

/**
 * BaseUserReports
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $users_id
 * @property string $name
 * @property integer $display_on_home
 * @property string $projects_id
 * @property string $projects_type_id
 * @property string $projects_status_id
 * @property string $assigned_to
 * @property string $created_by
 * @property string $tasks_status_id
 * @property string $tasks_type_id
 * @property string $tasks_label_id
 * @property date $due_date_from
 * @property date $due_date_to
 * @property date $created_from
 * @property date $created_to
 * @property date $closed_from
 * @property date $closed_to
 * @property integer $sort_order
 * @property integer $days_before_due_date
 * @property integer $has_related_ticket
 * @property integer $has_estimated_time
 * @property string $report_reminder
 * @property integer $display_in_menu
 * @property integer $visible_on_home
 * @property integer $overdue_tasks
 * @property string $projects_groups_id
 * @property string $report_type
 * @property string $extra_fields
 * @property string $listing_order
 * @property integer $is_default
 * @property string $tasks_priority_id
 * @property string $projects_priority_id
 * @property string $tasks_groups_id
 * @property string $versions_id
 * @property string $projects_phases_id
 * @property string $users_groups_id
 * @property integer $display_only_assigned
 * @property integer $is_mandatory
 * @property Users $Users
 * 
 * @method integer     getId()                    Returns the current record's "id" value
 * @method integer     getUsersId()               Returns the current record's "users_id" value
 * @method string      getName()                  Returns the current record's "name" value
 * @method integer     getDisplayOnHome()         Returns the current record's "display_on_home" value
 * @method string      getProjectsId()            Returns the current record's "projects_id" value
 * @method string      getProjectsTypeId()        Returns the current record's "projects_type_id" value
 * @method string      getProjectsStatusId()      Returns the current record's "projects_status_id" value
 * @method string      getAssignedTo()            Returns the current record's "assigned_to" value
 * @method string      getCreatedBy()             Returns the current record's "created_by" value
 * @method string      getTasksStatusId()         Returns the current record's "tasks_status_id" value
 * @method string      getTasksTypeId()           Returns the current record's "tasks_type_id" value
 * @method string      getTasksLabelId()          Returns the current record's "tasks_label_id" value
 * @method date        getDueDateFrom()           Returns the current record's "due_date_from" value
 * @method date        getDueDateTo()             Returns the current record's "due_date_to" value
 * @method date        getCreatedFrom()           Returns the current record's "created_from" value
 * @method date        getCreatedTo()             Returns the current record's "created_to" value
 * @method date        getClosedFrom()            Returns the current record's "closed_from" value
 * @method date        getClosedTo()              Returns the current record's "closed_to" value
 * @method integer     getSortOrder()             Returns the current record's "sort_order" value
 * @method integer     getDaysBeforeDueDate()     Returns the current record's "days_before_due_date" value
 * @method integer     getHasRelatedTicket()      Returns the current record's "has_related_ticket" value
 * @method integer     getHasEstimatedTime()      Returns the current record's "has_estimated_time" value
 * @method string      getReportReminder()        Returns the current record's "report_reminder" value
 * @method integer     getDisplayInMenu()         Returns the current record's "display_in_menu" value
 * @method integer     getVisibleOnHome()         Returns the current record's "visible_on_home" value
 * @method integer     getOverdueTasks()          Returns the current record's "overdue_tasks" value
 * @method string      getProjectsGroupsId()      Returns the current record's "projects_groups_id" value
 * @method string      getReportType()            Returns the current record's "report_type" value
 * @method string      getExtraFields()           Returns the current record's "extra_fields" value
 * @method string      getListingOrder()          Returns the current record's "listing_order" value
 * @method integer     getIsDefault()             Returns the current record's "is_default" value
 * @method string      getTasksPriorityId()       Returns the current record's "tasks_priority_id" value
 * @method string      getProjectsPriorityId()    Returns the current record's "projects_priority_id" value
 * @method string      getTasksGroupsId()         Returns the current record's "tasks_groups_id" value
 * @method string      getVersionsId()            Returns the current record's "versions_id" value
 * @method string      getProjectsPhasesId()      Returns the current record's "projects_phases_id" value
 * @method string      getUsersGroupsId()         Returns the current record's "users_groups_id" value
 * @method integer     getDisplayOnlyAssigned()   Returns the current record's "display_only_assigned" value
 * @method integer     getIsMandatory()           Returns the current record's "is_mandatory" value
 * @method Users       getUsers()                 Returns the current record's "Users" value
 * @method UserReports setId()                    Sets the current record's "id" value
 * @method UserReports setUsersId()               Sets the current record's "users_id" value
 * @method UserReports setName()                  Sets the current record's "name" value
 * @method UserReports setDisplayOnHome()         Sets the current record's "display_on_home" value
 * @method UserReports setProjectsId()            Sets the current record's "projects_id" value
 * @method UserReports setProjectsTypeId()        Sets the current record's "projects_type_id" value
 * @method UserReports setProjectsStatusId()      Sets the current record's "projects_status_id" value
 * @method UserReports setAssignedTo()            Sets the current record's "assigned_to" value
 * @method UserReports setCreatedBy()             Sets the current record's "created_by" value
 * @method UserReports setTasksStatusId()         Sets the current record's "tasks_status_id" value
 * @method UserReports setTasksTypeId()           Sets the current record's "tasks_type_id" value
 * @method UserReports setTasksLabelId()          Sets the current record's "tasks_label_id" value
 * @method UserReports setDueDateFrom()           Sets the current record's "due_date_from" value
 * @method UserReports setDueDateTo()             Sets the current record's "due_date_to" value
 * @method UserReports setCreatedFrom()           Sets the current record's "created_from" value
 * @method UserReports setCreatedTo()             Sets the current record's "created_to" value
 * @method UserReports setClosedFrom()            Sets the current record's "closed_from" value
 * @method UserReports setClosedTo()              Sets the current record's "closed_to" value
 * @method UserReports setSortOrder()             Sets the current record's "sort_order" value
 * @method UserReports setDaysBeforeDueDate()     Sets the current record's "days_before_due_date" value
 * @method UserReports setHasRelatedTicket()      Sets the current record's "has_related_ticket" value
 * @method UserReports setHasEstimatedTime()      Sets the current record's "has_estimated_time" value
 * @method UserReports setReportReminder()        Sets the current record's "report_reminder" value
 * @method UserReports setDisplayInMenu()         Sets the current record's "display_in_menu" value
 * @method UserReports setVisibleOnHome()         Sets the current record's "visible_on_home" value
 * @method UserReports setOverdueTasks()          Sets the current record's "overdue_tasks" value
 * @method UserReports setProjectsGroupsId()      Sets the current record's "projects_groups_id" value
 * @method UserReports setReportType()            Sets the current record's "report_type" value
 * @method UserReports setExtraFields()           Sets the current record's "extra_fields" value
 * @method UserReports setListingOrder()          Sets the current record's "listing_order" value
 * @method UserReports setIsDefault()             Sets the current record's "is_default" value
 * @method UserReports setTasksPriorityId()       Sets the current record's "tasks_priority_id" value
 * @method UserReports setProjectsPriorityId()    Sets the current record's "projects_priority_id" value
 * @method UserReports setTasksGroupsId()         Sets the current record's "tasks_groups_id" value
 * @method UserReports setVersionsId()            Sets the current record's "versions_id" value
 * @method UserReports setProjectsPhasesId()      Sets the current record's "projects_phases_id" value
 * @method UserReports setUsersGroupsId()         Sets the current record's "users_groups_id" value
 * @method UserReports setDisplayOnlyAssigned()   Sets the current record's "display_only_assigned" value
 * @method UserReports setIsMandatory()           Sets the current record's "is_mandatory" value
 * @method UserReports setUsers()                 Sets the current record's "Users" value
 * 
 * @package    sf_sandbox
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseUserReports extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('user_reports');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('users_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
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
        $this->hasColumn('display_on_home', 'integer', 1, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 1,
             ));
        $this->hasColumn('projects_id', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('projects_type_id', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('projects_status_id', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('assigned_to', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('created_by', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('tasks_status_id', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('tasks_type_id', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('tasks_label_id', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('due_date_from', 'date', 25, array(
             'type' => 'date',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 25,
             ));
        $this->hasColumn('due_date_to', 'date', 25, array(
             'type' => 'date',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 25,
             ));
        $this->hasColumn('created_from', 'date', 25, array(
             'type' => 'date',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 25,
             ));
        $this->hasColumn('created_to', 'date', 25, array(
             'type' => 'date',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 25,
             ));
        $this->hasColumn('closed_from', 'date', 25, array(
             'type' => 'date',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 25,
             ));
        $this->hasColumn('closed_to', 'date', 25, array(
             'type' => 'date',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 25,
             ));
        $this->hasColumn('sort_order', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('days_before_due_date', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('has_related_ticket', 'integer', 1, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 1,
             ));
        $this->hasColumn('has_estimated_time', 'integer', 1, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 1,
             ));
        $this->hasColumn('report_reminder', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('display_in_menu', 'integer', 1, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 1,
             ));
        $this->hasColumn('visible_on_home', 'integer', 1, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 1,
             ));
        $this->hasColumn('overdue_tasks', 'integer', 1, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 1,
             ));
        $this->hasColumn('projects_groups_id', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('report_type', 'string', 64, array(
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
        $this->hasColumn('listing_order', 'string', 64, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 64,
             ));
        $this->hasColumn('is_default', 'integer', 1, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 1,
             ));
        $this->hasColumn('tasks_priority_id', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('projects_priority_id', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('tasks_groups_id', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('versions_id', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('projects_phases_id', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('users_groups_id', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('display_only_assigned', 'integer', 1, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 1,
             ));
        $this->hasColumn('is_mandatory', 'integer', 1, array(
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
        $this->hasOne('Users', array(
             'local' => 'users_id',
             'foreign' => 'id'));
    }
}