<?php

/**
 * TicketsTypes form base class.
 *
 * @method TicketsTypes getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseTicketsTypesForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'name'             => new sfWidgetFormInputText(),
      'sort_order'       => new sfWidgetFormInputText(),
      'active'           => new sfWidgetFormInputText(),
      'extra_fields'     => new sfWidgetFormTextarea(),
      'background_color' => new sfWidgetFormInputText(),
      'default_value'    => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'             => new sfValidatorString(array('max_length' => 255)),
      'sort_order'       => new sfValidatorInteger(array('required' => false)),
      'active'           => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'extra_fields'     => new sfValidatorString(array('required' => false)),
      'background_color' => new sfValidatorString(array('max_length' => 6, 'required' => false)),
      'default_value'    => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('tickets_types[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'TicketsTypes';
  }

}
