<?php

/**
 * ticketsComments actions.
 *
 * @package    sf_sandbox
 * @subpackage ticketsComments
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ticketsCommentsActions extends sfActions
{
  protected function checkProjectsAccess($projects)
  {    
    Projects::checkViewOwnAccess($this,$this->getUser(),$projects);    
  }
  
  protected function checkTicketsAccess($access,$tickets=false,$projects=false)
  {
    if($projects)
    {
      Users::checkAccess($this,$access,'tickets',$this->getUser(),$projects->getId());
      if($tickets)
      {
        Tickets::checkViewOwnAccess($this,$this->getUser(),$tickets,$projects);
      }
    }
    elseif($tickets)
    {
      Users::checkAccess($this,$access,'tickets',$this->getUser());
      Tickets::checkViewOwnAccess($this,$this->getUser(),$tickets);
    }
  }
  
  protected function checkViewOwnAccess($comments,$projects)
  {
    if(Users::hasAccess('view_own','ticketsComments',$this->getUser(),$projects->getId()))
    {
      if($comments->getCreatedBy()!=$this->getUser()->getAttribute('id'))
      {
        $this->redirect('accessForbidden/index');
      }
    }
  }
  public function executeIndex(sfWebRequest $request)
  {
        
    if($request->getParameter('projects_id')>0)
    {
      $this->forward404Unless($this->projects = Doctrine_Core::getTable('Projects')->createQuery()->addWhere('id=?',$request->getParameter('projects_id'))->addWhere('in_trash is null')->fetchOne(), sprintf('Object projects does not exist (%s).', $request->getParameter('projects_id')));
      $this->forward404Unless($this->tickets = Doctrine_Core::getTable('Tickets')->createQuery()->addWhere('in_trash is null')->addWhere('id=?',$request->getParameter('tickets_id'))->addWhere('projects_id=?',$request->getParameter('projects_id'))->fetchOne(), sprintf('Object tasks does not exist (%s).', $request->getParameter('tickets_id')));
      $this->checkProjectsAccess($this->projects);
      $this->checkTicketsAccess('view',$this->tickets, $this->projects);
      
      if(!$this->getUser()->hasAttribute('tickets_filter' . $request->getParameter('projects_id')))
      {
        $this->getUser()->setAttribute('tickets_filter' . $request->getParameter('projects_id'), Tickets::getDefaultFilter($request,$this->getUser()));
      }
    }
    else
    {
      $this->forward404Unless($this->tickets = Doctrine_Core::getTable('Tickets')->find(array($request->getParameter('tickets_id'))), sprintf('Object tasks does not exist (%s).', $request->getParameter('id')));
      $this->checkTicketsAccess('view',$this->tickets);
    }
  
    $this->tickets_comments = Doctrine_Core::getTable('TicketsComments')
      ->createQuery('tc')
      ->leftJoin('tc.TicketsStatus ts')
      ->leftJoin('tc.TicketsTypes tt')
      ->leftJoin('tc.TicketsPriority tp')
      ->leftJoin('tc.TicketsGroups tg')
      ->leftJoin('tc.Departments d')
      ->leftJoin('tc.Users u')
      ->addWhere('tc.tickets_id=?',$request->getParameter('tickets_id'))
      ->addWhere('tc.in_trash is null')
      ->orderBy('tc.created_at desc')
      ->fetchArray();
      
    $this->more_actions = $this->getMoreActions($request);
    
    app::setPageTitle(t::__('Ticket') . ' | ' . ($this->tickets->getTicketsTypesId()>0 ? $this->tickets->getTicketsTypes()->getName(). ': ':'') . $this->tickets->getName(),$this->getResponse());
  }
  
  protected function getMoreActions(sfWebRequest $request)
  {
    $more_actions = array();    
    $s = array();
    
    if(Users::hasAccess('insert','tasks',$this->getUser(),$request->getParameter('projects_id')) and $request->getParameter('projects_id')>0)
    {
      $s[] = array('title'=>t::__('Related Tasks'),
                   'submenu'=>array( array('title'=>t::__('Add Task'),'url'=>'tasks/new?related_tickets_id=' . $request->getParameter('tickets_id') . '&projects_id=' . $request->getParameter('projects_id'),'modalbox'=>true),
                                    array('title'=>t::__('Link Task'),'url'=>'tasks/bindTasks?related_tickets_id=' . $request->getParameter('tickets_id') . '&projects_id=' . $request->getParameter('projects_id'),'modalbox'=>true),
                                    ));
    }
    
    if(Users::hasAccess('insert','discussions',$this->getUser(),$request->getParameter('projects_id')) and $request->getParameter('projects_id')>0)
    {      
      $s[] = array('title'=>t::__('Related Discussions'),
                   'submenu'=>array( array('title'=>t::__('Add Discussion'),'url'=>'discussions/new?related_tickets_id=' . $request->getParameter('tickets_id') . '&projects_id=' . $request->getParameter('projects_id'),'modalbox'=>true),
                                    array('title'=>t::__('Link Discussions'),'url'=>'discussions/bindDiscussions?related_tickets_id=' . $request->getParameter('tickets_id') . '&projects_id=' . $request->getParameter('projects_id'),'modalbox'=>true),
                                    ));
    }
    
    if(Users::hasAccess('edit','tickets',$this->getUser(),$request->getParameter('projects_id')))
    {      
      $s[] = array('title'=>t::__('Move To'),'url'=>'tickets/moveTo?tickets_id=' . $request->getParameter('tickets_id') . '&projects_id=' . $request->getParameter('projects_id') . '&redirect_to=ticketsComments','modalbox'=>true);
    }
    
    if(Users::hasAccess('delete','tickets',$this->getUser(),$request->getParameter('projects_id')))
    {
      $s[] = array('title'=>t::__('Delete'),'url'=>'tickets/delete?id=' . $request->getParameter('tickets_id') . '&projects_id=' . $request->getParameter('projects_id'),'confirm'=>true);
    }
    
    if(count($s)>0)
    {
      $more_actions[] = array('title'=>t::__('More Actions'),'submenu'=>$s);
    }
    
    return $more_actions; 
  }  

  public function executeNew(sfWebRequest $request)
  {        
    if($request->getParameter('projects_id')>0)
    {
      $this->forward404Unless($this->projects = Doctrine_Core::getTable('Projects')->createQuery()->addWhere('id=?',$request->getParameter('projects_id'))->addWhere('in_trash is null')->fetchOne(), sprintf('Object projects does not exist (%s).', $request->getParameter('projects_id')));
      $this->forward404Unless($this->tickets = Doctrine_Core::getTable('Tickets')->createQuery()->addWhere('in_trash is null')->addWhere('id=?',$request->getParameter('tickets_id'))->addWhere('projects_id=?',$request->getParameter('projects_id'))->fetchOne(), sprintf('Object tasks does not exist (%s).', $request->getParameter('tickets_id')));
      $this->checkProjectsAccess($this->projects);
      $this->checkTicketsAccess('view',$this->tickets, $this->projects);
    }
    else
    {    
      $this->projects = null;
      $this->forward404Unless($this->tickets = Doctrine_Core::getTable('Tickets')->find(array($request->getParameter('tickets_id'))), sprintf('Object tasks does not exist (%s).', $request->getParameter('tickets_id')));
      $this->checkTicketsAccess('view',$this->tickets);
    }
    
    Users::checkAccess($this,'insert','ticketsComments',$this->getUser(),$request->getParameter('projects_id'));
  
    $this->form = new TicketsCommentsForm(null, array('tickets'=>$this->tickets));
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));
            
    if($request->getParameter('projects_id')>0)
    {
      $this->forward404Unless($this->projects = Doctrine_Core::getTable('Projects')->createQuery()->addWhere('id=?',$request->getParameter('projects_id'))->addWhere('in_trash is null')->fetchOne(), sprintf('Object projects does not exist (%s).', $request->getParameter('projects_id')));
      $this->forward404Unless($this->tickets = Doctrine_Core::getTable('Tickets')->createQuery()->addWhere('in_trash is null')->addWhere('id=?',$request->getParameter('tickets_id'))->addWhere('projects_id=?',$request->getParameter('projects_id'))->fetchOne(), sprintf('Object tasks does not exist (%s).', $request->getParameter('tickets_id')));
      $this->checkProjectsAccess($this->projects);
      $this->checkTicketsAccess('view',$this->tickets, $this->projects);
    }
    else
    {
      $this->projects = null;
      $this->forward404Unless($this->tickets = Doctrine_Core::getTable('Tickets')->find(array($request->getParameter('tickets_id'))), sprintf('Object tasks does not exist (%s).', $request->getParameter('tickets_id')));
      $this->checkTicketsAccess('view',$this->tickets);
    }
    
    Users::checkAccess($this,'insert','ticketsComments',$this->getUser(),$request->getParameter('projects_id'));

    $this->form = new TicketsCommentsForm(null, array('tickets'=>$this->tickets));

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {        
    if($request->getParameter('projects_id')>0)
    {
      $this->forward404Unless($this->projects = Doctrine_Core::getTable('Projects')->createQuery()->addWhere('id=?',$request->getParameter('projects_id'))->addWhere('in_trash is null')->fetchOne(), sprintf('Object projects does not exist (%s).', $request->getParameter('projects_id')));
      $this->forward404Unless($this->tickets = Doctrine_Core::getTable('Tickets')->createQuery()->addWhere('in_trash is null')->addWhere('id=?',$request->getParameter('tickets_id'))->addWhere('projects_id=?',$request->getParameter('projects_id'))->fetchOne(), sprintf('Object tasks does not exist (%s).', $request->getParameter('tickets_id')));
      $this->checkProjectsAccess($this->projects);
      $this->checkTicketsAccess('view',$this->tickets, $this->projects);
    }
    else
    {
      $this->projects = null;
      $this->forward404Unless($this->tickets = Doctrine_Core::getTable('Tickets')->find(array($request->getParameter('tickets_id'))), sprintf('Object tasks does not exist (%s).', $request->getParameter('tickets_id'))); 
      $this->checkTicketsAccess('view',$this->tickets);
    }
    
    Users::checkAccess($this,'edit','ticketsComments',$this->getUser(),$request->getParameter('projects_id'));
  
    $this->forward404Unless($tickets_comments = Doctrine_Core::getTable('TicketsComments')->find(array($request->getParameter('id'))), sprintf('Object tickets_comments does not exist (%s).', $request->getParameter('id')));
    $this->form = new TicketsCommentsForm($tickets_comments, array('tickets'=>$this->tickets));
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
            
    if($request->getParameter('projects_id')>0)
    {
      $this->forward404Unless($this->projects = Doctrine_Core::getTable('Projects')->createQuery()->addWhere('id=?',$request->getParameter('projects_id'))->addWhere('in_trash is null')->fetchOne(), sprintf('Object projects does not exist (%s).', $request->getParameter('projects_id')));
      $this->forward404Unless($this->tickets = Doctrine_Core::getTable('Tickets')->createQuery()->addWhere('in_trash is null')->addWhere('id=?',$request->getParameter('tickets_id'))->addWhere('projects_id=?',$request->getParameter('projects_id'))->fetchOne(), sprintf('Object tasks does not exist (%s).', $request->getParameter('tickets_id')));
      $this->checkProjectsAccess($this->projects);
      $this->checkTicketsAccess('view',$this->tickets, $this->projects);
    }
    else
    {
      $this->projects = null;
      $this->forward404Unless($this->tickets = Doctrine_Core::getTable('Tickets')->find(array($request->getParameter('tickets_id'))), sprintf('Object tasks does not exist (%s).', $request->getParameter('tickets_id')));
      $this->checkTicketsAccess('view',$this->tickets);
    }
    
    Users::checkAccess($this,'edit','ticketsComments',$this->getUser(),$request->getParameter('projects_id'));
    
    $this->forward404Unless($tickets_comments = Doctrine_Core::getTable('TicketsComments')->find(array($request->getParameter('id'))), sprintf('Object tickets_comments does not exist (%s).', $request->getParameter('id')));
    $this->form = new TicketsCommentsForm($tickets_comments, array('tickets'=>$this->tickets));

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();
    
        
    if($request->getParameter('projects_id')>0)
    {
      $this->forward404Unless($this->projects = Doctrine_Core::getTable('Projects')->createQuery()->addWhere('id=?',$request->getParameter('projects_id'))->addWhere('in_trash is null')->fetchOne(), sprintf('Object projects does not exist (%s).', $request->getParameter('projects_id')));
      $this->forward404Unless($this->tickets = Doctrine_Core::getTable('Tickets')->createQuery()->addWhere('in_trash is null')->addWhere('id=?',$request->getParameter('tickets_id'))->addWhere('projects_id=?',$request->getParameter('projects_id'))->fetchOne(), sprintf('Object tickets does not exist (%s).', $request->getParameter('tickets_id')));
      $this->checkProjectsAccess($this->projects);
      $this->checkTicketsAccess('view',$this->tickets, $this->projects);
    }
    else
    {
      $this->forward404Unless($this->tickets = Doctrine_Core::getTable('Tickets')->find($request->getParameter('tickets_id')), sprintf('Object tasks does not exist (%s).', $request->getParameter('tickets_id')));
      $this->checkTicketsAccess('view',$this->tickets);
    }
    
    Users::checkAccess($this,'delete','ticketsComments',$this->getUser(),$request->getParameter('projects_id'));

    $this->forward404Unless($tickets_comments = Doctrine_Core::getTable('TicketsComments')->find(array($request->getParameter('id'))), sprintf('Object tickets_comments does not exist (%s).', $request->getParameter('id')));
        
    $tickets_comments->setInTrash(1);
    $tickets_comments->setInTrashDate(time());
    $tickets_comments->save();

    $this->redirect('ticketsComments/index?tickets_id=' . $request->getParameter('tickets_id') . ($request->getParameter('projects_id')>0?'&projects_id=' . $request->getParameter('projects_id'):''));
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $tickets = Doctrine_Core::getTable('Tickets')->find($request->getParameter('tickets_id'));
      
      if($form->getObject()->isNew())
      {        
        if($form->getValue('tickets_status_id')>0)
        { 
          $tickets->setTicketsStatusId($form->getValue('tickets_status_id'));
          
          if(in_array($form->getValue('tickets_status_id'),app::getStatusByGroup('closed','TicketsStatus')))
          {
            $tickets->setClosedDate(date('Y-m-d H:i:s'));                
          }
          
          if(!in_array($form->getValue('tickets_status_id'),app::getStatusByGroup('closed','TicketsStatus')))
          {
            $tickets->setClosedDate(null);                
          }  
        } 
        else 
        { 
          unset($form['tickets_status_id']); 
        }
        if($form->getValue('tickets_priority_id')>0){ $tickets->setTicketsPriorityId($form->getValue('tickets_priority_id')); } else { unset($form['tickets_priority_id']); }
        if($form->getValue('tickets_types_id')>0){ $tickets->setTicketsTypesId($form->getValue('tickets_types_id')); } else { unset($form['tickets_types_id']); }      
        if($form->getValue('tickets_groups_id')>0){ $tickets->setTicketsGroupsId($form->getValue('tickets_groups_id')); } else { unset($form['tickets_groups_id']); }
        if($form->getValue('departments_id')>0){ $tickets->setDepartmentsId($form->getValue('departments_id')); } else { unset($form['departments_id']); }        
      }
      
      $tickets->setLastCommentDate(time());      
      $tickets->save();
      
      if($form->getObject()->isNew()){ $form->setFieldValue('created_at',date('Y-m-d H:i:s')); }
      
      $form->protectFieldsValue();
    
      $tickets_comments = $form->save();
      
      Attachments::insertAttachments($request->getFiles(),'ticketsComments',$tickets_comments->getId(),$request->getParameter('attachments_info'),$this->getUser());
      
      if(strlen($tickets->getUserEmail())>0)
      {
        TicketsComments::sendPublicNotification($this,$tickets_comments,$this->getUser());
      }
      else
      {
        TicketsComments::sendNotification($this,$tickets_comments,$this->getUser());
      }

      $this->redirect('ticketsComments/index?tickets_id=' . $request->getParameter('tickets_id') . ($request->getParameter('projects_id')>0?'&projects_id=' . $request->getParameter('projects_id'):''));
    }
  }
  
  public function executeInfo(sfWebRequest $request) 
  {
    if(!$this->c = Doctrine_Core::getTable('TicketsComments')->find($request->getParameter('id')))
    {
      exit();
    }
    
    $this->checkProjectsAccess($this->c->getTickets()->getProjects());
    Users::checkAccess($this,'view','ticketsComments',$this->getUser(),$this->c->getTickets()->getProjects()->getId());
    
  }
  
  
  public function executeCopy(sfWebRequest $request)
  {
    if($request->getParameter('projects_id')>0)
    {
      $this->forward404Unless($this->projects = Doctrine_Core::getTable('Projects')->createQuery()->addWhere('id=?',$request->getParameter('projects_id'))->addWhere('in_trash is null')->fetchOne(), sprintf('Object projects does not exist (%s).', $request->getParameter('projects_id')));
      $this->forward404Unless($this->tickets = Doctrine_Core::getTable('Tickets')->createQuery()->addWhere('in_trash is null')->addWhere('id=?',$request->getParameter('tickets_id'))->addWhere('projects_id=?',$request->getParameter('projects_id'))->fetchOne(), sprintf('Object tasks does not exist (%s).', $request->getParameter('tickets_id')));
      $this->checkProjectsAccess($this->projects);
      $this->checkTicketsAccess('view',$this->tickets, $this->projects);
    }
    else
    {
      $this->projects = null;
      $this->forward404Unless($this->tickets = Doctrine_Core::getTable('Tickets')->find(array($request->getParameter('tickets_id'))), sprintf('Object tasks does not exist (%s).', $request->getParameter('tickets_id')));
      $this->checkTicketsAccess('view',$this->tickets);
    }
    
    Users::checkAccess($this,'insert','ticketsComments',$this->getUser(),$request->getParameter('projects_id'));
    
    
    if($request->isMethod(sfRequest::PUT))
    {      
      $copy_to = $request->getParameter('copy_to');
      
      if($copy_to>0)
      {
        $comments = Doctrine_Core::getTable('TicketsComments')->find($request->getParameter('id'));
        
        if($request->getParameter('comment_action')=='copy')
        {
          $c = new TicketsComments;
          $c->setDescription($comments->getDescription());
          $c->setUsersId($comments->getUsersId());
          $c->setTicketsId($copy_to);
          $c->setCreatedAt(date('Y-m-d H:i:s'));          
          $c->save();
          
          $attachments = Doctrine_Core::getTable('Attachments')
                  ->createQuery()
                  ->addWhere('bind_id=?',$request->getParameter('id'))
                  ->addWhere('bind_type=?','ticketsComments')
                  ->orderBy('id')
                  ->fetchArray();
                  
          foreach ($attachments as $v)
          {
            $a = new Attachments;
            $a->setBindId($c->getId());
            $a->setBindType('ticketsComments');
            $a->setFile($v['file']);
            $a->setInfo($v['info']);
            $a->setDateAdded($v['date_added']);
            $a->setUsersId($v['users_id']);
            $a->save();
          }
        }
        else
        {
          $comments->setTicketsId($copy_to);
          $comments->save();
        }
        
        $this->redirect('ticketsComments/index?tickets_id=' . $request->getParameter('copy_to') . ($request->getParameter('projects_id')>0?'&projects_id=' . $request->getParameter('projects_id'):''));
      }
    }
  }  
}
