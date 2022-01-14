<ul class="listInfo">
<?php if($c['departments_id']>0): ?>
  <li><?php echo '<span>' . __('Department') . ':</span> ' . $c['Departments']['name'] ?></li>
<?php endif ?>
<?php if($c['tickets_status_id']>0): ?>
  <li><?php echo '<span>' . __('Status') . ':</span> ' . $c['TicketsStatus']['name'] ?></li>
<?php endif ?>
<?php if($c['tickets_priority_id']>0): ?>
  <li><?php echo '<span>' . __('Priority') . ':</span> ' . $c['TicketsPriority']['name'] ?></li>
<?php endif ?>
<?php if($c['tickets_groups_id']>0): ?>
  <li><?php echo '<span>' . __('Group') . ':</span> ' . $c['TicketsGroups']['name'] ?></li>
<?php endif ?>
<?php if($c['tickets_types_id']>0): ?>
  <li><?php echo '<span>' . __('Type') . ':</span> ' . $c['TicketsTypes']['name'] ?></li>
<?php endif ?>
   
</ul>