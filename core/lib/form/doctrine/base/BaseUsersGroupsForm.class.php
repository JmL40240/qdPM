<?php

/**
 * UsersGroups form base class.
 *
 * @method UsersGroups getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseUsersGroupsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                              => new sfWidgetFormInputHidden(),
      'name'                            => new sfWidgetFormInputText(),
      'allow_manage_projects'           => new sfWidgetFormInputText(),
      'allow_manage_tasks'              => new sfWidgetFormInputText(),
      'allow_manage_tickets'            => new sfWidgetFormInputText(),
      'allow_manage_users'              => new sfWidgetFormInputText(),
      'allow_manage_configuration'      => new sfWidgetFormInputText(),
      'allow_manage_discussions'        => new sfWidgetFormInputText(),
      'extra_fields'                    => new sfWidgetFormTextarea(),
      'default_value'                   => new sfWidgetFormInputText(),
      'allow_manage_reports'            => new sfWidgetFormInputText(),
      'allow_manage_public_scheduler'   => new sfWidgetFormInputText(),
      'allow_manage_personal_scheduler' => new sfWidgetFormInputText(),
      'allow_manage_patterns'           => new sfWidgetFormInputText(),
      'allow_manage_contacts'           => new sfWidgetFormInputText(),
      'allow_manage_public_wiki'        => new sfWidgetFormInputText(),
      'allow_manage_projects_wiki'      => new sfWidgetFormInputText(),
      'ldap_default'                    => new sfWidgetFormInputText(),
      'projects_custom_access'          => new sfWidgetFormInputText(),
      'projects_comments_access'        => new sfWidgetFormInputText(),
      'tasks_custom_access'             => new sfWidgetFormInputText(),
      'tasks_comments_access'           => new sfWidgetFormInputText(),
      'tickets_custom_access'           => new sfWidgetFormInputText(),
      'tickets_comments_access'         => new sfWidgetFormInputText(),
      'discussions_custom_access'       => new sfWidgetFormInputText(),
      'discussions_comments_access'     => new sfWidgetFormInputText(),
      'group_type'                      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'                            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'allow_manage_projects'           => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'allow_manage_tasks'              => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'allow_manage_tickets'            => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'allow_manage_users'              => new sfValidatorInteger(array('required' => false)),
      'allow_manage_configuration'      => new sfValidatorInteger(array('required' => false)),
      'allow_manage_discussions'        => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'extra_fields'                    => new sfValidatorString(array('required' => false)),
      'default_value'                   => new sfValidatorInteger(array('required' => false)),
      'allow_manage_reports'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'allow_manage_public_scheduler'   => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'allow_manage_personal_scheduler' => new sfValidatorInteger(array('required' => false)),
      'allow_manage_patterns'           => new sfValidatorInteger(array('required' => false)),
      'allow_manage_contacts'           => new sfValidatorInteger(array('required' => false)),
      'allow_manage_public_wiki'        => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'allow_manage_projects_wiki'      => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'ldap_default'                    => new sfValidatorInteger(array('required' => false)),
      'projects_custom_access'          => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'projects_comments_access'        => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'tasks_custom_access'             => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'tasks_comments_access'           => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'tickets_custom_access'           => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'tickets_comments_access'         => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'discussions_custom_access'       => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'discussions_comments_access'     => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'group_type'                      => new sfValidatorString(array('max_length' => 16, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('users_groups[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'UsersGroups';
  }

}
