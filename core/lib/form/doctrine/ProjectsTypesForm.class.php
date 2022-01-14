<?php

/**
 * ProjectsTypes form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ProjectsTypesForm extends BaseProjectsTypesForm
{
  public function configure()
  {
    $this->widgetSchema['extra_fields'] = new sfWidgetFormChoice(array('choices'=>ExtraFields::getFieldsByType('projects'),'expanded'=>true,'multiple'=>true));
    $this->widgetSchema['tasks_columns_list'] = new sfWidgetFormChoice(array('choices'=>Tasks::getTasksColumnChoices(),'expanded'=>true,'multiple'=>true));
    
    $this->widgetSchema['active'] = new sfWidgetFormInputCheckbox(array(),array('value'=>1));
    $this->setDefault('active',1);
    
    $this->widgetSchema['default_value'] = new sfWidgetFormInputCheckbox(array(),array('value'=>1));
    $this->setDefault('default_value',0);
    
    $this->widgetSchema['name']->setAttribute('class','form-control input-medium required');
    $this->widgetSchema['sort_order']->setAttribute('class','form-control input-small');
    $this->widgetSchema['background_color']->setAttribute('class','form-control input-small');  

    $this->widgetSchema->setLabels(array('sort_order'=>'Sort Order',
                                         'background_color'=>'Background',
                                         'active'=>'Active?',
                                         'default_value'=>'Default?',
                                         'extra_fields'=>'Extra Fields',
                                         'tasks_columns_list'=>'Tasks Columns'));
  }
}
