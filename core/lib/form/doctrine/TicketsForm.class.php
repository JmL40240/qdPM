<?php

/**
 * Tickets form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TicketsForm extends BaseTicketsForm
{
  public function configure()
  {
    $projects = $this->getOption('projects');
    $sf_user = $this->getOption('sf_user');
    
    if($projects)
    {
      $this->widgetSchema['departments_id'] = new sfWidgetFormChoice(array('choices'=>Departments::getChoicesByProject($projects)),array('class'=>'form-control input-large required','onChange'=>'set_tickets_types_by_departmetn_id(this.value)'));
    }
    else
    {
      $this->widgetSchema['departments_id'] = new sfWidgetFormInputHidden();
      $this->setDefault('departments_id', $this->getObject()->getDepartmentsId());
    }
    
    $this->widgetSchema['tickets_status_id'] = new sfWidgetFormChoice(array('choices'=>app::getItemsChoicesByTable('TicketsStatus')),array('class'=>'form-control input-large'));
    $this->setDefault('tickets_status_id', app::getDefaultValueByTable('TicketsStatus'));
    
    $this->widgetSchema['tickets_types_id'] = new sfWidgetFormChoice(array('choices'=>app::getItemsChoicesByTable('TicketsTypes')),array('class'=>'form-control input-large','onChange'=>'set_extra_fields_per_group(this.value)'));
    $this->setDefault('tickets_types_id', app::getDefaultValueByTable('TicketsTypes'));
    
    $this->widgetSchema['tickets_priority_id'] = new sfWidgetFormChoice(array('choices'=>app::getItemsChoicesByTable('TicketsPriority')),array('class'=>'form-control input-large'));
    $this->setDefault('tickets_priority_id', app::getDefaultValueByTable('TicketsPriority'));
    
    $this->widgetSchema['tickets_groups_id'] = new sfWidgetFormChoice(array('choices'=>app::getItemsChoicesByTable('TicketsGroups')),array('class'=>'form-control input-large'));
    $this->setDefault('tickets_groups_id', app::getDefaultValueByTable('TicketsGroups'));
    
    if($projects)
    {
      if(Users::hasAccess('edit','projects',$sf_user,$projects->getId())) //and $this->getObject()->isNew()
      {
        $this->widgetSchema['users_id'] = new sfWidgetFormChoice(array('choices'=>Users::getChoices(array_merge(array($sf_user->getAttribute('id')),array_filter(explode(',',$projects->getTeam()))),'tickets_insert',false,$projects->getId())),array('class'=>'form-control input-large'));
      }
      else
      {
        $this->widgetSchema['users_id'] = new sfWidgetFormInputHidden();
      }
    }
    
    $this->widgetSchema['name']->setAttributes(array('class'=>'form-control input-xlarge required'));
    $this->widgetSchema['description']->setAttributes(array('class'=>'form-control editor'));
    
    $this->widgetSchema['projects_id'] = new sfWidgetFormInputHidden();                   
    $this->widgetSchema['closed_date'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['created_at'] = new sfWidgetFormInputHidden();
    $this->setDefault('created_at', date('Y-m-d H:i:s'));
    
    
    $this->widgetSchema->setLabels(array('tickets_priority_id'=>'Priority',
                                         'tickets_types_id'=>'Type',                                                                                                                           
                                         'tickets_groups_id'=>'Group',
                                         'tickets_status_id'=>'Status',
                                         'departments_id'=>'Department',
                                         'name'=>'Subject',
                                         'users_id'=>'Created By',
                                         
                                         ));
    
    unset($this->widgetSchema['in_trash']);    
    unset($this->widgetSchema['in_trash_date']);      
    unset($this->widgetSchema['last_comment_date']);    
    unset($this->widgetSchema['user_name']);
    unset($this->widgetSchema['user_email']);
    unset($this->widgetSchema['message_id']);
    unset($this->validatorSchema['in_trash']);
    unset($this->validatorSchema['in_trash_date']);
    unset($this->validatorSchema['last_comment_date']);
    unset($this->validatorSchema['user_name']);
    unset($this->validatorSchema['user_email']);
    unset($this->validatorSchema['message_id']);
  }
}
