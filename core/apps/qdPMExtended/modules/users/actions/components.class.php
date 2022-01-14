<?php

class usersComponents extends sfComponents
{
  public function executeFilters(sfWebRequest $request)
  {  
    $m = array();
    
    $params = false;
            
    $m = app::getFilterMenuItemsByTable($m,'UsersGroups','Group','users/index',$params);
    
    $m = app::getFilterExtraFields($m,false,'users','users/index',$params,array(),$this->getUser());
                                    
    $this->m = array(array('title'=>__('Filters'),'submenu'=>$m));
  }
  
  public function executeFiltersPreview(sfWebRequest $request)
  {
    $this->filter_by = $this->getUser()->getAttribute('users_filter');
    $this->params = false;
    
    $this->filter_tables = array('UsersGroups'=>'Group');
    

    
    $extra_fields = Doctrine_Core::getTable('ExtraFields')
      ->createQuery('a')
      ->addWhere('bind_type=?','users')
      ->whereIn('type',array('pull_down','checkbox','radiobox'))
      ->orderBy('sort_order, name')
      ->execute();
      
    foreach($extra_fields as $f)
    {
      $this->filter_tables['extraField' . $f->getId()] = $f->getName();
    }
  }  
}