<div class="table-scrollable">
<table class="table table-bordered table-hover table-item-details"> 
  <tr>
    <th><?php echo __('Id') ?>:</th>
    <td><?php echo $projects->getId() ?></td>
  </tr>
  <?php if($projects->getProjectsPriorityId()>0) echo '<tr><th>' . __('Priority') . ':</th><td>' . $projects->getProjectsPriority()->getName() . '</td></tr>';?>
  <?php if($projects->getProjectsStatusId()>0) echo '<tr><th>' . __('Status') . ':</th><td>' . $projects->getProjectsStatus()->getName() . '</td></tr>';?>
  <?php if($projects->getProjectsTypesId()>0) echo '<tr><th>' . __('Type') . ':</th><td>' . $projects->getProjectsTypes()->getName() . '</td></tr>';?>
  <?php if($projects->getProjectsGroupsId()>0) echo '<tr><th>' . __('Group') . ':</th><td>' . $projects->getProjectsGroups()->getName() . '</td></tr>';?>
  
  <?php if(!isset($is_email)) $is_email = false; ?>
  <?php echo ExtraFieldsList::renderInfoFileds('projects',$projects,$sf_user,$projects->getProjectsTypes()->getExtraFields(),array(),$is_email) ?>
  
  
  <tr>
    <th><?php echo __('Team') ?>:</th>
    <td>
<?php
  foreach(explode(',',$projects->getTeam()) as $users_id)
  {
    if($user = Doctrine_Core::getTable('Users')->find($users_id))
    {
      echo  renderUserPhoto($user->getPhoto())  . ' ' . $user->getName()  . '<br>';
    }
  }
  if(strlen($projects->getTeam())==0) echo __('No Assigned Users');
?>      
    </td>
  </tr> 
  <tr>
    <th><?php echo __('Created At') ?>:</th>
    <td><?php echo app::dateTimeFormat($projects->getCreatedAt()) ?></td>
  </tr>  
  <tr>
    <th><?php echo __('Created By') ?>:</th>
    <td><?php echo $projects->getUsers()->getName() ?></td>
  </tr>  
</table>
</div>