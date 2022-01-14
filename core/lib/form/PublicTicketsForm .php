<?php

class PublicTicketsForm extends sfForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'name'   => new sfWidgetFormInput(),
      'description'    => new sfWidgetFormTextarea(),
      'user_name'   => new sfWidgetFormInput(),
      'user_email'   => new sfWidgetFormInput(),      

    ));
    
    if(count($choices = Departments::getChoices(array(1,2)))>1)
    {
      $this->widgetSchema['departments_id'] = new sfWidgetFormChoice(array('choices'=>$choices,'expanded'=>true));
    }
    else
    {
      $this->widgetSchema['departments_id'] = new sfWidgetFormInputHidden();      
    }
    
    $this->setDefault('departments_id',key($choices));
    
    $this->widgetSchema['name']->setAttributes(array('size'=>'40','class'=>'required'));
    $this->widgetSchema['description']->setAttributes(array('rows'=>'7','cols'=>50,'class'=>'required'));
    $this->widgetSchema['user_name']->setAttributes(array('size'=>'40','class'=>'required'));
    $this->widgetSchema['user_email']->setAttributes(array('size'=>'40','class'=>'required email'));
    
    $this->widgetSchema->setLabels(array('name'=>'Subject',
                                         'description'=>'Message', 
                                         'user_name'=>'Full Name',
                                         'user_email'=>'Email Address',
                                         'departments_id'=>'Department',                                          
                                          ));
    
    $this->widgetSchema->setNameFormat('public_tickets[%s]');

    $this->setValidators(array(
      'departments_id'  => new sfValidatorDoctrineChoice(array('model' => 'Departments', 'required' => true)),
      'name'            => new sfValidatorString(array('required' => true)),      
      'description'     => new sfValidatorString(array('required' => true)),
      'user_name'       => new sfValidatorString(array('required' => true)),      
      'user_email'      => new sfValidatorEmail(array('required' => true)),
    ));
    
    
    
    if(sfConfig::get('app_public_tickets_use_antispam')=='on')
    {
      $this->widgetSchema['antispam'] = new sfWidgetFormInput(array(),array('size'=>3,'class'=>'required'));
      $this->widgetSchema->setLabel('antispam','Antispam Protection');
      $this->validatorSchema['antispam'] = new sfValidatorCallback(array('required' => true, 'callback'  => 'constant_validator_callback','arguments' => array('constant' => $this->getOption('sf_user')->getAttribute('antispam_result'))));
    }
    
    
    function constant_validator_callback($validator, $value, $arguments)
    {
      if ($value != $arguments['constant'])
      {
        throw new sfValidatorError($validator, 'invalid');
      }
     
      return $value;
    }

  }
}

?>
