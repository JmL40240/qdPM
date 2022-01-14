<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('TicketsTypes', 'doctrine');

/**
 * BaseTicketsTypes
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property integer $sort_order
 * @property string $active
 * @property string $extra_fields
 * @property string $background_color
 * @property integer $default_value
 * @property Doctrine_Collection $Tickets
 * @property Doctrine_Collection $TicketsComments
 * 
 * @method integer             getId()               Returns the current record's "id" value
 * @method string              getName()             Returns the current record's "name" value
 * @method integer             getSortOrder()        Returns the current record's "sort_order" value
 * @method string              getActive()           Returns the current record's "active" value
 * @method string              getExtraFields()      Returns the current record's "extra_fields" value
 * @method string              getBackgroundColor()  Returns the current record's "background_color" value
 * @method integer             getDefaultValue()     Returns the current record's "default_value" value
 * @method Doctrine_Collection getTickets()          Returns the current record's "Tickets" collection
 * @method Doctrine_Collection getTicketsComments()  Returns the current record's "TicketsComments" collection
 * @method TicketsTypes        setId()               Sets the current record's "id" value
 * @method TicketsTypes        setName()             Sets the current record's "name" value
 * @method TicketsTypes        setSortOrder()        Sets the current record's "sort_order" value
 * @method TicketsTypes        setActive()           Sets the current record's "active" value
 * @method TicketsTypes        setExtraFields()      Sets the current record's "extra_fields" value
 * @method TicketsTypes        setBackgroundColor()  Sets the current record's "background_color" value
 * @method TicketsTypes        setDefaultValue()     Sets the current record's "default_value" value
 * @method TicketsTypes        setTickets()          Sets the current record's "Tickets" collection
 * @method TicketsTypes        setTicketsComments()  Sets the current record's "TicketsComments" collection
 * 
 * @package    sf_sandbox
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseTicketsTypes extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('tickets_types');
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
             'notnull' => true,
             'autoincrement' => false,
             'length' => 255,
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
        $this->hasColumn('active', 'string', 1, array(
             'type' => 'string',
             'fixed' => 1,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 1,
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
        $this->hasColumn('background_color', 'string', 6, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 6,
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
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Tickets', array(
             'local' => 'id',
             'foreign' => 'tickets_types_id'));

        $this->hasMany('TicketsComments', array(
             'local' => 'id',
             'foreign' => 'tickets_types_id'));
    }
}