<?php

/**
 * Projects form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ProjectsForm extends BaseProjectsForm
{
  public function configure()
  {
    $this->widgetSchema['projects_priority_id'] = new sfWidgetFormChoice(array('choices'=>app::getItemsChoicesByTable('ProjectsPriority')),array('class'=>'form-control input-large'));
    $this->setDefault('projects_priority_id', app::getDefaultValueByTable('ProjectsPriority'));
    
    $this->widgetSchema['projects_types_id'] = new sfWidgetFormChoice(array('choices'=>app::getItemsChoicesByTable('ProjectsTypes')),array('class'=>'form-control input-large','onChange'=>'set_extra_fields_per_group(this.value)'));
    $this->setDefault('projects_types_id', app::getDefaultValueByTable('ProjectsTypes'));
    
    $this->widgetSchema['projects_groups_id'] = new sfWidgetFormChoice(array('choices'=>app::getItemsChoicesByTable('ProjectsGroups',false,false,$this->getOption('sf_user'))),array('class'=>'form-control input-large'));
    $this->setDefault('projects_groups_id', app::getDefaultValueByTable('ProjectsGroups'));
    
    $this->widgetSchema['projects_status_id'] = new sfWidgetFormChoice(array('choices'=>app::getItemsChoicesByTable('ProjectsStatus')),array('class'=>'form-control input-large'));
    $this->setDefault('projects_status_id', app::getDefaultValueByTable('ProjectsStatus'));
        
    $this->widgetSchema['name']->setAttributes(array('size'=>'60','class'=>'form-control input-xlarge required'));
    $this->widgetSchema['description']->setAttributes(array('class'=>'editor'));
    
    $this->widgetSchema['departments'] = new sfWidgetFormChoice(array('choices'=>Departments::getChoices(),'multiple'=>true,'expanded'=>true));
    
    $this->widgetSchema['created_by'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['created_at'] = new sfWidgetFormInputHidden();
    $this->setDefault('created_at', date('Y-m-d H:i:s'));
    
    $this->widgetSchema->setLabels(array('projects_priority_id'=>'Priority',
                                         'projects_types_id'=>'Type',
                                         'projects_groups_id'=>'Group',
                                         'projects_status_id'=>'Status'));
                                         
  
    unset($this->widgetSchema['in_trash']);
    unset($this->widgetSchema['in_trash_date']);
    unset($this->widgetSchema['is_public']);
    unset($this->widgetSchema['tasks_view']);
    unset($this->widgetSchema['last_comment_date']);
    unset($this->validatorSchema['in_trash']);
    unset($this->validatorSchema['in_trash_date']);
    unset($this->validatorSchema['is_public']);
    unset($this->validatorSchema['tasks_view']);
    unset($this->validatorSchema['last_comment_date']);
  }
}

