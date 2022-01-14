<?php

class patternsComponents extends sfComponents
{
  public function executePatternsList()
  {
    $this->patterns = Doctrine_Core::getTable('Patterns')
      ->createQuery()
      ->addWhere('type=?',$this->type)
      ->addWhere('users_id=?',$this->getUser()->getAttribute('id'))
      ->orderBy('name')
      ->execute();
    
    $this->menu = array();  
    if(count($this->patterns)>0)
    {
      $s = array();
      foreach($this->patterns as $p)
      {
        $s[] = array('title'=>$p->getName(),'onClick'=>'userPattern(' . $p->getId() . ',\'' . $this->field_id. '\')');
      }
      
      $this->menu[] = array('title'=>__('Patterns'),'submenu'=>$s);
    } 
  }  
}