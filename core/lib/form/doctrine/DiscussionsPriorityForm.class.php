<?php

/**
 * DiscussionsPriority form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class DiscussionsPriorityForm extends BaseDiscussionsPriorityForm
{
  public function configure()
  {
    $this->widgetSchema['icon'] = new sfWidgetFormChoice(array('choices'=>app::getPriorityIconsChoices(),'expanded' => true,));
    
    $this->widgetSchema['active'] = new sfWidgetFormInputCheckbox(array(),array('value'=>1));
    $this->setDefault('active',1);
    
    $this->widgetSchema['default_value'] = new sfWidgetFormInputCheckbox(array(),array('value'=>1));
    $this->setDefault('default_value',0);

    $this->widgetSchema['name']->setAttribute('class','form-control input-medium  required');
    $this->widgetSchema['sort_order']->setAttribute('class','form-control input-small');
    
    $this->widgetSchema->setLabels(array('sort_order'=>'Sort Order',
                                         'default_value'=>'Default?',
                                         'active'=>'Active?'));
  }
}
