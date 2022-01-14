<?php

/**
 * ExtraFieldsTabs form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ExtraFieldsTabsForm extends BaseExtraFieldsTabsForm
{
  public function configure()
  {
    $this->widgetSchema['bind_type'] = new sfWidgetFormInputHidden();
    
    $this->widgetSchema['name']->setAttribute('class','required');
    $this->widgetSchema['sort_order']->setAttribute('size','3');
    
    $this->widgetSchema['users_groups_access'] = new sfWidgetFormChoice(array('choices'=>UsersGroups::getChoicesByType(),'expanded'=>true,'multiple'=>true));    

    $this->widgetSchema->setLabels(array('sort_order'=>'Sort Order',
                                         'users_groups_access'=>'Groups',                                                                                   
                                         ));
  }
}
