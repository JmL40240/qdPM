<?php

/**
 * ProjectsGroups form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ProjectsGroupsForm extends BaseProjectsGroupsForm
{
  public function configure()
  {
    $this->widgetSchema['active'] = new sfWidgetFormInputCheckbox(array(),array('value'=>1));
    $this->setDefault('active',1);
    
    $this->widgetSchema['default_value'] = new sfWidgetFormInputCheckbox(array(),array('value'=>1));
    $this->setDefault('default_value',0);

    $this->widgetSchema['name']->setAttribute('class','form-control input-medium required');
    $this->widgetSchema['sort_order']->setAttribute('class','form-control input-small');
    
    $this->widgetSchema->setLabels(array('sort_order'=>'Sort Order',
                                         'active'=>'Active?',
                                         'default_value'=>'Default?'));
  }
}
