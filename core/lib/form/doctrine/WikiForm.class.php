<?php

/**
 * Wiki form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class WikiForm extends BaseWikiForm
{
  public function configure()
  {
    $this->widgetSchema['description']->setAttributes(array('class'=>'editor-textarea form-control','style'=>'width: 100%; min-height: 400px;'));    
    
    $this->widgetSchema['name'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['users_id'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['projects_id'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['created_at'] = new sfWidgetFormInputHidden();    
    $this->setDefault('created_at', date('Y-m-d H:i:s'));
  }
}
