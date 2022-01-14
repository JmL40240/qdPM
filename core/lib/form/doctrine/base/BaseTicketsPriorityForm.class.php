<?php

/**
 * TicketsPriority form base class.
 *
 * @method TicketsPriority getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseTicketsPriorityForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'name'          => new sfWidgetFormInputText(),
      'icon'          => new sfWidgetFormInputText(),
      'sort_order'    => new sfWidgetFormInputText(),
      'default_value' => new sfWidgetFormInputText(),
      'active'        => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'icon'          => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'sort_order'    => new sfValidatorInteger(array('required' => false)),
      'default_value' => new sfValidatorInteger(array('required' => false)),
      'active'        => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('tickets_priority[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'TicketsPriority';
  }

}
