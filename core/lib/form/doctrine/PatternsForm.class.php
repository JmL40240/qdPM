<?php

/**
 * Patterns form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PatternsForm extends BasePatternsForm
{
  public function configure()
  {
    
    $this->widgetSchema['type'] =  new sfWidgetFormChoice(array('choices' => Patterns::getPatternsTypesList($this->getOption('sf_user'))));        
    $this->widgetSchema['users_id'] = new sfWidgetFormInputHidden();
    
    $this->widgetSchema['name']->setAttributes(array('class'=>'form-control input-large required'));
    $this->widgetSchema['type']->setAttributes(array('class'=>'form-control input-large required'));
    $this->widgetSchema['description']->setAttribute('class','form-control  editor');
  
  }
}
