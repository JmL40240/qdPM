<?php

/**
 * DiscussionsComments form base class.
 *
 * @method DiscussionsComments getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseDiscussionsCommentsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                      => new sfWidgetFormInputHidden(),
      'discussions_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Discussions'), 'add_empty' => false)),
      'users_id'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Users'), 'add_empty' => true)),
      'discussions_status_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DiscussionsStatus'), 'add_empty' => true)),
      'description'             => new sfWidgetFormTextarea(),
      'created_at'              => new sfWidgetFormDateTime(),
      'in_trash'                => new sfWidgetFormInputText(),
      'in_trash_date'           => new sfWidgetFormInputText(),
      'discussions_priority_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DiscussionsPriority'), 'add_empty' => true)),
      'discussions_groups_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DiscussionsGroups'), 'add_empty' => true)),
      'discussions_types_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DiscussionsTypes'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                      => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'discussions_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Discussions'), 'required' => false)),
      'users_id'                => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Users'), 'required' => false)),
      'discussions_status_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('DiscussionsStatus'), 'required' => false)),
      'description'             => new sfValidatorString(array('required' => false)),
      'created_at'              => new sfValidatorDateTime(array('required' => false)),
      'in_trash'                => new sfValidatorInteger(array('required' => false)),
      'in_trash_date'           => new sfValidatorInteger(array('required' => false)),
      'discussions_priority_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('DiscussionsPriority'), 'required' => false)),
      'discussions_groups_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('DiscussionsGroups'), 'required' => false)),
      'discussions_types_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('DiscussionsTypes'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('discussions_comments[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'DiscussionsComments';
  }

}
