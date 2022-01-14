<h3 class="page-title"><?php echo __('Projects Roles') ?></h3>
<?php
$lc = new cfgListingController($sf_context->getModuleName());
echo $lc->insert_button();
?>

<div class="table-scrollable">
<table class="table table-striped table-bordered table-hover">
  <thead>
    <tr>
      <th><?php echo __('Action') ?></th>
      
      <th width="100%"><?php echo __('Name') ?></th>
      <th><?php echo __('Projects') ?></th>
      <th><?php echo __('Tasks') ?></th>            
      <th><?php echo __('Tickets') ?></th>
      <th><?php echo __('Discussions') ?></th>            
    </tr>
  </thead>
  <tbody>
    <?php foreach ($users_groupss as $users_groups): ?>
    <tr>
      <td><?php echo $lc->action_buttons($users_groups->getId()) ?></td>      
      <td><?php echo $users_groups->getName() . 
                     ($users_groups->getLdapDefault()==1? '<br><b style="font-size:11px;"> - ' . __('LDAP Default') . '</b>':'') . 
                     ($users_groups->getDefaultValue()==1? '<br><b style="font-size:11px;"> - ' . __('Default Group') . '</b>':'') ?></td>
      <td><?php echo UsersGroups::getAccessTable($users_groups,'projects',false) ?></td>      
      <td><?php echo UsersGroups::getAccessTable($users_groups,'tasks',false) ?></td>
      <td><?php echo UsersGroups::getAccessTable($users_groups,'tickets',false) ?></td>
      <td><?php echo UsersGroups::getAccessTable($users_groups,'discussions',false) ?></td>                
    </tr>
    <?php endforeach; ?>
    <?php if(sizeof($users_groupss)==0) echo '<tr><td colspan="6">' . __('No Records Found') . '</td></tr>';?>
  </tbody>
</table>
</div>
