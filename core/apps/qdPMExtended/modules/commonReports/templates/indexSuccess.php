<h3 class="page-title"><?php echo __('Common Reports') ?></h3>

<?php
$lc = new cfgListingController($sf_context->getModuleName());
echo $lc->insert_button(__('Add Report'));
?>

<div class="table-scrollable">
	<table class="table table-striped table-bordered table-hover">
  <thead>
    <tr>
      <th><?php echo __('Action') ?></th>            
      <th><?php echo __('Type') ?></th>
      <th width="100%"><?php echo __('Name') ?></th>
      <th><?php echo __('Users Groups') ?></th>
      <th><?php echo __('Display on dashboard') ?></th>      
      <th><?php echo __('Display in menu') ?></th>                  
    </tr>
  </thead>
  <tbody>
   <?php $lc = new cfgListingController('projectsReports','redirect_to=commonReports'); ?>
    <?php foreach ($projects_reports as $reports): ?>
    <tr>      
      <td><?php echo $lc->action_buttons($reports->getId()) ?></td>
      <td><?php echo __('Projects Reports') ?></td>      
      <td><?php echo link_to($reports->getName(),'projectsReports/view?id=' . $reports->getId()) ?></td>
      <td><?php echo UsersGroups::getNameById($reports->getUsersGroupsId()) ?></td>
      <td><?php echo renderBooleanValue($reports->getDisplayOnHome()) ?></td>      
      <td><?php echo renderBooleanValue($reports->getDisplayInMenu()) ?></td>      
    </tr>
    <?php endforeach; ?>
    
    <?php $lc = new cfgListingController('userReports','redirect_to=commonReports'); ?>
    <?php foreach ($user_reports as $reports): ?>
    <tr>      
      <td><?php echo $lc->action_buttons($reports->getId()) ?></td>
      <td><?php echo __('Tasks Reports') ?></td>      
      <td><?php echo link_to($reports->getName(),'userReports/view?id=' . $reports->getId()) ?></td>
      <td><?php echo UsersGroups::getNameById($reports->getUsersGroupsId()) ?></td>
      <td><?php echo renderBooleanValue($reports->getDisplayOnHome()) ?></td>      
      <td><?php echo renderBooleanValue($reports->getDisplayInMenu()) ?></td>      
    </tr>
    <?php endforeach; ?>
    
    
    <?php $lc = new cfgListingController('ticketsReports','redirect_to=commonReports'); ?>
    <?php foreach ($tickets_reports as $reports): ?>
    <tr>      
      <td><?php echo $lc->action_buttons($reports->getId()) ?></td>
      <td><?php echo __('Tickets Reports') ?></td>      
      <td><?php echo link_to($reports->getName(),'ticketsReports/view?id=' . $reports->getId()) ?></td>
      <td><?php echo UsersGroups::getNameById($reports->getUsersGroupsId()) ?></td>
      <td><?php echo renderBooleanValue($reports->getDisplayOnHome()) ?></td>      
      <td><?php echo renderBooleanValue($reports->getDisplayInMenu()) ?></td>      
    </tr>
    <?php endforeach; ?>
    
    
    <?php $lc = new cfgListingController('discussionsReports','redirect_to=commonReports'); ?>
    <?php foreach ($discussions_reports as $reports): ?>
    <tr>      
      <td><?php echo $lc->action_buttons($reports->getId()) ?></td>
      <td><?php echo __('Discussions Reports') ?></td>      
      <td><?php echo link_to($reports->getName(),'discussionsReports/view?id=' . $reports->getId()) ?></td>
      <td><?php echo UsersGroups::getNameById($reports->getUsersGroupsId()) ?></td>
      <td><?php echo renderBooleanValue($reports->getDisplayOnHome()) ?></td>      
      <td><?php echo renderBooleanValue($reports->getDisplayInMenu()) ?></td>      
    </tr>
    <?php endforeach; ?>
    
    
    
    <?php if(sizeof($projects_reports)==0 and sizeof($user_reports)==0 and sizeof($tickets_reports)==0 and sizeof($discussions_reports)==0) echo '<tr><td colspan="6">' . __('No Records Found') . '</td></tr>';?>
  </tbody>
</table>
</div>