<?php

/**
 * TicketsComments form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TicketsCommentsForm extends BaseTicketsCommentsForm
{
  public function configure()
  {
    $tickets = $this->getOption('tickets');
    
    if($this->getObject()->isNew())
    {      
      if($tickets->getProjectsId()>0)
      {
        $this->widgetSchema['departments_id'] = new sfWidgetFormChoice(array('choices'=>Departments::getChoicesByProject($tickets->getProjects(),true)));
        $this->widgetSchema['departments_id']->setAttributes(array('class'=>'form-control input-large'));      
      }    
                      
      $this->widgetSchema['tickets_priority_id'] = new sfWidgetFormChoice(array('choices'=>app::getItemsChoicesByTable('TicketsPriority', true)));  
      $this->widgetSchema['tickets_status_id'] = new sfWidgetFormChoice(array('choices'=>app::getItemsChoicesByTable('TicketsStatus', true)));    
      $this->widgetSchema['tickets_groups_id'] = new sfWidgetFormChoice(array('choices'=>app::getItemsChoicesByTable('TicketsGroups', true)));        
      $this->widgetSchema['tickets_types_id'] = new sfWidgetFormChoice(array('choices'=>app::getItemsChoicesByTable('TicketsTypes', true)));
      
      $this->widgetSchema['tickets_priority_id']->setAttributes(array('class'=>'form-control input-large'));
      $this->widgetSchema['tickets_status_id']->setAttributes(array('class'=>'form-control input-large'));
      $this->widgetSchema['tickets_groups_id']->setAttributes(array('class'=>'form-control input-large'));
      $this->widgetSchema['tickets_types_id']->setAttributes(array('class'=>'form-control input-large'));
    }
    else
    {
      $this->widgetSchema['departments_id'] = new sfWidgetFormInputHidden();
      $this->widgetSchema['tickets_priority_id'] = new sfWidgetFormInputHidden();
      $this->widgetSchema['tickets_status_id'] = new sfWidgetFormInputHidden();
      $this->widgetSchema['tickets_groups_id'] = new sfWidgetFormInputHidden();
      $this->widgetSchema['tickets_types_id'] = new sfWidgetFormInputHidden();
    }
        
    $this->widgetSchema['users_id'] = new sfWidgetFormInputHidden();
        
    $this->widgetSchema['created_at'] = new sfWidgetFormInputHidden();    
    $this->setDefault('created_at', date('Y-m-d H:i:s'));
    
    $this->widgetSchema['description']->setAttributes(array('class'=>'form-control editor-auto-focus'));
    
    $this->widgetSchema['tickets_id'] = new sfWidgetFormInputHidden();    
    $this->setDefault('tickets_id', $tickets->getId());
    
    $this->widgetSchema->setLabels(array('tickets_priority_id'=>'Priority',
                                         'tickets_types_id'=>'Type',
                                         'tickets_groups_id'=>'Group',                                         
                                         'tickets_status_id'=>'Status',                                         
                                         ));
  
    unset($this->widgetSchema['in_trash']);
    unset($this->widgetSchema['in_trash_date']);
    unset($this->widgetSchema['user_name']);
    unset($this->widgetSchema['user_email']);
    unset($this->widgetSchema['message_id']);
    unset($this->validatorSchema['in_trash']);
    unset($this->validatorSchema['in_trash_date']);
    unset($this->validatorSchema['user_name']);
    unset($this->validatorSchema['user_email']);
    unset($this->validatorSchema['message_id']);
  }
}
