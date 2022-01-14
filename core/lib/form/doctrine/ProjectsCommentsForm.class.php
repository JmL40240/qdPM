<?php

/**
 * ProjectsComments form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ProjectsCommentsForm extends BaseProjectsCommentsForm
{
  public function configure()
  {
    $projects = $this->getOption('projects');
                  
    if($this->getObject()->isNew())
    {          
      $this->widgetSchema['projects_priority_id'] = new sfWidgetFormChoice(array('choices'=>app::getItemsChoicesByTable('ProjectsPriority',true)));        
      $this->widgetSchema['projects_types_id'] = new sfWidgetFormChoice(array('choices'=>app::getItemsChoicesByTable('ProjectsTypes',true)));        
      $this->widgetSchema['projects_groups_id'] = new sfWidgetFormChoice(array('choices'=>app::getItemsChoicesByTable('ProjectsGroups',true,false,$this->getOption('sf_user'))));              
      $this->widgetSchema['projects_status_id'] = new sfWidgetFormChoice(array('choices'=>app::getItemsChoicesByTable('ProjectsStatus',true)));
      
      $this->widgetSchema['projects_priority_id']->setAttributes(array('class'=>'form-control input-large'));
      $this->widgetSchema['projects_types_id']->setAttributes(array('class'=>'form-control input-large'));
      $this->widgetSchema['projects_groups_id']->setAttributes(array('class'=>'form-control input-large'));
      $this->widgetSchema['projects_status_id']->setAttributes(array('class'=>'form-control input-large'));
    }
    else
    {
      $this->widgetSchema['projects_priority_id'] = new sfWidgetFormInputHidden();
      $this->widgetSchema['projects_types_id'] = new sfWidgetFormInputHidden();
      $this->widgetSchema['projects_groups_id'] = new sfWidgetFormInputHidden();
      $this->widgetSchema['projects_status_id'] = new sfWidgetFormInputHidden();
    }
    
        
    $this->widgetSchema['description']->setAttributes(array('class'=>'form-control editor-auto-focus'));
    
    $this->widgetSchema['projects_id'] = new sfWidgetFormInputHidden();    
    $this->setDefault('projects_id', $projects->getId());
    
    $this->widgetSchema['created_by'] = new sfWidgetFormInputHidden();
    
    $this->widgetSchema['created_at'] = new sfWidgetFormInputHidden();
    $this->setDefault('created_at', date('Y-m-d H:i:s'));
    
    $this->widgetSchema->setLabels(array('projects_status_id'=>'Status',
                                         'description'=>'Comment',
                                         'projects_priority_id'=>'Priority',
                                         'projects_types_id'=>'Type',
                                         'projects_groups_id'=>'Group'));
    
    unset($this->widgetSchema['in_trash']);
    unset($this->widgetSchema['in_trash_date']);
    unset($this->validatorSchema['in_trash']);
    unset($this->validatorSchema['in_trash_date']);
  }
}
