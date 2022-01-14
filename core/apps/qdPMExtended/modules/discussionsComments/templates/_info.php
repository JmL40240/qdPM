<ul class="listInfo">
<?php if($c['discussions_status_id']>0): ?>
  <li><?php echo '<span>' . __('Status') . ':</span> ' . $c['DiscussionsStatus']['name'] ?></li>
<?php endif ?>
<?php if($c['discussions_priority_id']>0): ?>
  <li><?php echo '<span>' . __('Priority') . ':</span> ' . $c['DiscussionsPriority']['name'] ?></li>
<?php endif ?>
<?php if($c['discussions_groups_id']>0): ?>
  <li><?php echo '<span>' . __('Group') . ':</span> ' . $c['DiscussionsGroups']['name'] ?></li>
<?php endif ?>
<?php if($c['discussions_types_id']>0): ?>
  <li><?php echo '<span>' . __('Type') . ':</span> ' . $c['DiscussionsTypes']['name'] ?></li>
<?php endif ?> 
</ul>