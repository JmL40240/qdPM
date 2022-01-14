<?php

/**
 * ContactsGroups form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ContactsGroupsForm extends BaseContactsGroupsForm
{
  public function configure()
  {
    $this->widgetSchema['name']->setAttribute('class','form-control input-medium  required');
    $this->widgetSchema['sort_order']->setAttribute('class','form-control input-small');
    
    $this->widgetSchema->setLabels(array('sort_order'=>'Sort Order'));
  }
}
