<?php

/**
 * TasksToDiscussions form base class.
 *
 * @method TasksToDiscussions getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseTasksToDiscussionsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'tasks_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Tasks'), 'add_empty' => false)),
      'discussions_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Discussions'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'tasks_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Tasks'))),
      'discussions_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Discussions'))),
    ));

    $this->widgetSchema->setNameFormat('tasks_to_discussions[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'TasksToDiscussions';
  }

}
