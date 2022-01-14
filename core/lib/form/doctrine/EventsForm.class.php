<?php

/**
 * Events form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class EventsForm extends BaseEventsForm
{
  public function configure()
  {
    $this->widgetSchema['event_name'] = new sfWidgetFormInput();
    $this->widgetSchema['event_name']->setAttributes(array('class'=>'form-control input-xlarge required'));
    $this->widgetSchema['description']->setAttributes(array('class'=>'form-control input-xlarge'));
    
    $this->widgetSchema['events_priority_id'] = new sfWidgetFormChoice(array('choices'=>app::getItemsChoicesByTable('EventsPriority', true)),array('class'=>'form-control input-large'));
    $this->setDefault('events_priority_id', app::getDefaultValueByTable('EventsPriority'));
    
    $this->widgetSchema['events_types_id'] = new sfWidgetFormChoice(array('choices'=>app::getItemsChoicesByTable('EventsTypes',true)),array('onChange'=>'set_extra_fields_per_group(this.value)','class'=>'form-control input-large'));
    $this->setDefault('events_types_id', app::getDefaultValueByTable('EventsTypes'));
    
    $this->widgetSchema['start_date'] = new sfWidgetFormInput(array(),array('class'=>'form-control '));    
    $this->widgetSchema['end_date'] = new sfWidgetFormInput(array(),array('class'=>'form-control '));
    
    $this->widgetSchema['public_status'] = new sfWidgetFormInputCheckbox(array(),array('value'=>1));
    $this->setDefault('public_status',0);
    
    $this->widgetSchema['users_id'] = new sfWidgetFormInputHidden();
        
    $this->widgetSchema['repeat_type'] = new sfWidgetFormChoice(array('choices'=>array(''=>'','daily'=>t::__('Daily'),'weekly'=>t::__('Weekly'),'monthly'=>t::__('Monthly'),'yearly'=>t::__('Yearly'))),array('onChange'=>'check_event_repeat_type(this.value)','class'=>'form-control input-large'));
    $this->widgetSchema['repeat_days'] = new sfWidgetFormChoice(array('choices'=>array('1'=>t::__('Monday'),'2'=>t::__('Tuesday'),'3'=>t::__('Wednesday'),'4'=>t::__('Thursday'),'5'=>t::__('Friday'),'6'=>t::__('Saturday'),'7'=>t::__('Sunday')),'multiple'=>true,'expanded'=>true));
    $this->widgetSchema['repeat_interval']->setAttributes(array('class'=>'form-control input-small'));
    $this->setDefault('repeat_interval',1);    
    $this->widgetSchema['repeat_limit']->setAttributes(array('class'=>'form-control input-small'));
    $this->widgetSchema['repeat_end'] = new sfWidgetFormInput(array(),array('class'=>'form-control '));
    
    $this->widgetSchema->setLabels(array('event_name'=>'Subject',
                                         'start_date'=>'Start Date',
                                         'events_priority_id'=>'Priority',
                                         'events_types_id'=>'Type',
                                         'public_status'=>'Display this event on Public Scheduler',
                                         'repeat_type'=>'Type',
                                         'repeat_interval'=>'Interval',
                                         'repeat_days'=>'Repeat On',
                                         'repeat_end'=>'Date End',
                                         'repeat_limit'=>'Limit',
                                         'end_date'=>'End Date'));
  }
}
