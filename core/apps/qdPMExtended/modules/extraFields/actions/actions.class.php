<?php

/**
 * extraFields actions.
 *
 * @package    sf_sandbox
 * @subpackage extraFields
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class extraFieldsActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->forward404Unless($request->hasParameter('bind_type'), 'bind_type is not defined');
        
    $this->extra_fieldss = Doctrine_Core::getTable('ExtraFields')
      ->createQuery('ef')->leftJoin('ef.ExtraFieldsTabs eft')
      ->addWhere('ef.bind_type=?',$request->getParameter('bind_type','projects'))
      ->orderBy('ef.extra_fields_tabs_id, ef.sort_order, ef.name')
      ->execute();
      
    app::setPageTitle('Extra Fields',$this->getResponse());
  }
  
  public function executeExtraFieldsByGroup(sfWebRequest $request)
  {          
    switch($request->getParameter('t'))
    {  
      case 'UsersGroups':
        $this->groups = Doctrine_Core::getTable($request->getParameter('t'))
          ->createQuery('a')
          ->addWhere('group_type is null or length(group_type)=0')
          ->orderBy('name')
          ->execute();
        break;
      default:
        $this->groups = Doctrine_Core::getTable($request->getParameter('t'))
          ->createQuery('a')
          ->orderBy('sort_order, name')
          ->execute();
        break;
    }
    
    if(count($this->groups)==0)
    {
     app::setNotice('Please add items',$this->getUser(),'warning');
     
      switch($request->getParameter('t'))
      {
        case 'UsersGroups':
            $this->redirect('usersGroups/index');
          break;
        case 'ProjectsTypes':
            $this->redirect('projectsTypes/index');
          break;
        case 'TasksTypes':
            $this->redirect('TasksTypes/index');
          break;
        case 'TicketsTypes':
            $this->redirect('ticketsTypes/index');
          break;  
        case 'DiscussionsTypes':
            $this->redirect('discussionsTypes/index');
          break;
      }
    } 
    
    switch($request->getParameter('t'))
    {
      case 'UsersGroups':
          $bind_type = 'users';
          $this->heading = 'Extra Fields per User Groups';
        break;
      case 'ProjectsTypes':
          $bind_type = 'projects';
          $this->heading = 'Extra Fields per Project Types';
        break;
      case 'TasksTypes':
          $bind_type = 'tasks';
          $this->heading = 'Extra Fields per Task Types';
        break;
      case 'TicketsTypes':
          $bind_type = 'tickets';
          $this->heading = 'Extra Fields per Ticket Types';
        break;  
      case 'DiscussionsTypes':
          $bind_type = 'discussions';
          $this->heading = 'Extra Fields per Discussion Types';
        break;
    }
    
    $this->extra_fields = Doctrine_Core::getTable('ExtraFields')
      ->createQuery('a')
      ->addWhere('bind_type=?',$bind_type)
      ->orderBy('sort_order, name')
      ->execute();
      
    if(count($this->extra_fields)==0)
    {
      app::setNotice('Please add items',$this->getUser(),'warning');
      
      switch($request->getParameter('t'))
      {
        case 'UsersGroups':
            $this->redirect('extraFields/index?bind_type=users');
          break;
        case 'ProjectsTypes':
            $this->redirect('extraFields/index?bind_type=projects');
          break;
        case 'TasksTypes':
            $this->redirect('extraFields/index?bind_type=tasks');
          break;
        case 'TicketsTypes':
            $this->redirect('extraFields/index?bind_type=tickets');
          break;  
        case 'DiscussionsTypes':
            $this->redirect('extraFields/index?bind_type=discussions');
          break;
      }
    }  
      
    if($request->isMethod(sfRequest::POST))
    {
      $extra_field = $request->getParameter('extra_field');
      $set_off_extra_fields = $request->getParameter('set_off_extra_fields');
              
      foreach($this->groups as $g)
      {                
        if(isset($extra_field[$g->getId()]))
        {
          $g->setExtraFields(implode(',',$extra_field[$g->getId()]));
          $g->save();
        }
        elseif(isset($set_off_extra_fields[$g->getId()]))
        {
          $g->setExtraFields('set_off_extra_fields');
          $g->save();
        }
        else
        {
          $g->setExtraFields('');
          $g->save();
        }
      }
      
      $this->getUser()->setFlash('userNotices', t::__('Extra Fields Updated'));
      
      $this->redirect('extraFields/extraFieldsByGroup?t=' . $request->getParameter('t'));
    } 
    
    app::setPageTitle('Extra Fields per User Groups',$this->getResponse()); 
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->forward404Unless($request->hasParameter('bind_type'), 'bind_type is not defined');
    
    $this->form = new ExtraFieldsForm(null, array('bind_type'=>$request->getParameter('bind_type')));
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->hasParameter('bind_type'), 'bind_type is not defined');
    
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new ExtraFieldsForm(null, array('bind_type'=>$request->getParameter('bind_type')));

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($request->hasParameter('bind_type'), 'bind_type is not defined');
    
    $this->forward404Unless($extra_fields = Doctrine_Core::getTable('ExtraFields')->find(array($request->getParameter('id'))), sprintf('Object extra_fields does not exist (%s).', $request->getParameter('id')));
    $this->form = new ExtraFieldsForm($extra_fields, array('bind_type'=>$request->getParameter('bind_type')));
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->hasParameter('bind_type'), 'bind_type is not defined');
    
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($extra_fields = Doctrine_Core::getTable('ExtraFields')->find(array($request->getParameter('id'))), sprintf('Object extra_fields does not exist (%s).', $request->getParameter('id')));
    $this->form = new ExtraFieldsForm($extra_fields, array('bind_type'=>$request->getParameter('bind_type')));

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();
    
    $this->forward404Unless($request->hasParameter('bind_type'), 'bind_type is not defined');

    $this->forward404Unless($extra_fields = Doctrine_Core::getTable('ExtraFields')->find(array($request->getParameter('id'))), sprintf('Object extra_fields does not exist (%s).', $request->getParameter('id')));
    $extra_fields->delete();

    $this->redirect('extraFields/index?bind_type='.$request->getParameter('bind_type'));
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $form->setFieldValue('users_groups_access',$form['users_groups_access']->getValue());
      $form->setFieldValue('view_only_access',$form['view_only_access']->getValue());
      
      $extra_fields = $form->save();

      $this->redirect('extraFields/index?bind_type='.$request->getParameter('bind_type'));
    }
  }
  
  public function executeMultipleEdit(sfWebRequest $request)
  {
    if($request->hasParameter('selected_items'))
    {
      foreach(explode(',',$request->getParameter('selected_items')) as $id)
      {
        if($ef = Doctrine_Core::getTable('ExtraFields')->find($id))
        {
          if(strlen($request->getParameter('tab'))>0)
          {
            $ef->setExtraFieldsTabsId($request->getParameter('tab'));
          }
          
          if(strlen($request->getParameter('in_listing'))>0)
          {
            $ef->setDisplayInList($request->getParameter('in_listing'));
          }
          
          if(strlen($request->getParameter('is_requried'))>0)
          {
            $ef->setIsRequired($request->getParameter('is_requried'));
          }
          
          if(strlen($request->getParameter('active'))>0)
          {
            $ef->setActive($request->getParameter('active'));
          }
          
          $ef->save();
        }
      }
      
      $this->redirect('extraFields/index?bind_type='.$request->getParameter('bind_type'));
    }
  }
}
