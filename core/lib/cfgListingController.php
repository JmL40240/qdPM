<?php

class cfgListingController
{
  public $module;
  
  public function __construct($module,$url_params = '')
	{
	 $this->module = $module;
	 $this->url_params = $url_params;
	}
	
	public function add_url_params($d)
	{
    if(strlen($this->url_params)>0)
    {
      return $d . $this->url_params; 
    }
    else
    {
      return '';
    }    
  }
	
	public function insert_button($title = false)
	{
	  if(!$title)
	  {
      $title = __('Add');
    }
        
    return '<button class="btn btn-primary" onClick="openModalBox(\'' . url_for($this->module . '/new' . $this->add_url_params('?'),true) . '\')">' . $title . '</button>';
  }
  
  public function sort_button()
	{    
    return '<button class="btn btn-default" onClick="openModalBox(\'' . url_for('app/sortItems?t=' . $this->module . $this->add_url_params('&') ,true) . '\')">' . __('Sort') . '</button>';
  }
  
  public function edit_button($id)
	{    
    return '<a href="#" class="btn btn-default btn-xs purple" onClick="openModalBox(\'' . url_for($this->module . '/edit?id=' . $id . $this->add_url_params('&'),true). '\'); return false;"><i class="fa fa-edit"></i></a>';
  }
        
  public function delete_button($id)
	{              
    return link_to('<i class="fa fa-trash-o"></i>', $this->module  . '/delete?id='  . $id  . $this->add_url_params('&'), array('method' => 'delete','class'=>'btn btn-default btn-xs purple', 'confirm' => __('Are you sure?')));
  }
  
  public function delete_mbutton($id)
	{
    return link_to_modalbox('<i class="fa fa-trash-o"></i>',$this->module  . '/delete?id='  . $id  . $this->add_url_params('&'),'class="btn btn-default btn-xs purple"');
  }
  
  public function action_buttons($id, $separator = ' ')
  {
    return $this->delete_button($id)  . $separator .  $this->edit_button($id);
  }
  
  public function copy_button($id)
	{    
    return '<a href="#" class="btn btn-default btn-xs purple" onClick="openModalBox(\'' . url_for($this->module . '/copy?id=' . $id . $this->add_url_params('&'),true). '\'); return false;"><i class="fa fa-files-o"></i></a>';
  }
} 