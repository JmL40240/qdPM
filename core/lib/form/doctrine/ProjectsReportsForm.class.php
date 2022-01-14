<?php

/**
 * ProjectsReports form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ProjectsReportsForm extends BaseProjectsReportsForm
{
  public function configure()
  {  
    $this->widgetSchema['display_on_home'] = new sfWidgetFormInputCheckbox(array(),array('value'=>1));
    $this->setDefault('display_on_home',false);
    
    $this->widgetSchema['display_in_menu'] = new sfWidgetFormInputCheckbox(array(),array('value'=>1));
    $this->setDefault('display_in_menu', false);
    
    $this->widgetSchema['is_mandatory'] = new sfWidgetFormInputCheckbox(array(),array('value'=>1));
    $this->setDefault('is_mandatory', false);
    
    $this->widgetSchema['listing_order'] = new sfWidgetFormChoice(array('choices'=>ProjectsReports::getListingOrderChoices()),array('class'=>'form-control input-medium'));
    $this->setDefault('listing_order', 'status');
    
    $this->widgetSchema['users_id'] = new sfWidgetFormInputHidden();
    
    $this->widgetSchema['name']->setAttributes(array('class'=>'form-control input-medium required'));
        
    $this->widgetSchema['users_groups_id'] = new sfWidgetFormChoice(array('choices'=>UsersGroups::getChoicesByType(),'expanded'=>true,'multiple'=>true));
    
    $this->widgetSchema['display_only_assigned'] = new sfWidgetFormInputCheckbox(array(),array('value'=>1));
    $this->setDefault('display_only_assigned', false);
    
    $this->widgetSchema->setLabels(array('is_mandatory'=>'Mandatory Report','display_on_home'=>'Display on dashboard','listing_order'=>'Order By','users_groups_id'=>'Users Groups'));
    
    unset($this->widgetSchema['is_default']);
    unset($this->validatorSchema['is_default']);
    
    unset($this->widgetSchema['report_type']);
    unset($this->validatorSchema['report_type']);
    
    unset($this->widgetSchema['visible_on_home']);
    unset($this->validatorSchema['visible_on_home']);
    
    unset($this->widgetSchema['sort_order']);
    unset($this->validatorSchema['sort_order']);
  }
}
