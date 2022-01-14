<?php

/**
 * TasksComments form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TasksCommentsForm extends BaseTasksCommentsForm
{
  public function configure()
  {
    $tasks = $this->getOption('tasks');
    
    if($this->getObject()->isNew())
    {
      $this->widgetSchema['tasks_priority_id'] = new sfWidgetFormChoice(array('choices'=>app::getItemsChoicesByTable('TasksPriority',true)));        
      $this->widgetSchema['tasks_status_id'] = new sfWidgetFormChoice(array('choices'=>app::getItemsChoicesByTable('TasksStatus',true)));        
      $this->widgetSchema['tasks_labels_id'] = new sfWidgetFormChoice(array('choices'=>app::getItemsChoicesByTable('TasksLabels',true)));        
      $this->widgetSchema['tasks_types_id'] = new sfWidgetFormChoice(array('choices'=>app::getItemsChoicesByTable('TasksTypes',true)));
      
      $this->widgetSchema['due_date'] = new sfWidgetFormInput(array(),array('class'=>'form-control'));    
      $this->widgetSchema['progress'] =  new sfWidgetFormChoice(array('choices' => Tasks::getProgressChoices()));
      
      $this->widgetSchema['tasks_priority_id']->setAttributes(array('class'=>'form-control'));
      $this->widgetSchema['tasks_status_id']->setAttributes(array('class'=>'form-control'));
      $this->widgetSchema['tasks_labels_id']->setAttributes(array('class'=>'form-control'));
      $this->widgetSchema['tasks_types_id']->setAttributes(array('class'=>'form-control'));
      
      $this->widgetSchema['togo_hours']->setAttributes(array('class'=>'form-control'));
      $this->widgetSchema['worked_hours']->setAttributes(array('class'=>'form-control'));
      $this->widgetSchema['progress']->setAttributes(array('class'=>'form-control'));
    }
    else
    {
      $this->widgetSchema['tasks_priority_id'] = new sfWidgetFormInputHidden();
      $this->widgetSchema['tasks_status_id'] = new sfWidgetFormInputHidden();
      $this->widgetSchema['tasks_labels_id'] = new sfWidgetFormInputHidden();
      $this->widgetSchema['tasks_types_id'] = new sfWidgetFormInputHidden();
      $this->widgetSchema['due_date'] = new sfWidgetFormInputHidden();
      $this->widgetSchema['progress'] = new sfWidgetFormInputHidden();
      $this->widgetSchema['togo_hours'] = new sfWidgetFormInputHidden();
    }
          
    
    
    $this->widgetSchema['created_by'] = new sfWidgetFormInputHidden();
    
    if(sfConfig::get('app_allow_adit_tasks_comments_date')=='off')
    {
      $this->widgetSchema['created_at'] = new sfWidgetFormInputHidden();
    }
    
    $this->setDefault('created_at', date('Y-m-d H:i:s'));        
    
    $this->widgetSchema['description']->setAttributes(array('class'=>'form-control editor-auto-focus'));
    $this->widgetSchema['worked_hours']->setAttributes(array('class'=>'form-control input-small')); 
        
    $this->widgetSchema['tasks_id'] = new sfWidgetFormInputHidden();    
    $this->setDefault('tasks_id', $tasks->getId());
    
    $this->widgetSchema->setLabels(array('tasks_priority_id'=>'Priority',
                                         'tasks_types_id'=>'Type',
                                         'tasks_labels_id'=>'Label',                                         
                                         'tasks_status_id'=>'Status',
                                         'worked_hours'=>'Work Hours',                                         
                                         'due_date'=>'Due Date',
                                         'created_at'=>'Created At',
                                         'togo_hours'=>'Hours To Go'
                                         ));
    
    unset($this->widgetSchema['in_trash']);
    unset($this->widgetSchema['in_trash_date']);
    unset($this->validatorSchema['in_trash']);
    unset($this->validatorSchema['in_trash_date']);
  }
}
