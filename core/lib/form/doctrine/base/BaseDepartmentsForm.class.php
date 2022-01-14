<?php

/**
 * Departments form base class.
 *
 * @method Departments getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseDepartmentsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                     => new sfWidgetFormInputHidden(),
      'name'                   => new sfWidgetFormInputText(),
      'sort_order'             => new sfWidgetFormInputText(),
      'active'                 => new sfWidgetFormInputText(),
      'users_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Users'), 'add_empty' => false)),
      'tickets_types'          => new sfWidgetFormTextarea(),
      'public_status'          => new sfWidgetFormInputText(),
      'use_for_email_tickets'  => new sfWidgetFormInputText(),
      'imap_server'            => new sfWidgetFormInputText(),
      'imap_mailbox'           => new sfWidgetFormInputText(),
      'imap_login'             => new sfWidgetFormInputText(),
      'imap_pass'              => new sfWidgetFormInputText(),
      'imap_delete_emails'     => new sfWidgetFormInputText(),
      'new_ticket_message'     => new sfWidgetFormTextarea(),
      'ticket_comment_message' => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'                     => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'                   => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'sort_order'             => new sfValidatorInteger(array('required' => false)),
      'active'                 => new sfValidatorInteger(array('required' => false)),
      'users_id'               => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Users'), 'required' => false)),
      'tickets_types'          => new sfValidatorString(array('required' => false)),
      'public_status'          => new sfValidatorInteger(),
      'use_for_email_tickets'  => new sfValidatorInteger(array('required' => false)),
      'imap_server'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'imap_mailbox'           => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'imap_login'             => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'imap_pass'              => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'imap_delete_emails'     => new sfValidatorInteger(array('required' => false)),
      'new_ticket_message'     => new sfValidatorString(array('required' => false)),
      'ticket_comment_message' => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('departments[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Departments';
  }

}
