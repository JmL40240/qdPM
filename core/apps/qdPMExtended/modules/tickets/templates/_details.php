<?php if(Users::hasAccess('view','tasks',$sf_user,$sf_request->getParameter('projects_id')))  include_component('tasks','relatedTasksToTickets',array('tickets_id'=>$tickets->getId(),'is_email'=>isset($is_email))) ?>
<?php if(Users::hasAccess('view','discussions',$sf_user,$sf_request->getParameter('projects_id'))) include_component('discussions','relatedDiscussionsToTickets',array('tickets_id'=>$tickets->getId(),'is_email'=>isset($is_email))) ?>

<div class="table-scrollable">
<table class="table table-bordered table-hover table-item-details">
  <tr>
    <th><?php echo __('Id') ?>:</th>
    <td><?php echo $tickets->getId() ?></td>
  </tr>
  
  <tr>
    <th><?php echo __('Department') ?>:</th>
    <td><?php echo $tickets->getDepartments()->getName() ?>
<?php
  if($tickets->getDepartments_id()>0)
  {
    echo '<br>' . renderUserPhoto($tickets->getDepartments()->getUsers()->getPhoto(),array('width'=>'28','style'=>'width:28px; margin-bottom: 2px;'))  . '&nbsp;' . $tickets->getDepartments()->getUsers()->getName()  . '<br>';
  }
?>      
    </td>
  </tr>
  
  <?php if($tickets->getTicketsStatusId()>0) echo '<tr><th>' . __('Status') . ':</th><td>' . $tickets->getTicketsStatus()->getName() . '</td></tr>';?>
  <?php if($tickets->getClosedDate()) echo '<tr><th>' . __('Closed') . ':</th><td>' . app::dateTimeFormat($tickets->getClosedDate()) . '</td></tr>';?>
  <?php if($tickets->getTicketsPriorityId()>0) echo '<tr><th>' . __('Priority') . ':</th><td>' . $tickets->getTicketsPriority()->getName() . '</td></tr>';?>
  <?php if($tickets->getTicketsTypesId()>0) echo '<tr><th>' . __('Type') . ':</th><td>' . $tickets->getTicketsTypes()->getName() . '</td></tr>';?>
  <?php if($tickets->getTicketsGroupsId()>0) echo '<tr><th>' . __('Group') . ':</th><td>' . $tickets->getTicketsGroups()->getName() . '</td></tr>';?>
      
  <?php if(!isset($is_email)) $is_email = false; ?>    
  <?php echo ExtraFieldsList::renderInfoFileds('tickets',$tickets,$sf_user,$tickets->getTicketsTypes()->getExtraFields(),array(),$is_email) ?>
    
  <tr><td style="padding-top: 7px;"></td></tr>
      
  <tr>
    <th><?php echo __('Created At') ?>:</th>
    <td><?php echo app::dateTimeFormat($tickets->getCreatedAt()) ?></td>
  </tr>  
  
  <tr>
    <th><?php echo __('Created By') ?>:</th>
    <td>
<?php
  if($tickets->getUsersId()>0)
  {
    echo renderUserPhoto($tickets->getUsers()->getPhoto(),array('width'=>'28','style'=>'width:28px; margin-bottom: 2px;'))  . '&nbsp;' . $tickets->getUsers()->getName()  . '<br>';
  }
  else
  {
    echo $tickets->getUserName()  . '<br>' . $tickets->getUserEmail() ;
  }   
?>      
    </td>
  </tr>  
</table>
</div>
