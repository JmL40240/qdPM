<?php

/**
 * ProjectsRoles form base class.
 *
 * @method ProjectsRoles getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseProjectsRolesForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'projects_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Projects'), 'add_empty' => false)),
      'users_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Users'), 'add_empty' => false)),
      'users_groups_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UsersGroups'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'projects_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Projects'))),
      'users_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Users'))),
      'users_groups_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UsersGroups'))),
    ));

    $this->widgetSchema->setNameFormat('projects_roles[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProjectsRoles';
  }

}
