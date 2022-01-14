<?php

/**
 * Departments form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class DepartmentsForm extends BaseDepartmentsForm
{
  public function configure()
  {
    $this->widgetSchema['users_id'] = new sfWidgetFormChoice(array('choices'=>Users::getChoices(array(),'tickets')),array('class'=>'required'));
    
    $this->widgetSchema['sort_order'] = new sfWidgetFormInput(array(),array('class'=>'form-control input-small'));
    $this->widgetSchema['active'] = new sfWidgetFormInputCheckbox(array(),array('value'=>1));
    
    $this->widgetSchema['public_status'] = new sfWidgetFormChoice(array('choices' => Departments::getPublicStatusList(), 'expanded' => true));
    
    $this->widgetSchema['tickets_types'] = new sfWidgetFormChoice(array('choices'=>app::getItemsChoicesByTable('TicketsTypes'), 'multiple' => true,'expanded' => true));
    
    $this->widgetSchema['use_for_email_tickets'] = new sfWidgetFormInputCheckbox(array(),array('value'=>1));
    $this->widgetSchema['imap_delete_emails'] = new sfWidgetFormInputCheckbox(array(),array('value'=>1));
    $this->widgetSchema['imap_server']->setAttribute('class','form-control input-large');
    $this->widgetSchema['imap_mailbox']->setAttribute('class','form-control input-medium');
    $this->widgetSchema['imap_pass']->setAttribute('class','form-control input-medium');
    $this->widgetSchema['imap_login']->setAttribute('class','form-control input-medium');
    
    $this->widgetSchema['name']->setAttribute('class','form-control input-medium required');
    $this->widgetSchema['users_id']->setAttribute('class','form-control input-medium');
    
    $this->widgetSchema['new_ticket_message']->setAttributes(array('class'=>'editor'));
    $this->widgetSchema['ticket_comment_message']->setAttributes(array('class'=>'editor'));
    
    $this->setDefault('active', 1);
    $this->setDefault('public_status', 1);
    $this->setDefault('imap_mailbox', 'INBOX');
    
    $this->widgetSchema->setLabels(array('users_id' => 'Assigned To', 
                                         'sort_order' => 'Sort Order',
                                         'imap_server' => 'Imap Server',
                                         'imap_login' => 'Login',
                                         'imap_pass' => 'Password',
                                         'imap_mailbox' => 'Mailbox',
                                         'tickets_types'=>'Ticket Types',
                                         'imap_delete_emails' => 'Delete Emails',
                                         'public_status'=>'Public Status',
                                         'use_for_email_tickets' => 'Get tickets from email'));
  }
}
