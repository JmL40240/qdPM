<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('TicketsPriority', 'doctrine');

/**
 * BaseTicketsPriority
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property string $icon
 * @property integer $sort_order
 * @property integer $default_value
 * @property integer $active
 * @property Doctrine_Collection $Tickets
 * @property Doctrine_Collection $TicketsComments
 * 
 * @method integer             getId()              Returns the current record's "id" value
 * @method string              getName()            Returns the current record's "name" value
 * @method string              getIcon()            Returns the current record's "icon" value
 * @method integer             getSortOrder()       Returns the current record's "sort_order" value
 * @method integer             getDefaultValue()    Returns the current record's "default_value" value
 * @method integer             getActive()          Returns the current record's "active" value
 * @method Doctrine_Collection getTickets()         Returns the current record's "Tickets" collection
 * @method Doctrine_Collection getTicketsComments() Returns the current record's "TicketsComments" collection
 * @method TicketsPriority     setId()              Sets the current record's "id" value
 * @method TicketsPriority     setName()            Sets the current record's "name" value
 * @method TicketsPriority     setIcon()            Sets the current record's "icon" value
 * @method TicketsPriority     setSortOrder()       Sets the current record's "sort_order" value
 * @method TicketsPriority     setDefaultValue()    Sets the current record's "default_value" value
 * @method TicketsPriority     setActive()          Sets the current record's "active" value
 * @method TicketsPriority     setTickets()         Sets the current record's "Tickets" collection
 * @method TicketsPriority     setTicketsComments() Sets the current record's "TicketsComments" collection
 * 
 * @package    sf_sandbox
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseTicketsPriority extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('tickets_priority');
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
        $this->hasColumn('icon', 'string', 64, array(
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
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
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
        $this->hasColumn('active', 'integer', 1, array(
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
             'foreign' => 'tickets_priority_id'));

        $this->hasMany('TicketsComments', array(
             'local' => 'id',
             'foreign' => 'tickets_priority_id'));
    }
}