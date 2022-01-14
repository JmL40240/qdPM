<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('TasksToDiscussions', 'doctrine');

/**
 * BaseTasksToDiscussions
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $tasks_id
 * @property integer $discussions_id
 * @property Tasks $Tasks
 * @property Discussions $Discussions
 * @property Tasks $Tasks_3
 * 
 * @method integer            getId()             Returns the current record's "id" value
 * @method integer            getTasksId()        Returns the current record's "tasks_id" value
 * @method integer            getDiscussionsId()  Returns the current record's "discussions_id" value
 * @method Tasks              getTasks()          Returns the current record's "Tasks" value
 * @method Discussions        getDiscussions()    Returns the current record's "Discussions" value
 * @method Tasks              getTasks3()         Returns the current record's "Tasks_3" value
 * @method TasksToDiscussions setId()             Sets the current record's "id" value
 * @method TasksToDiscussions setTasksId()        Sets the current record's "tasks_id" value
 * @method TasksToDiscussions setDiscussionsId()  Sets the current record's "discussions_id" value
 * @method TasksToDiscussions setTasks()          Sets the current record's "Tasks" value
 * @method TasksToDiscussions setDiscussions()    Sets the current record's "Discussions" value
 * @method TasksToDiscussions setTasks3()         Sets the current record's "Tasks_3" value
 * 
 * @package    sf_sandbox
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseTasksToDiscussions extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('tasks_to_discussions');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('tasks_id', 'integer', 4, array(
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
        $this->hasOne('Tasks', array(
             'local' => 'tasks_id',
             'foreign' => 'id'));

        $this->hasOne('Discussions', array(
             'local' => 'discussions_id',
             'foreign' => 'id'));

        $this->hasOne('Tasks as Tasks_3', array(
             'local' => 'tasks_id',
             'foreign' => 'id'));
    }
}