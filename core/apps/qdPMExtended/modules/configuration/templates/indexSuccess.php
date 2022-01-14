<?php

//check allowed type
    $type = $sf_request->getParameter('type');
    if(!in_array($type,['general','features','email_options','ldap','login','user','tasks_columns_list','public_tickets']))
    {       
       $type = 'general';
    }
    
  
  if($sf_request->hasParameter('type'))
  {
    $default_selector = array();
    $default_selector['off'] = __('No');
    $default_selector['on'] = __('Yes');
  
    echo form_tag('configuration/index',array('enctype'=>'multipart/form-data','class'=>'form-horizontal')) . input_hidden_tag('type', $type);
    include_partial('configuration/' . $type,array('default_selector'=>$default_selector));
    echo '<br>' . submit_tag(__('Save')) . '</form>';
  }
  
  
  