<?php

/**
 * ExtraFields form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ExtraFieldsForm extends BaseExtraFieldsForm
{
  public function configure()
  {
    $this->widgetSchema['active'] = new sfWidgetFormInputCheckbox(array(),array('value'=>1));
    $this->setDefault('active',1);
    
    $this->widgetSchema['display_in_list'] = new sfWidgetFormInputCheckbox(array(),array('value'=>1));
    $this->setDefault('display_in_list',false);
    
    $this->widgetSchema['is_required'] = new sfWidgetFormInputCheckbox(array(),array('value'=>1));
    $this->setDefault('is_required',false);
        
    $this->widgetSchema['type'] = new sfWidgetFormChoice(array('choices'=>ExtraFields::getTypesChoices()),array('class'=>'form-control input-medium'));
    
    $this->widgetSchema['default_values'] = new sfWidgetFormTextarea();
    
    $this->widgetSchema['users_groups_access'] = new sfWidgetFormChoice(array('choices'=>UsersGroups::getChoicesByType(),'expanded'=>true,'multiple'=>true));
    
    $this->widgetSchema['extra_fields_tabs_id'] = new sfWidgetFormChoice(array('choices'=>ExtraFieldsTabs::getChoices($this->getOption('bind_type'))),array('class'=>'form-control input-medium'));
        
    $this->widgetSchema['bind_type'] = new sfWidgetFormInputHidden();
    
    $this->widgetSchema['name']->setAttribute('class','form-control input-medium required');
    $this->widgetSchema['sort_order']->setAttribute('class','form-control input-xsmall');    
    $this->widgetSchema['default_values']->setAttribute('class','form-control');

    $this->widgetSchema->setLabels(array('display_in_list'=>'Display in Listing?',
                                         'sort_order'=>'Sort Order',                                                                                  
                                         'active'=>'Active?',
                                         'extra_fields_tabs_id'=>'Form Tab',
                                         'users_groups_access'=>'Users Groups',
                                         'is_required'=>'Required?'));
  
  }
}
