<?php

/**
 * Contacts form base class.
 *
 * @method Contacts getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseContactsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'name'               => new sfWidgetFormInputText(),
      'email'              => new sfWidgetFormInputText(),
      'contacts_groups_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ContactsGroups'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'               => new sfValidatorString(array('max_length' => 255)),
      'email'              => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'contacts_groups_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ContactsGroups'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('contacts[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Contacts';
  }

}
