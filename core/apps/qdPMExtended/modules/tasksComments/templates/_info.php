<ul class="listInfo">
<?php if($c['tasks_status_id']>0): ?>
  <li><?php echo '<span>' . __('Status') . ':</span> ' . $c['TasksStatus']['name'] ?></li>
<?php endif ?>
<?php if($c['tasks_priority_id']>0): ?>
  <li><?php echo '<span>' . __('Priority') . ':</span> ' . $c['TasksPriority']['name'] ?></li>
<?php endif ?>
<?php if($c['tasks_labels_id']>0): ?>
  <li><?php echo '<span>' . __('Label') . ':</span> ' . $c['TasksLabels']['name'] ?></li>
<?php endif ?>
<?php if($c['tasks_types_id']>0): ?>
  <li><?php echo '<span>' . __('Type') . ':</span> ' . $c['TasksTypes']['name'] ?></li>
<?php endif ?>
<?php if(strlen($c['due_date'])>0): ?>
  <li><?php echo '<span>' . __('Due Date') . ':</span> ' . app::dateTimeFormat($c['due_date']) ?></li>
<?php endif ?>
<?php if($c['worked_hours']>0): ?>
  <li><?php echo '<span>' . __('Work Hours') . ':</span> ' . $c['worked_hours'] ?></li>
<?php endif ?>
<?php if($c['togo_hours']>0): ?>
  <li><?php echo '<span>' . __('Hours To Go') . ':</span> ' . $c['togo_hours'] ?></li>
<?php endif ?>    
<?php if($c['progress']>0): ?>
  <li><?php echo '<span>' . __('Progress') . ':</span> ' . $c['progress'] ?></li>
<?php endif ?>   
</ul>