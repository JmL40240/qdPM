<ul class="listInfo">
<?php if($c['projects_priority_id']>0): ?>
  <li><?php echo '<span>' . __('Priority') . ':</span> ' . $c['ProjectsPriority']['name'] ?></li>
<?php endif ?>  
<?php if($c['projects_types_id']>0): ?>
  <li><?php echo '<span>' . __('Type') . ':</span> ' . $c['ProjectsTypes']['name'] ?></li>
<?php endif ?>  
<?php if($c['projects_groups_id']>0): ?>
  <li><?php echo '<span>' . __('Group') . ':</span> ' . $c['ProjectsGroups']['name'] ?></li>
<?php endif ?>  
<?php if($c['projects_status_id']>0): ?>
  <li><?php echo '<span>' . __('Status') . ':</span> ' . $c['ProjectsStatus']['name'] ?></li>
<?php endif ?>  
</ul>