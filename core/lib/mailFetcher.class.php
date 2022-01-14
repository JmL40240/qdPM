<?php

class mailFetcher
{
  public function text_decode($str)
  {                
      $text = '';
      $charset = null;
            
      $text_array = imap_mime_header_decode($str);
             
      foreach ($text_array as $v)
      {
        $text .= rtrim($v->text, "\t");
        $charset = $v->charset;
      }
          
      if($charset=='default')
      {
        $charset = 'UTF-8';
      }
      
      return $this->mime_encode($text,'',$charset);            
  }
  
  
  public function decode($encoding,$text) 
  {              
    switch($encoding) {
        case 1:
        $text=imap_8bit($text);
        break;
        case 2:
        $text=imap_binary($text);
        break;
        case 3:
        $text=imap_base64($text);
        break;
        case 4:
        $text=imap_qprint($text);
        break;
        case 5:
        default:
         $text=$text;
    } 
    return $text;
  }
  
  
  public function create_part_array($struct) 
  {
      if (sizeof($struct->parts) > 0) 
      {    // There some sub parts
          foreach ($struct->parts as $count => $part) 
          {
              $this->add_part_to_array($part, ($count+1), $part_array);
          }
      }else
      {    // Email does not have a seperate mime attachment for text
          $part_array[] = array('part_number' => '1', 'part_object' => $struct);
      }
     return $part_array;
  }
  
  // Sub public function for create_part_array(). Only called by create_part_array() and itself. 
  public function add_part_to_array($obj, $partno, & $part_array) 
  {
      $part_array[] = array('part_number' => $partno, 'part_object' => $obj);
      if ($obj->type == 2) 
      { // Check to see if the part is an attached email message, as in the RFC-822 type
          //print_r($obj);
          if (sizeof($obj->parts) > 0) 
          {    // Check to see if the email has parts
              foreach ($obj->parts as $count => $part) 
              {
                  // Iterate here again to compensate for the broken way that imap_fetchbody() handles attachments
                  if (sizeof($part->parts) > 0) 
                  {
                      foreach ($part->parts as $count2 => $part2) 
                      {
                          $this->add_part_to_array($part2, $partno.".".($count2+1), $part_array);
                      }
                  }
                  else
                  {    // Attached email does not have a seperate mime attachment for text
                      $part_array[] = array('part_number' => $partno.'.'.($count+1), 'part_object' => $obj);
                  }
              }
          }
          else
          {    // Not sure if this is possible
              $part_array[] = array('part_number' => $prefix.'.1', 'part_object' => $obj);
          }
      }
      else
      {    // If there are more sub-parts, expand them out.
          if (sizeof($obj->parts) > 0) 
          {
              foreach ($obj->parts as $count => $p) 
              {
                  $this->add_part_to_array($p, $partno.".".($count+1), $part_array);
              }
          }
      }
  }
  
  public function get_part_info_by_subtype($part_array,$subtype)
  {
    foreach($part_array as $value)
    {
      if($value['part_object']->subtype==$subtype)
      {
        return array('part_number'=>$value['part_number'],'encoding'=>$value['part_object']->encoding,'parameters'=>$value['part_object']->parameters);
      }
    }
    
    return false;
  }
  
  public function get_attachments($part_array)
  {
    reset($part_array);
    
    $attachments = array();
  
    foreach($part_array as $value)
    {    
      if($value['part_object']->ifdparameters=='1' && $value['part_object']->dparameters[0]->value)
      {
        $attachments[] = array('part_number'=>$value['part_number'],'encoding'=>$value['part_object']->encoding,'filename'=>$value['part_object']->dparameters[0]->value);      
      }
      
      if(($value['part_object']->subtype=='PNG' or $value['part_object']->subtype=='JPEG' or $value['part_object']->subtype=='GIF' or $value['part_object']->subtype=='BMP') and $value['part_object']->ifdparameters=='0')
      {
        $attachments[] = array('part_number'=>$value['part_number'],'encoding'=>$value['part_object']->encoding,'filename'=>$value['part_object']->parameters[0]->value,'id'=>str_replace(array('<','>'),'',$value['part_object']->id));      
      }
          
    }
    
    if(sizeof($attachments)>0)
    {
      return $attachments;
    }
    else
    {
      return false;
    }        
  }
  
  
  public function format_text_message($message)
  {
    $text = '';
    $message_array = explode("\n",$message);      
    foreach($message_array as $v)
    {      
      if(strlen(trim($v))>0)
      {
        $text .= $v . '<br>';
        $setbr = false;
      }
      elseif(!$setbr)
      {
        $setbr = true;
        $text .= '<br>';
      }    
    }
    
    return $text;
  }
  
  //Convert text to desired encoding..defaults to utf8
  public function mime_encode($text,$parameters,$charset=null,$enc='utf-8') { //Thank in part to afterburner  
              
      $encodings=array('UTF-8','WINDOWS-1251', 'ISO-8859-5', 'ISO-8859-1','KOI8-R');
      
      if(is_array($parameters))
      {
        foreach($parameters as $v)
        {
          if($v->attribute=='charset')
          {
            $charset = $v->value;
          }
        }
      }  
      
      if(function_exists("iconv") and $text) {
          if($charset)
              return quoted_printable_decode(iconv($charset,$enc.'//IGNORE',$text));
          elseif(function_exists("mb_detect_encoding"))
              return quoted_printable_decode(iconv(mb_detect_encoding($text,$encodings),$enc,$text));
      }
  
      return quoted_printable_decode(utf8_encode($text));
  }
  
  public function insert_attachments($mbox, $msg_number, $attachments_list, $ticketId,$bindType, $message)
  {
    if(is_array($attachments_list))
    {
      foreach($attachments_list as $v)
      {
      
        $filename = rand(111111,999999)  . '-' . $v['filename'];
        
        $file_contnt = $this->decode($v['encoding'],imap_fetchbody($mbox,$msg_number,$v['part_number']));
        
        file_put_contents(sfConfig::get('sf_upload_dir') . '/attachments/' . $filename,$file_contnt,FILE_TEXT|FILE_APPEND|LOCK_EX);
                      
        $attachment = new Attachments();
        $attachment->setBindType($bindType);
        $attachment->setBindId($ticketId);
        $attachment->setInfo('');
        $attachment->setFile($filename);
        $attachment->setDateAdded(time());
        $attachment->save();
                
        if($v['id'])
        {
          $message['body'] = str_replace('cid:' . $v['id'],'attachments/view/id/' . $attachment->getId(),$message['body']);
                                        
          $image = getimagesize(sfConfig::get('sf_upload_dir') . '/attachments/' . $filename);
                   
          if($image[0]>400)
          {
            $cof =  $image[0]/400;
            $width_small=400;
            $height_small = $image[1]/$cof;
          
            $message['body'] = str_replace('src="attachments/view/id/' . $attachment->getId() . '"','src="attachments/view/id/' . $attachment->getId() . '" style="cursor:pointer; width:' . $width_small . 'px; height:' . $height_small . 'px;" onClick="location.href=\'attachments/view/id/' . $attachment->getId() . '\'"',$message['body']);
          }                    
        }
      }
    
    }
    
    return $message;        
  }
    
  function protect_html_text($message)
  {          
    $tags_list = '<applet><button><del><iframe><ins><object>';
    $tags_list .= '<source><video>';
    $tags_list .= '<noscript><script>'; 
    $tags_list .= '<applet><embed><noembed><object><param>';
    $tags_list .= '<frame><frameset><iframe><noframes>';
    //$tags_list .= '<style><head>';
    //$tags_list .= '<area><canvas><img><map>';
                          
    foreach($message as $k=>$v)
    {
      if($k=='subject' or $k=='from_name' or $k=='from_email' or $k=='body')
        $message[$k] = $this->strip_only(trim($v),$tags_list);
    }
    
    return $message;
  }  
  
  function strip_only($str, $tags) {
    if(!is_array($tags)) {
        $tags = (strpos($str, '>') !== false ? explode('>', str_replace('<', '', $tags)) : array($tags));
        if(end($tags) == '') array_pop($tags);
    }
    foreach($tags as $tag) $str = preg_replace('#</?'.$tag.'[^>]*>#is', '', $str);
    
    $str = preg_replace("'<!--.*?-->'si", '', $str);
    
    return $str;
  }                             
  
  public function fetch()
  {        
	$connection = Doctrine_Manager::connection();  
    $connection->execute("SET sql_mode =''"); 
  
    $departments_list = Doctrine_Core::getTable('Departments')->createQuery()->addWhere('use_for_email_tickets=?',1)->execute();
    
    if(!$departments_list) die("Errror: there are no departments configured for email tickets");
        
    foreach($departments_list as $departments)
    {
          
      $imap_server = "{" . trim($departments->getImapServer()) . "}" . trim($departments->getImapMailbox());
      $imap_login  = $departments->getImapLogin();
      $imap_pass = $departments->getImapPass();
      
      $mbox = imap_open($imap_server,$imap_login,$imap_pass) or die("Error: can't connect: " . imap_last_error());
                      
      if($msg_numbers_list = imap_search($mbox,'SINCE ' . date("d-M-Y",strtotime('-1 day'))))                
      {                                        
        krsort($msg_numbers_list);
                
        foreach($msg_numbers_list as $msg_number)
        {
           $message = array();
      
           $header = imap_header($mbox, $msg_number);
           $structure = imap_fetchstructure($mbox, $msg_number);
                  
           $message['subject']     = $this->text_decode($header->subject);
           $message['from_name']   = (isset($header->from[0]->personal) ? $this->text_decode($header->from[0]->personal) : '');
           $message['from_email']  = $header->from[0]->mailbox . '@' . $header->from[0]->host;          
           $message['date']        = $header->date;
           $message['message_id']  = $header->message_id;                                                       
          
          $part_array = $this->create_part_array($structure);   
        
          if($part_info = $this->get_part_info_by_subtype($part_array,'HTML'))
          {                                                                                                                                         
            $message['body'] =  $this->mime_encode($this->decode($part_info['encoding'],imap_fetchbody($mbox,$msg_number,$part_info['part_number'])),$part_info['parameters']);
          }
          elseif($part_info = $this->get_part_info_by_subtype($part_array,'PLAIN'))
          {
            $message['body'] = $this->mime_encode($this->decode($part_info['encoding'],imap_fetchbody($mbox,$msg_number,$part_info['part_number'])),$part_info['parameters']);        
            $message['body'] = $this->format_text_message($message['body']);        
          }
                    
                    
          $message['body'] = preg_replace('/<head>([^`]*?)<\/head>/', '', $message['body']);
          $message['body'] = preg_replace('/<style>([^`]*?)<\/style>/', '', $message['body']);
                                                                                                     
          $message['attachments'] = $this->get_attachments($part_array);
          
          $message = $this->protect_html_text($message);
                                                                   
          //echo '<pre>';                                      
          //print_r($message);                                                          
          //print_r($part_array);
          //exit();
                                          
          $action = '';
                                        
          if(Doctrine_Core::getTable('Tickets')->createQuery()->addWhere('message_id=?',$message['message_id'])->count()==0)
          {                                 
            $action = 'create_new_ticket';
            
            if(preg_match('/^.*\[ID:(.*)\].*$/', $message['subject'], $regs))
            {        
              $ticketId = $regs[1];
                            
              if($ticket = Doctrine_Core::getTable('Tickets')->find($ticketId))
              {
                $action='create_new_ticket_comment';
                                
                if(Doctrine_Core::getTable('TicketsComments')->createQuery()->addWhere('tickets_id=?',$ticketId)->addWhere('message_id=?',$message['message_id'])->count()==0)
                {                            
                  $tickets_comments = new TicketsComments();              
                  $tickets_comments->setTicketsId($ticketId);
                  if($tickets_status = app::getDefaultValueByTable('TicketsStatus'))
                  {
                    $tickets_comments->setTicketsStatusId($tickets_status);
                    
                    $ticket->setTicketsStatusId($tickets_status);
                    $ticket->save(); 
                  }
                  $tickets_comments->setDescription($message['body']);
                  $tickets_comments->setUserName($message['from_name']);
                  $tickets_comments->setUserEmail($message['from_email']);
                  $tickets_comments->setUsersId(null);
                  $tickets_comments->setMessageId($message['message_id']);
                  $tickets_comments->setCreatedAt(date('Y-m-d H:i:s'));
                  $tickets_comments->save();
                  
                  $message = $this->insert_attachments($mbox,$msg_number,$message['attachments'],$tickets_comments->getId(),'ticketsComments',$message);
                  
                  $tickets_comments->setDescription($message['body']);
                  $tickets_comments->save();
                  
                  $ticket->setLastCommentDate(time());      
                  $ticket->save();
                  
                                                                       
                }
              }
            }          
          }
          
          if($action == 'create_new_ticket')
          {                       
            $tickets = new Tickets();                      
            $tickets->setUsersId(null);                  
            $tickets->setProjectsId(null);        
                      
            if($v = app::getDefaultValueByTable('TicketsStatus')) $tickets->setTicketsStatusId($v);
            if($v = app::getDefaultValueByTable('TicketsTypes')) $tickets->setTicketsTypesId($v);                        
            if($v = app::getDefaultValueByTable('TicketsPriority')) $tickets->setTicketsPriorityId($v);            
            if($v = app::getDefaultValueByTable('TicketsGroups')) $tickets->setTicketsGroupsId($v);
            
            $tickets->setDepartmentsId($departments->getId());
            $tickets->setName($message['subject']);
            $tickets->setDescription($message['body']);
            $tickets->setUserName($message['from_name']);
            $tickets->setUserEmail($message['from_email']);            
            $tickets->setMessageId($message['message_id']);
            $tickets->setCreatedAt(date('Y-m-d H:i:s'));
            $tickets->save();  
            
            $message = $this->insert_attachments($mbox,$msg_number,$message['attachments'],$tickets->getId(),'tickets',$message);
                                    
            $tickets->setDescription($message['body']);
            $tickets->save();   
            
            $to = array($tickets->getUserEmail()=>$tickets->getUserName());
            $from = array($departments->getImapLogin()=>$departments->getName());
            $subject = '[ID:' . $tickets->getId() . '] ' . t::__('A new ticket has been opened') . ': ' . $tickets->getName();
            
            $body  = 'Hello [USERNAME],<br><br>A new ticket has been opened up for you.<br><br>Your Ticket ID: [ID] Please reference this ticket # should you contact us.<br><br>Ticket Message:<br>================================================================<br>Detailed description of the issue<br>--------------------------------------------------------------------------------<br>[DESCRIPTION]';
            
            if(strlen(trim(strip_tags($departments->getNewTicketMessage())))>0)
            {
              $body = $departments->getNewTicketMessage();
            }
            
            $body = str_replace('[USERNAME]',$tickets->getUserName(),$body);
            $body = str_replace('[ID]',$tickets->getId(),$body);
            $body = str_replace('[DESCRIPTION]',$tickets->getDescription(),$body);
                                                    
            Users::sendEmail($from,$to,$subject,$body,false,false,false);
                                       
          } 
                
          if($departments->getImapDeleteEmails()==1)
          {
            imap_delete($mbox, $msg_number);        
          }
                 
        }  
      }
      
      //Delete all messages marked for deletion
      imap_expunge($mbox);
        
      //Close an IMAP stream  
      imap_close($mbox);
    }
  }

}