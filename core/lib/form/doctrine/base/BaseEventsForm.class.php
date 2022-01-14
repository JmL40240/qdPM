<?php

/**
 * Events form base class.
 *
 * @method Events getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseEventsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'event_name'         => new sfWidgetFormTextarea(),
      'start_date'         => new sfWidgetFormDateTime(),
      'end_date'           => new sfWidgetFormDateTime(),
      'description'        => new sfWidgetFormTextarea(),
      'users_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Users'), 'add_empty' => true)),
      'events_priority_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('EventsPriority'), 'add_empty' => true)),
      'events_types_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('EventsTypes'), 'add_empty' => true)),
      'public_status'      => new sfWidgetFormInputText(),
      'repeat_type'        => new sfWidgetFormInputText(),
      'repeat_interval'    => new sfWidgetFormInputText(),
      'repeat_days'        => new sfWidgetFormInputText(),
      'repeat_end'         => new sfWidgetFormDate(),
      'repeat_limit'       => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'event_name'         => new sfValidatorString(),
      'start_date'         => new sfValidatorDateTime(),
      'end_date'           => new sfValidatorDateTime(),
      'description'        => new sfValidatorString(array('required' => false)),
      'users_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Users'), 'required' => false)),
      'events_priority_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('EventsPriority'), 'required' => false)),
      'events_types_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('EventsTypes'), 'required' => false)),
      'public_status'      => new sfValidatorInteger(array('required' => false)),
      'repeat_type'        => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'repeat_interval'    => new sfValidatorInteger(array('required' => false)),
      'repeat_days'        => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'repeat_end'         => new sfValidatorDate(array('required' => false)),
      'repeat_limit'       => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('events[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Events';
  }

}
