<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('TicketsToDiscussions', 'doctrine');

/**
 * BaseTicketsToDiscussions
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $tickets_id
 * @property integer $discussions_id
 * @property Discussions $Discussions
 * 
 * @method integer              getId()             Returns the current record's "id" value
 * @method integer              getTicketsId()      Returns the current record's "tickets_id" value
 * @method integer              getDiscussionsId()  Returns the current record's "discussions_id" value
 * @method Discussions          getDiscussions()    Returns the current record's "Discussions" value
 * @method TicketsToDiscussions setId()             Sets the current record's "id" value
 * @method TicketsToDiscussions setTicketsId()      Sets the current record's "tickets_id" value
 * @method TicketsToDiscussions setDiscussionsId()  Sets the current record's "discussions_id" value
 * @method TicketsToDiscussions setDiscussions()    Sets the current record's "Discussions" value
 * 
 * @package    sf_sandbox
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseTicketsToDiscussions extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('tickets_to_discussions');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('tickets_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('discussions_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Discussions', array(
             'local' => 'discussions_id',
             'foreign' => 'id'));
    }
}