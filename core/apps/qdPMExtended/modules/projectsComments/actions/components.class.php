<?php

class projectsCommentsComponents extends sfComponents
{
  public function executeInfo(sfWebRequest $request)
  {
  
  }
  
  public function executeEmailBody()
  {    
    $this->comments_history = Doctrine_Core::getTable('ProjectsComments')
      ->createQuery()
      ->addWhere('projects_id=?',$this->projects->getId())
      ->addWhere('in_trash is null')
      ->orderBy('created_at desc')
      ->limit((int)sfConfig::get('app_amount_previous_comments',2)+1)
      ->execute();  
  }
}