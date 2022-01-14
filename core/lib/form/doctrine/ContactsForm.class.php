<?php

/**
 * Contacts form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ContactsForm extends BaseContactsForm
{
  public function configure()
  {
    $this->widgetSchema['name']->setAttributes(array('class'=>'form-control input-large required'));
    $this->widgetSchema['email']->setAttributes(array('class'=>'form-control input-large required'));
    
    $this->widgetSchema['contacts_groups_id']->setAttributes(array('class'=>'form-control input-large'));
      
    $this->widgetSchema->setLabels(array('name'=>'Full Name','contacts_groups_id'=>'Group'));
  }
}
