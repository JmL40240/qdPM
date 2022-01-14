<?php

/**
 * UsersListingsOrder form base class.
 *
 * @method UsersListingsOrder getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseUsersListingsOrderForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'module'          => new sfWidgetFormInputText(),
      'order_type'      => new sfWidgetFormInputText(),
      'users_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Users'), 'add_empty' => false)),
      'projects_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Projects'), 'add_empty' => true)),
      'collapsed_tasks' => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'module'          => new sfValidatorString(array('max_length' => 64)),
      'order_type'      => new sfValidatorString(array('max_length' => 64)),
      'users_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Users'))),
      'projects_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Projects'), 'required' => false)),
      'collapsed_tasks' => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('users_listings_order[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'UsersListingsOrder';
  }

}
