<?php

/**
 * scheduler actions.
 *
 * @package    sf_sandbox
 * @subpackage scheduler
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class schedulerActions extends sfActions
{
  public function checkAccess($users_id,$access='')
  {
    if($users_id>0)
    {
      if(!$this->getUser()->hasCredential('allow_manage_personal_scheduler')  or $users_id!=$this->getUser()->getAttribute('id'))
      {
        $this->redirect('accessForbidden/index');
      }
    }
    else
    {
      if(($access=='manage' and !$this->getUser()->hasCredential('public_scheduler_access_full_access')) or ($access=='view' and !$this->getUser()->hasCredential('public_scheduler_access_full_access') and !$this->getUser()->hasCredential('public_scheduler_access_view_only')))
      {
        $this->redirect('accessForbidden/index');
      }
    }
  
  }
  
  public function executeIndex(sfWebRequest $request)
  {
    $this->checkAccess(0,'view');
    
    if(!$this->getUser()->hasAttribute('scheduler_current_time'))
    {    
      $this->getUser()->setAttribute('scheduler_current_time',time());
    }
    
    if($request->hasParameter('month'))
    {      
      $this->changeMonth($request->getParameter('month'),'scheduler_current_time');
      $this->redirect('scheduler/index');
    }
    
    app::setPageTitle('Public Scheduler',$this->getResponse());
  }
  
  public function executePersonal(sfWebRequest $request)
  {
    $this->checkAccess($this->getUser()->getAttribute('id'),'view');
    
    if(!$this->getUser()->hasAttribute('personal_scheduler_current_time'))
    {    
      $this->getUser()->setAttribute('personal_scheduler_current_time',time());
    }
    
    if($request->hasParameter('month'))
    {
      $this->changeMonth($request->getParameter('month'),'personal_scheduler_current_time');
      $this->redirect('scheduler/personal');
    }
    
    app::setPageTitle('Personal Scheduler',$this->getResponse());
    
  }
  
  protected function changeMonth($month,$scheduler_time)
  {
    switch($month)
    {
      case 'next_month': $this->getUser()->setAttribute($scheduler_time,strtotime("+1 month",$this->getUser()->getAttribute($scheduler_time)));
        break;
      case 'prev_month': $this->getUser()->setAttribute($scheduler_time,strtotime("-1 month",$this->getUser()->getAttribute($scheduler_time)));
        break;  
      case 'current_month': $this->getUser()->setAttribute($scheduler_time,time());  
        break;   
    }
  }
  
  public function executeInfo(sfWebRequest $request)
  {
    $this->forward404Unless($this->events = Doctrine_Core::getTable('Events')->find(array($request->getParameter('id'))), sprintf('Object events does not exist (%s).', $request->getParameter('id')));
    
    $this->checkAccess($this->events->getUsersId(),'view');
  }
  
  public function executeConfiguration(sfWebRequest $request)
  {
    $this->checkAccess($request->getParameter('users_id'),'view');
    
    $this->checked = array('onmenu'=>0,'ondashboard'=>0,'byemail'=>0);
    if($user = Doctrine_Core::getTable('Users')->find($this->getUser()->getAttribute('id')))
    {
      if($request->getParameter('users_id')>0)
      {
        $this->checked = array('onmenu'=>$user->getPersonalSchedulerEvensOnmenu(),'ondashboard'=>$user->getPersonalSchedulerEvensOnhome(),'byemail'=>$user->getPersonalSchedulerEmailEvens());
      }
      else
      {
        $this->checked = array('onmenu'=>$user->getPublicSchedulerEvensOnmenu(),'ondashboard'=>$user->getPublicSchedulerEvensOnhome(),'byemail'=>$user->getPublicSchedulerEmailEvens());
      }
      
      if($request->isMethod(sfRequest::PUT))
      {
        if($request->getParameter('users_id')>0)
        {
          $user->setPersonalSchedulerEvensOnmenu($request->getParameter('scheduler_evens_onmenu'));
          $user->setPersonalSchedulerEvensOnhome($request->getParameter('scheduler_evens_onhome'));
          $user->setPersonalSchedulerEmailEvens($request->getParameter('scheduler_email_evens'));
          $user->save();
          
          $this->getUser()->setAttribute('user',$user);
          
          $this->redirect('scheduler/personal');
        }
        else
        {
          $user->setPublicSchedulerEvensOnmenu($request->getParameter('scheduler_evens_onmenu'));
          $user->setPublicSchedulerEvensOnhome($request->getParameter('scheduler_evens_onhome'));
          $user->setPublicSchedulerEmailEvens($request->getParameter('scheduler_email_evens'));
          $user->save();
          
          $this->getUser()->setAttribute('user',$user);
          
          $this->redirect('scheduler/index');
        }
                
      }
      
    }        
  
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new EventsForm();
    
    $this->checkAccess($request->getParameter('users_id'),'manage');
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));
    
    $this->checkAccess($request->getParameter('users_id'),'manage');

    $this->form = new EventsForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($events = Doctrine_Core::getTable('Events')->find(array($request->getParameter('id'))), sprintf('Object events does not exist (%s).', $request->getParameter('id')));
    
    $this->checkAccess($events->getUsersId(),'manage');
    
    $this->form = new EventsForm($events);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($events = Doctrine_Core::getTable('Events')->find(array($request->getParameter('id'))), sprintf('Object events does not exist (%s).', $request->getParameter('id')));
    
    $this->checkAccess($events->getUsersId(),'manage');
    
    $this->form = new EventsForm($events);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {    
    $this->forward404Unless($events = Doctrine_Core::getTable('Events')->find(array($request->getParameter('id'))), sprintf('Object events does not exist (%s).', $request->getParameter('id')));
    
    $this->checkAccess($request->getParameter('users_id'),'manage');
    
    Attachments::deleteAttachmentsByBindId($events->getId(),'events');
    ExtraFieldsList::deleteFieldsByBindId($events->getId(),'events');
    
    $events->delete();

    exit();
    
    /*
    if($request->getParameter('users_id')>0)
    {
      $this->redirect('scheduler/personal');
    }
    else
    {
      $this->redirect('scheduler/index');
    }
    */
    
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $form->setFieldValue('repeat_days',$this->form['repeat_days']->getValue());
      
      $form->protectFieldsValue();
      
      $events = $form->save();
      
      ExtraFieldsList::setValues($request->getParameter('extra_fields'),$events->getId(),'events',$this->getUser(),$request);
            
      Attachments::insertAttachments($request->getFiles(),'events',$events->getId(),$request->getParameter('attachments_info'),$this->getUser());
      
      exit();
      
      /*
      if($events->getUsersId()>0)
      {
        $this->redirect('scheduler/personal');        
      }
      else
      {
        $this->redirect('scheduler/index');  
      } 
      */   
    }
  }
  
  public function executeResize(sfWebRequest $request)
  {    
    
  
      if(strstr($_POST['end'],'T'))
      {
        $end = str_replace('T',' ',$_POST['end']);        
      }
      else
      {
        $end = date('Y-m-d',strtotime('-1 day',app::getDateTimestamp($_POST['end'])));  
      }
                  
      $events = Doctrine_Core::getTable('Events')->find($_POST['id']);
      $events->setEndDate($end);
      $events->save();
                  
      
    exit();
  }
  
  public function executeDrop(sfWebRequest $request)
  {
    if(isset($_POST['end']))
    {
      if(strstr($_POST['end'],'T'))
      {
        $end = str_replace('T',' ',$_POST['end']);
      }
      else
      {
        $end = date('Y-m-d',strtotime('-1 day',app::getDateTimestamp($_POST['end'])));        
      }
                              
      $events = Doctrine_Core::getTable('Events')->find($_POST['id']);
      $events->setStartDate($_POST['start']);
      $events->setEndDate($end);
      $events->save();
    }
    else
    {
      $events = Doctrine_Core::getTable('Events')->find($_POST['id']);
      $events->setStartDate($_POST['start']);
      $events->setEndDate($_POST['start']);
      $events->save();      
    } 
    
    exit(); 
  }
  
  public function executeGetPersonalEvents()
  {
    $list = array();        
            
      foreach(events::get_events($_GET['start'],$_GET['end'],'personal',$this->getUser()->getAttribute('id')) as $events)
      {
        $start = $events['start_date'];
        $end = $events['end_date'];
        
        
        if(strstr($end,' 00:00:00'))
        {
          $end = date('Y-m-d H:i:s',strtotime('+1 day',app::getDateTimestamp($events['end_date'])));
        } 
        
        
        $bg_color = '';
        if($o = Doctrine_Core::getTable('EventsTypes')->find($events['events_types_id']))
        {
          if(strlen($o->getBackgroundColor())>0)
          {
            $bg_color = '#' . $o->getBackgroundColor();
          }
        }
         
        $list[] = array('id' => $events['id'],
                      'title' => addslashes($events['event_name']),
                      'description' => $events['description'],
                      'start' => str_replace(' 00:00:00','',$start),
                      'end' => str_replace(' 00:00:00','',$end),
                      'color'=> $bg_color,  
                      'editable'=>true,                                          
                      'allDay'=>(strstr($start,'00:00:00') and strstr($end,'00:00:00')),
                      'url' => app::public_url('scheduler/edit?id=' . $events['id'] . '&users_id=' . $this->getUser()->getAttribute('id'))                      
                      );      
      }
            
      echo json_encode($list);
      
      exit();
  }
  
  public function executeGetPublicEvents()
  {
    $list = array();        
            
      foreach(events::get_events($_GET['start'],$_GET['end'],'public',false) as $events)
      {
        $start = $events['start_date'];
        $end = $events['end_date'];
        
        
        if(strstr($end,' 00:00:00'))
        {
          $end = date('Y-m-d H:i:s',strtotime('+1 day',app::getDateTimestamp($events['end_date'])));
        } 
        
        $bg_color = '';
        if($o = Doctrine_Core::getTable('EventsTypes')->find($events['events_types_id']))
        {
          if(strlen($o->getBackgroundColor())>0)
          {
            $bg_color = '#' . $o->getBackgroundColor();
          }
        }
         
        $list[] = array('id' => $events['id'],
                      'title' => addslashes($events['event_name']),
                      'description' => $events['description'],
                      'start' => str_replace(' 00:00:00','',$start),
                      'end' => str_replace(' 00:00:00','',$end),
                      'color'=> $bg_color,  
                      'editable'=>true,                                          
                      'allDay'=>(strstr($start,'00:00:00') and strstr($end,'00:00:00')),
                      'url' => app::public_url('scheduler/edit?id=' . $events['id'] )                      
                      );      
      }
            
      echo json_encode($list);
      
      exit();
  }
}
                                       