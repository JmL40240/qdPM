<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Patterns', 'doctrine');

/**
 * BasePatterns
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $type
 * @property integer $users_id
 * @property Users $Users
 * 
 * @method integer  getId()          Returns the current record's "id" value
 * @method string   getName()        Returns the current record's "name" value
 * @method string   getDescription() Returns the current record's "description" value
 * @method string   getType()        Returns the current record's "type" value
 * @method integer  getUsersId()     Returns the current record's "users_id" value
 * @method Users    getUsers()       Returns the current record's "Users" value
 * @method Patterns setId()          Sets the current record's "id" value
 * @method Patterns setName()        Sets the current record's "name" value
 * @method Patterns setDescription() Sets the current record's "description" value
 * @method Patterns setType()        Sets the current record's "type" value
 * @method Patterns setUsersId()     Sets the current record's "users_id" value
 * @method Patterns setUsers()       Sets the current record's "Users" value
 * 
 * @package    sf_sandbox
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasePatterns extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('patterns');
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
        $this->hasColumn('description', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('type', 'string', 64, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 64,
             ));
        $this->hasColumn('users_id', 'integer', 4, array(
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
        $this->hasOne('Users', array(
             'local' => 'users_id',
             'foreign' => 'id'));
    }
}