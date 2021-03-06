<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('DiscussionsReports', 'doctrine');

/**
 * BaseDiscussionsReports
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
 * @property string $discussions_status_id
 * @property string $discussions_priority_id
 * @property string $projects_priority_id
 * @property integer $sort_order
 * @property integer $display_in_menu
 * @property integer $visible_on_home
 * @property string $projects_groups_id
 * @property string $discussions_types_id
 * @property string $discussions_groups_id
 * @property string $created_by
 * @property string $assigned_to
 * @property string $report_type
 * @property string $extra_fields
 * @property string $listing_order
 * @property integer $is_default
 * @property string $users_groups_id
 * @property integer $display_only_assigned
 * @property integer $is_mandatory
 * @property date $created_from
 * @property date $created_to
 * @property Users $Users
 * 
 * @method integer            getId()                      Returns the current record's "id" value
 * @method integer            getUsersId()                 Returns the current record's "users_id" value
 * @method string             getName()                    Returns the current record's "name" value
 * @method integer            getDisplayOnHome()           Returns the current record's "display_on_home" value
 * @method string             getProjectsId()              Returns the current record's "projects_id" value
 * @method string             getProjectsTypeId()          Returns the current record's "projects_type_id" value
 * @method string             getProjectsStatusId()        Returns the current record's "projects_status_id" value
 * @method string             getDiscussionsStatusId()     Returns the current record's "discussions_status_id" value
 * @method string             getDiscussionsPriorityId()   Returns the current record's "discussions_priority_id" value
 * @method string             getProjectsPriorityId()      Returns the current record's "projects_priority_id" value
 * @method integer            getSortOrder()               Returns the current record's "sort_order" value
 * @method integer            getDisplayInMenu()           Returns the current record's "display_in_menu" value
 * @method integer            getVisibleOnHome()           Returns the current record's "visible_on_home" value
 * @method string             getProjectsGroupsId()        Returns the current record's "projects_groups_id" value
 * @method string             getDiscussionsTypesId()      Returns the current record's "discussions_types_id" value
 * @method string             getDiscussionsGroupsId()     Returns the current record's "discussions_groups_id" value
 * @method string             getCreatedBy()               Returns the current record's "created_by" value
 * @method string             getAssignedTo()              Returns the current record's "assigned_to" value
 * @method string             getReportType()              Returns the current record's "report_type" value
 * @method string             getExtraFields()             Returns the current record's "extra_fields" value
 * @method string             getListingOrder()            Returns the current record's "listing_order" value
 * @method integer            getIsDefault()               Returns the current record's "is_default" value
 * @method string             getUsersGroupsId()           Returns the current record's "users_groups_id" value
 * @method integer            getDisplayOnlyAssigned()     Returns the current record's "display_only_assigned" value
 * @method integer            getIsMandatory()             Returns the current record's "is_mandatory" value
 * @method date               getCreatedFrom()             Returns the current record's "created_from" value
 * @method date               getCreatedTo()               Returns the current record's "created_to" value
 * @method Users              getUsers()                   Returns the current record's "Users" value
 * @method DiscussionsReports setId()                      Sets the current record's "id" value
 * @method DiscussionsReports setUsersId()                 Sets the current record's "users_id" value
 * @method DiscussionsReports setName()                    Sets the current record's "name" value
 * @method DiscussionsReports setDisplayOnHome()           Sets the current record's "display_on_home" value
 * @method DiscussionsReports setProjectsId()              Sets the current record's "projects_id" value
 * @method DiscussionsReports setProjectsTypeId()          Sets the current record's "projects_type_id" value
 * @method DiscussionsReports setProjectsStatusId()        Sets the current record's "projects_status_id" value
 * @method DiscussionsReports setDiscussionsStatusId()     Sets the current record's "discussions_status_id" value
 * @method DiscussionsReports setDiscussionsPriorityId()   Sets the current record's "discussions_priority_id" value
 * @method DiscussionsReports setProjectsPriorityId()      Sets the current record's "projects_priority_id" value
 * @method DiscussionsReports setSortOrder()               Sets the current record's "sort_order" value
 * @method DiscussionsReports setDisplayInMenu()           Sets the current record's "display_in_menu" value
 * @method DiscussionsReports setVisibleOnHome()           Sets the current record's "visible_on_home" value
 * @method DiscussionsReports setProjectsGroupsId()        Sets the current record's "projects_groups_id" value
 * @method DiscussionsReports setDiscussionsTypesId()      Sets the current record's "discussions_types_id" value
 * @method DiscussionsReports setDiscussionsGroupsId()     Sets the current record's "discussions_groups_id" value
 * @method DiscussionsReports setCreatedBy()               Sets the current record's "created_by" value
 * @method DiscussionsReports setAssignedTo()              Sets the current record's "assigned_to" value
 * @method DiscussionsReports setReportType()              Sets the current record's "report_type" value
 * @method DiscussionsReports setExtraFields()             Sets the current record's "extra_fields" value
 * @method DiscussionsReports setListingOrder()            Sets the current record's "listing_order" value
 * @method DiscussionsReports setIsDefault()               Sets the current record's "is_default" value
 * @method DiscussionsReports setUsersGroupsId()           Sets the current record's "users_groups_id" value
 * @method DiscussionsReports setDisplayOnlyAssigned()     Sets the current record's "display_only_assigned" value
 * @method DiscussionsReports setIsMandatory()             Sets the current record's "is_mandatory" value
 * @method DiscussionsReports setCreatedFrom()             Sets the current record's "created_from" value
 * @method DiscussionsReports setCreatedTo()               Sets the current record's "created_to" value
 * @method DiscussionsReports setUsers()                   Sets the current record's "Users" value
 * 
 * @package    sf_sandbox
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseDiscussionsReports extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('discussions_reports');
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
        $this->hasColumn('discussions_status_id', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('discussions_priority_id', 'string', null, array(
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
        $this->hasColumn('sort_order', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
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
        $this->hasColumn('projects_groups_id', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('discussions_types_id', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('discussions_groups_id', 'string', null, array(
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
        $this->hasColumn('assigned_to', 'string', null, array(
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
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Users', array(
             'local' => 'users_id',
             'foreign' => 'id'));
    }
}