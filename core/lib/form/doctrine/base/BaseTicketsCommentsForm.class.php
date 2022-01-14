<?php

/**
 * TicketsComments form base class.
 *
 * @method TicketsComments getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseTicketsCommentsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'description'         => new sfWidgetFormTextarea(),
      'created_at'          => new sfWidgetFormDateTime(),
      'tickets_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Tickets'), 'add_empty' => false)),
      'users_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Users'), 'add_empty' => true)),
      'tickets_status_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TicketsStatus'), 'add_empty' => true)),
      'user_name'           => new sfWidgetFormInputText(),
      'user_email'          => new sfWidgetFormInputText(),
      'message_id'          => new sfWidgetFormInputText(),
      'in_trash'            => new sfWidgetFormInputText(),
      'in_trash_date'       => new sfWidgetFormInputText(),
      'tickets_groups_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TicketsGroups'), 'add_empty' => true)),
      'tickets_priority_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TicketsPriority'), 'add_empty' => true)),
      'tickets_types_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TicketsTypes'), 'add_empty' => true)),
      'departments_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Departments'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'description'         => new sfValidatorString(array('required' => false)),
      'created_at'          => new sfValidatorDateTime(array('required' => false)),
      'tickets_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Tickets'), 'required' => false)),
      'users_id'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Users'), 'required' => false)),
      'tickets_status_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TicketsStatus'), 'required' => false)),
      'user_name'           => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'user_email'          => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'message_id'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'in_trash'            => new sfValidatorInteger(array('required' => false)),
      'in_trash_date'       => new sfValidatorInteger(array('required' => false)),
      'tickets_groups_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TicketsGroups'), 'required' => false)),
      'tickets_priority_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TicketsPriority'), 'required' => false)),
      'tickets_types_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TicketsTypes'), 'required' => false)),
      'departments_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Departments'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('tickets_comments[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'TicketsComments';
  }

}
