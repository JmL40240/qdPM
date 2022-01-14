<?php

/**
 * Users form base class.
 *
 * @method Users getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseUsersForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                              => new sfWidgetFormInputHidden(),
      'users_group_id'                  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UsersGroups'), 'add_empty' => true)),
      'name'                            => new sfWidgetFormInputText(),
      'photo'                           => new sfWidgetFormInputText(),
      'email'                           => new sfWidgetFormInputText(),
      'culture'                         => new sfWidgetFormInputText(),
      'password'                        => new sfWidgetFormInputText(),
      'active'                          => new sfWidgetFormInputText(),
      'public_scheduler_email_evens'    => new sfWidgetFormInputText(),
      'public_scheduler_evens_onhome'   => new sfWidgetFormInputText(),
      'personal_scheduler_email_evens'  => new sfWidgetFormInputText(),
      'personal_scheduler_evens_onhome' => new sfWidgetFormInputText(),
      'default_home_page'               => new sfWidgetFormInputText(),
      'skin'                            => new sfWidgetFormInputText(),
      'hidden_common_reports'           => new sfWidgetFormTextarea(),
      'hidden_dashboard_reports'        => new sfWidgetFormTextarea(),
      'sorted_dashboard_reports'        => new sfWidgetFormTextarea(),
      'public_scheduler_evens_onmenu'   => new sfWidgetFormInputText(),
      'personal_scheduler_evens_onmenu' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'users_group_id'                  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UsersGroups'), 'required' => false)),
      'name'                            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'photo'                           => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'email'                           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'culture'                         => new sfValidatorString(array('max_length' => 5, 'required' => false)),
      'password'                        => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'active'                          => new sfValidatorInteger(array('required' => false)),
      'public_scheduler_email_evens'    => new sfValidatorInteger(array('required' => false)),
      'public_scheduler_evens_onhome'   => new sfValidatorInteger(array('required' => false)),
      'personal_scheduler_email_evens'  => new sfValidatorInteger(array('required' => false)),
      'personal_scheduler_evens_onhome' => new sfValidatorInteger(array('required' => false)),
      'default_home_page'               => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'skin'                            => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'hidden_common_reports'           => new sfValidatorString(array('required' => false)),
      'hidden_dashboard_reports'        => new sfValidatorString(array('required' => false)),
      'sorted_dashboard_reports'        => new sfValidatorString(array('required' => false)),
      'public_scheduler_evens_onmenu'   => new sfValidatorInteger(array('required' => false)),
      'personal_scheduler_evens_onmenu' => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('users[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Users';
  }

}
