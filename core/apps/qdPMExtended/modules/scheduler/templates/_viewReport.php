<div class="portlet">
<div class="portlet-title"><div class="caption"><?php echo ($users_id>0 ? __('Personal Scheduler'):__('Public Scheduler'))?></div></div>
<div class="portlet-body"> 

<?php
  $is_filter = array();
  $is_filter['priority'] = app::countItemsByTable('EventsPriority');  
  $is_filter['type'] = app::countItemsByTable('EventsTypes');
  
  $extra_fields = ExtraFieldsList::getFieldsByType('events',$sf_user);
?>
<div class="table-scrollable">
	<table class="table table-striped table-bordered table-hover">
  <thead>
    <tr>
      <?php if($is_filter['priority']): ?>
      <th><?php echo __('Priority') ?></th>
      <?php endif; ?>
            
      <?php if($is_filter['type']): ?>
      <th><?php echo __('Type') ?></th>
      <?php endif; ?>
      
      <th width="100%"><?php echo __('Name') ?></th>
      <th><?php echo __('Start Date') ?></th>
      <th><?php echo __('End Date') ?></th>
      
      <?php echo ExtraFieldsList::renderListingThead($extra_fields) ?>
      
    </tr>
  </thead>
  <tbody>
    <?php foreach ($events_list as $events): ?>
    <tr>
      <?php if($is_filter['priority']): ?>
      <td><?php echo app::getNameByTableId('EventsPriority',$events['events_priority_id']); ?></td>
      <?php endif; ?>
      
      <?php if($is_filter['type']): ?>
      <td><?php echo app::getNameByTableId('EventsTypes',$events['events_types_id']) ; ?></td>
      <?php endif; ?>
      
      <td><?php echo '<a class="jt" href="#" onClick="return false" title="<b>' . __('Start Date'). ':</b> ' . app::dateTimeFormat($events['start_date']) . ' - <b>' . __('End Date'). ':</b> ' . app::dateTimeFormat($events['end_date']) . '" rel="' . url_for('scheduler/info?id=' . $events['id']). '">' . $events['event_name'] . '</a>'; ?></td>       
      <td><?php echo app::dateTimeFormat($events['start_date']); ?></td>
      <td><?php echo app::dateTimeFormat($events['end_date']); ?></td>
      
      <?php 
        $v = ExtraFieldsList::getValuesList($extra_fields,$events['id']); 
        echo ExtraFieldsList::renderListingTbody($extra_fields,$v); 
      ?>
    </tr>
    <?php endforeach; ?>
    <?php if(sizeof($events_list)==0) echo '<tr><td colspan="20">' . __('No Events Found') . '</td></tr>';?>
  </tbody>
</table> 
</div>
 
  </div>
</div>