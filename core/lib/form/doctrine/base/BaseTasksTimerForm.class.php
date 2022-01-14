<?php

/**
 * TasksTimer form base class.
 *
 * @method TasksTimer getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseTasksTimerForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'       => new sfWidgetFormInputHidden(),
      'tasks_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Tasks'), 'add_empty' => false)),
      'users_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Users'), 'add_empty' => false)),
      'seconds'  => new sfWidgetFormInputText(),
      'visible'  => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'       => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'tasks_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Tasks'))),
      'users_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Users'))),
      'seconds'  => new sfValidatorInteger(array('required' => false)),
      'visible'  => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('tasks_timer[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'TasksTimer';
  }

}
