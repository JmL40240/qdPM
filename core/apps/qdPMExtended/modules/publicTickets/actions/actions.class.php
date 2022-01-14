<?php

/**
 * publicTickets actions.
 *
 * @package    sf_sandbox
 * @subpackage publicTickets
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class publicTicketsActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  
  protected function setAnitspan()
  {
     $v1 = rand(1,20);
     $v2 = rand(1,20);
     
     $this->getUser()->setAttribute('antispam_query',$v1 .'+' . $v2);
     $this->getUser()->setAttribute('antispam_result',($v1+$v2));
  }
  
  protected function checkAccess()
  {
     if(sfConfig::get('app_use_public_tickets')=='off')
     {
       $this->getUser()->setFlash('userNotices', array('text'=>t::__('Public Tickets not allowed.'),'type'=>'error'));
       $this->redirect('dashboard/index');
     }
  }
  
  public function executeIndex(sfWebRequest $request)
  {
    app::setPageTitle('New Ticket',$this->getResponse());
    
    $this->checkAccess();
  
    if(count($choices = Departments::getChoices(array(1,2)))==0) $this->redirect('publicTickets/departmentsError');
    
    $this->setAnitspan();
    
    $this->form = new PublicTicketsForm(null,array('sf_user'=>$this->getUser()));  
  }
  
  public function executeSubmitTicket(sfWebRequest $request)
  {
    $this->checkAccess();

    if(count($choices = Departments::getChoices(array(1,2)))==0) $this->redirect('publicTickets/departmentsError');

    $this->setAnitspan();

    $this->form = new PublicTicketsForm(null,array('sf_user'=>$this->getUser()));
    
    $this->setTemplate('index');
    
    $this->setLayout('submitTicketLayout');
  }
  
  public function executeSubmitProcess(sfWebRequest $request)
  {
    if(!$this->getUser()->hasAttribute('users_group_id'))
    {
      $this->getUser()->setAttribute('users_group_id',0);
    }
    
    $this->form = new PublicTicketsForm(null,array('sf_user'=>$this->getUser()));
    
   
    $this->form->bind($request->getParameter($this->form->getName()));
    if ($this->form->isValid())
    {
      
      $tickets = new Tickets();                      
      $tickets->setUsersId(null);                  
      $tickets->setProjectsId(null);
      $tickets->setMessageId(null);        
                
      if($v = app::getDefaultValueByTable('TicketsStatus')) $tickets->setTicketsStatusId($v);
      if($v = app::getDefaultValueByTable('TicketsTypes')) $tickets->setTicketsTypesId($v);                        
      if($v = app::getDefaultValueByTable('TicketsPriority')) $tickets->setTicketsPriorityId($v);            
      if($v = app::getDefaultValueByTable('TicketsGroups')) $tickets->setTicketsGroupsId($v);
      
            
      $tickets->setDepartmentsId($this->form->getValue('departments_id'));
      $tickets->setName(htmlspecialchars($this->form->getValue('name')));
      $tickets->setDescription(nl2br(htmlspecialchars($this->form->getValue('description'))));
      $tickets->setUserName(htmlspecialchars($this->form->getValue('user_name')));
      $tickets->setUserEmail($this->form->getValue('user_email'));            
      
      $tickets->setCreatedAt(date('Y-m-d H:i:s'));
      $tickets->save();  
      
      $file = $request->getFiles();
      if(isset($file['file']) and sfConfig::get('app_public_tickets_allow_attachments')=='on')
      {
        if(strlen($file['file']['name'])>0)
        {
          $filename = rand(111111,999999)  . '-' . $file['file']['name'];
          if(move_uploaded_file($file['file']['tmp_name'], sfConfig::get('sf_upload_dir') . '/attachments/'  . $filename))
          {                
            $a = new Attachments();
            $a->setFile($filename);    
            $a->setBindType('tickets');            
            $a->setBindId($tickets->getId());
            $a->setDateAdded(time());        
            $a->save();    
          }
        }
      }
      
      if($tickets->getDepartments()->getUseForEmailTickets()!=1)
      {
        $from = array($tickets->getUserEmail()=>$tickets->getUserName());                            
        $to = array($tickets->getDepartments()->getUsers()->getEmail()=>$tickets->getDepartments()->getUsers()->getName());
                 
        $subject = t::__('New Public Ticket') . ': ' .  $tickets->getName() . ($tickets->getTicketsStatusId()>0 ? ' [' . $tickets->getTicketsStatus()->getName() . ']':'');
        $body  = $this->getComponent('tickets','emailBody',array('tickets'=>$tickets));
                    
        Users::sendEmail($from,$to,$subject,$body,$sf_user);
      }
                
        
      $to = array($tickets->getUserEmail()=>$tickets->getUserName());
      
      if($tickets->getDepartments()->getUseForEmailTickets()==1 and strlen($tickets->getDepartments()->getImapLogin())>0)
      {
        $from = array($tickets->getDepartments()->getImapLogin()=>$tickets->getDepartments()->getName());
      }
      else
      {
        $from = array($tickets->getDepartments()->getUsers()->getEmail()=>$tickets->getDepartments()->getUsers()->getName());
      }
      
      $subject = '[ID:' . $tickets->getId() . '] ' . t::__('A new ticket has been opened') . ': ' . $tickets->getName();
      
      $body  = 'Hello [USERNAME],<br><br>A new ticket has been opened up for you.<br><br>Your Ticket ID: [ID] Please reference this ticket # should you contact us.<br><br>Ticket Message:<br>================================================================<br>Detailed description of the issue<br>--------------------------------------------------------------------------------<br>[DESCRIPTION]';
      
      if(strlen(trim(strip_tags($tickets->getDepartments()->getNewTicketMessage())))>0)
      {
        $body = $tickets->getDepartments()->getNewTicketMessage();
      }
      
      $body = str_replace('[USERNAME]',$tickets->getUserName(),$body);
      $body = str_replace('[ID]',$tickets->getId(),$body);
      $body = str_replace('[DESCRIPTION]',$tickets->getDescription(),$body);
                                              
      Users::sendEmail($from,$to,$subject,$body,false,false,false);
      
      $this->getUser()->setFlash('userNotices', t::__('A new Ticket has been opened for you.') . '<br>' . t::__('Your Ticket ID:') . ' <b>'  . $tickets->getId() . '</b><br>' .  t::__('Please reference this ticket # should you contact us.'));
      
      if($request->getParameter('form_type')=='submitTicket')
      {
        $this->redirect('publicTickets/submitTicket');  
      }
      else
      {
        $this->redirect('publicTickets/index');
      }
    } 
    
    $this->setTemplate('index');
    
    if($request->getParameter('form_type')=='submitTicket')
    {
      $this->setLayout('submitTicketLayout');
    }
  }
  
  public function executeDepartmentsError()
  {
  
  }
}
