<?php

/**
 * TicketsToDiscussions form base class.
 *
 * @method TicketsToDiscussions getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseTicketsToDiscussionsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'tickets_id'     => new sfWidgetFormInputText(),
      'discussions_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Discussions'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'tickets_id'     => new sfValidatorInteger(),
      'discussions_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Discussions'))),
    ));

    $this->widgetSchema->setNameFormat('tickets_to_discussions[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'TicketsToDiscussions';
  }

}
