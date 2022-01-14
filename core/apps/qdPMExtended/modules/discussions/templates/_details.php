<?php if(Users::hasAccess('view','tasks',$sf_user,$sf_request->getParameter('projects_id'))) include_component('tasks','relatedTasksToDiscussions',array('discussions_id'=>$discussions->getId(),'is_email'=>isset($is_email))) ?>
<?php if(Users::hasAccess('view','tickets',$sf_user,$sf_request->getParameter('projects_id'))) include_component('tickets','relatedTicketsToDiscussions',array('discussions_id'=>$discussions->getId(),'is_email'=>isset($is_email))) ?>

<div class="table-scrollable">
<table class="table table-bordered table-hover table-item-details">
  <tr>
    <th><?php echo __('Id') ?>:</th>
    <td><?php echo $discussions->getId() ?></td>
  </tr>
    
  <?php if($discussions->getDiscussionsStatusId()>0) echo '<tr><th>' . __('Status') . ':</th><td>' . $discussions->getDiscussionsStatus()->getName() . '</td></tr>';?>
  <?php if($discussions->getDiscussionsPriorityId()>0) echo '<tr><th>' . __('Priority') . ':</th><td>' . $discussions->getDiscussionsPriority()->getName() . '</td></tr>';?>
  <?php if($discussions->getDiscussionsTypesId()>0) echo '<tr><th>' . __('Type') . ':</th><td>' . $discussions->getDiscussionsTypes()->getName() . '</td></tr>';?>
  <?php if($discussions->getDiscussionsGroupsId()>0) echo '<tr><th>' . __('Group') . ':</th><td>' . $discussions->getDiscussionsGroups()->getName() . '</td></tr>';?>
      
  <?php if(!isset($is_email)) $is_email = false; ?>    
  <?php echo ExtraFieldsList::renderInfoFileds('discussions',$discussions,$sf_user,$discussions->getDiscussionsTypes()->getExtraFields(),array(),$is_email) ?>
         
  <tr>
    <th><?php echo __('Assigned To') ?>:</th>
    <td>
<?php
  foreach(explode(',',$discussions->getAssignedTo()) as $users_id)
  {
    if($user = Doctrine_Core::getTable('Users')->find($users_id))
    {
      echo  renderUserPhoto($user->getPhoto(),array('width'=>'28','style'=>'width:28px; margin-bottom: 2px;'))  . '&nbsp;' . $user->getName()  . '<br>';
    }
  }
  
  if(strlen($discussions->getAssignedTo())==0) echo __('No Assigned Users');
?>     
    </td>
  </tr> 
  <tr>
    <th><?php echo __('Created At') ?>:</th>
    <td><?php echo app::dateTimeFormat($discussions->getCreatedAt()) ?></td>
  </tr>
  <tr>
    <th><?php echo __('Created By') ?>:</th>
    <td>
<?php
  if($discussions->getUsersId()>0)
  {
    echo  renderUserPhoto($discussions->getUsers()->getPhoto(),array('width'=>'28','style'=>'width:28px; margin-bottom: 2px;'))  . '&nbsp;' . $discussions->getUsers()->getName()  . '<br>';
  }   
?>    
    </td>
  </tr>   
</table>
</div>
