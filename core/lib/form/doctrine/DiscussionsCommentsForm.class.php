<?php

/**
 * DiscussionsComments form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class DiscussionsCommentsForm extends BaseDiscussionsCommentsForm
{
  public function configure()
  {
    $discussions = $this->getOption('discussions');
    
    
    if($this->getObject()->isNew())
    {
      $this->widgetSchema['discussions_priority_id'] = new sfWidgetFormChoice(array('choices'=>app::getItemsChoicesByTable('DiscussionsPriority',true)));        
      $this->widgetSchema['discussions_status_id'] = new sfWidgetFormChoice(array('choices'=>app::getItemsChoicesByTable('DiscussionsStatus',true)));        
      $this->widgetSchema['discussions_groups_id'] = new sfWidgetFormChoice(array('choices'=>app::getItemsChoicesByTable('DiscussionsGroups',true)));        
      $this->widgetSchema['discussions_types_id'] = new sfWidgetFormChoice(array('choices'=>app::getItemsChoicesByTable('DiscussionsTypes',true)));
      
      $this->widgetSchema['discussions_priority_id']->setAttributes(array('class'=>'form-control input-large'));
      $this->widgetSchema['discussions_status_id']->setAttributes(array('class'=>'form-control input-large'));
      $this->widgetSchema['discussions_groups_id']->setAttributes(array('class'=>'form-control input-large'));
      $this->widgetSchema['discussions_types_id']->setAttributes(array('class'=>'form-control input-large'));
    }
    else
    {
      $this->widgetSchema['discussions_priority_id'] = new sfWidgetFormInputHidden();
      $this->widgetSchema['discussions_status_id'] = new sfWidgetFormInputHidden();
      $this->widgetSchema['discussions_groups_id'] = new sfWidgetFormInputHidden();
      $this->widgetSchema['discussions_types_id'] = new sfWidgetFormInputHidden();
    }
    

    $this->widgetSchema['users_id'] = new sfWidgetFormInputHidden();
    
    $this->widgetSchema['created_at'] = new sfWidgetFormInputHidden();        
    $this->setDefault('created_at', date('Y-m-d H:i:s'));        
    
    $this->widgetSchema['description']->setAttributes(array('class'=>'form-control editor-auto-focus'));
        
    $this->widgetSchema['discussions_id'] = new sfWidgetFormInputHidden();    
    $this->setDefault('discussions_id', $discussions->getId());
    
    $this->widgetSchema->setLabels(array('discussions_priority_id'=>'Priority',
                                         'discussions_types_id'=>'Type',
                                         'discussions_groups_id'=>'Group',                                         
                                         'discussions_status_id'=>'Status',                                        
                                         ));
    
    unset($this->widgetSchema['in_trash']);
    unset($this->widgetSchema['in_trash_date']);
    unset($this->validatorSchema['in_trash']);
    unset($this->validatorSchema['in_trash_date']);
  }
}
