<?php

/**
 * Discussions form base class.
 *
 * @method Discussions getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseDiscussionsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                      => new sfWidgetFormInputHidden(),
      'projects_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Projects'), 'add_empty' => false)),
      'users_id'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Users'), 'add_empty' => true)),
      'discussions_status_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DiscussionsStatus'), 'add_empty' => true)),
      'discussions_groups_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DiscussionsGroups'), 'add_empty' => true)),
      'discussions_priority_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DiscussionsPriority'), 'add_empty' => true)),
      'discussions_types_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DiscussionsTypes'), 'add_empty' => true)),
      'name'                    => new sfWidgetFormInputText(),
      'description'             => new sfWidgetFormTextarea(),
      'assigned_to'             => new sfWidgetFormInputText(),
      'created_at'              => new sfWidgetFormDateTime(),
      'in_trash'                => new sfWidgetFormInputText(),
      'in_trash_date'           => new sfWidgetFormInputText(),
      'last_comment_date'       => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                      => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'projects_id'             => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Projects'), 'required' => false)),
      'users_id'                => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Users'), 'required' => false)),
      'discussions_status_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('DiscussionsStatus'), 'required' => false)),
      'discussions_groups_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('DiscussionsGroups'), 'required' => false)),
      'discussions_priority_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('DiscussionsPriority'), 'required' => false)),
      'discussions_types_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('DiscussionsTypes'), 'required' => false)),
      'name'                    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'description'             => new sfValidatorString(array('required' => false)),
      'assigned_to'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'              => new sfValidatorDateTime(array('required' => false)),
      'in_trash'                => new sfValidatorInteger(array('required' => false)),
      'in_trash_date'           => new sfValidatorInteger(array('required' => false)),
      'last_comment_date'       => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('discussions[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Discussions';
  }

}
