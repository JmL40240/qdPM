<?php

/**
 * usersGroups actions.
 *
 * @package    sf_sandbox
 * @subpackage usersGroups
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class usersGroupsActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->users_groupss = Doctrine_Core::getTable('UsersGroups')
      ->createQuery('a')
      ->addWhere('group_type is null or length(group_type)=0')
      ->orderBy('name')
      ->execute();
      
    app::setPageTitle('User Groups',$this->getResponse());
  }
  
  public function executeNew(sfWebRequest $request)
  {
    $this->form = new UsersGroupsForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new UsersGroupsForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($users_groups = Doctrine_Core::getTable('UsersGroups')->find(array($request->getParameter('id'))), sprintf('Object users_groups does not exist (%s).', $request->getParameter('id')));
    $this->form = new UsersGroupsForm($users_groups);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($users_groups = Doctrine_Core::getTable('UsersGroups')->find(array($request->getParameter('id'))), sprintf('Object users_groups does not exist (%s).', $request->getParameter('id')));
    $this->form = new UsersGroupsForm($users_groups);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {    
    $this->forward404Unless($this->users_groups = Doctrine_Core::getTable('UsersGroups')->find(array($request->getParameter('id'))), sprintf('Object users_groups does not exist (%s).', $request->getParameter('id')));
    
    $this->count_users = UsersGroups::countUsersByGroupId($request->getParameter('id'));
    
    if($request->isMethod(sfRequest::PUT) and $this->count_users==0)
    {
      $this->users_groups->delete();
      
      $this->getUser()->setFlash('userNotices', t::__('User Group Deleted'));
  
      $this->redirect('usersGroups/index');
    }
  }
    

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      if(is_array($form['allow_manage_reports']->getValue()))
        $form->setFieldValue('allow_manage_reports',implode(',',$form['allow_manage_reports']->getValue()));
      
      if(is_array($form['projects_custom_access']->getValue()))
        $form->setFieldValue('projects_custom_access',implode(',',$form['projects_custom_access']->getValue()));
      
      if(is_array($form['tasks_custom_access']->getValue()))
        $form->setFieldValue('tasks_custom_access',implode(',',$form['tasks_custom_access']->getValue())); 
      
      if(is_array($form['tickets_custom_access']->getValue()))
        $form->setFieldValue('tickets_custom_access',implode(',',$form['tickets_custom_access']->getValue())); 
        
      if(is_array($form['discussions_custom_access']->getValue()))
        $form->setFieldValue('discussions_custom_access',implode(',',$form['discussions_custom_access']->getValue()));   
        
      $users_groups = $form->save();
      
      if($users_groups->getDefaultValue()==1)
      {
        app::resetCfgDefaultValue($users_groups->getId(),'UsersGroups');
      }

      $this->redirect('usersGroups/index');
    }
  }
}
