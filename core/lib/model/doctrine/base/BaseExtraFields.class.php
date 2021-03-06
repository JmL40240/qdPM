<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('ExtraFields', 'doctrine');

/**
 * BaseExtraFields
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $extra_fields_tabs_id
 * @property string $name
 * @property string $bind_type
 * @property string $type
 * @property integer $sort_order
 * @property integer $active
 * @property integer $display_in_list
 * @property string $default_values
 * @property string $users_groups_access
 * @property string $view_only_access
 * @property integer $is_required
 * @property integer $use_in_search
 * @property ExtraFieldsTabs $ExtraFieldsTabs
 * @property Doctrine_Collection $ExtraFieldsList
 * 
 * @method integer             getId()                   Returns the current record's "id" value
 * @method integer             getExtraFieldsTabsId()    Returns the current record's "extra_fields_tabs_id" value
 * @method string              getName()                 Returns the current record's "name" value
 * @method string              getBindType()             Returns the current record's "bind_type" value
 * @method string              getType()                 Returns the current record's "type" value
 * @method integer             getSortOrder()            Returns the current record's "sort_order" value
 * @method integer             getActive()               Returns the current record's "active" value
 * @method integer             getDisplayInList()        Returns the current record's "display_in_list" value
 * @method string              getDefaultValues()        Returns the current record's "default_values" value
 * @method string              getUsersGroupsAccess()    Returns the current record's "users_groups_access" value
 * @method string              getViewOnlyAccess()       Returns the current record's "view_only_access" value
 * @method integer             getIsRequired()           Returns the current record's "is_required" value
 * @method integer             getUseInSearch()          Returns the current record's "use_in_search" value
 * @method ExtraFieldsTabs     getExtraFieldsTabs()      Returns the current record's "ExtraFieldsTabs" value
 * @method Doctrine_Collection getExtraFieldsList()      Returns the current record's "ExtraFieldsList" collection
 * @method ExtraFields         setId()                   Sets the current record's "id" value
 * @method ExtraFields         setExtraFieldsTabsId()    Sets the current record's "extra_fields_tabs_id" value
 * @method ExtraFields         setName()                 Sets the current record's "name" value
 * @method ExtraFields         setBindType()             Sets the current record's "bind_type" value
 * @method ExtraFields         setType()                 Sets the current record's "type" value
 * @method ExtraFields         setSortOrder()            Sets the current record's "sort_order" value
 * @method ExtraFields         setActive()               Sets the current record's "active" value
 * @method ExtraFields         setDisplayInList()        Sets the current record's "display_in_list" value
 * @method ExtraFields         setDefaultValues()        Sets the current record's "default_values" value
 * @method ExtraFields         setUsersGroupsAccess()    Sets the current record's "users_groups_access" value
 * @method ExtraFields         setViewOnlyAccess()       Sets the current record's "view_only_access" value
 * @method ExtraFields         setIsRequired()           Sets the current record's "is_required" value
 * @method ExtraFields         setUseInSearch()          Sets the current record's "use_in_search" value
 * @method ExtraFields         setExtraFieldsTabs()      Sets the current record's "ExtraFieldsTabs" value
 * @method ExtraFields         setExtraFieldsList()      Sets the current record's "ExtraFieldsList" collection
 * 
 * @package    sf_sandbox
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseExtraFields extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('extra_fields');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('extra_fields_tabs_id', 'integer', 4, array(
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
        $this->hasColumn('bind_type', 'string', 64, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'default' => '',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 64,
             ));
        $this->hasColumn('type', 'string', 64, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 64,
             ));
        $this->hasColumn('sort_order', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
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
        $this->hasColumn('display_in_list', 'integer', 1, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 1,
             ));
        $this->hasColumn('default_values', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('users_groups_access', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('view_only_access', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('is_required', 'integer', 1, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 1,
             ));
        $this->hasColumn('use_in_search', 'integer', 1, array(
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
        $this->hasOne('ExtraFieldsTabs', array(
             'local' => 'extra_fields_tabs_id',
             'foreign' => 'id'));

        $this->hasMany('ExtraFieldsList', array(
             'local' => 'id',
             'foreign' => 'extra_fields_id'));
    }
}