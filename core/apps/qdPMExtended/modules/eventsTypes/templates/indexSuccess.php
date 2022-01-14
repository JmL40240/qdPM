<h3 class="page-title"><?php echo __('Events Types') ?></h3>
<?php
$lc = new cfgListingController($sf_context->getModuleName());
echo $lc->insert_button() . ' ' .  $lc->sort_button();
?>

<div class="table-scrollable">
	<table class="table table-striped table-bordered table-hover">
  <thead>
    <tr>
      <th><?php echo __('Action') ?></th>
      <th width="100%"><?php echo __('Name') ?></th>
      <th><?php echo __('Default?') ?></th>
      <th><?php echo __('Background') ?></th>
      <th><?php echo __('Sort Order') ?></th>
      <th><?php echo __('Active?') ?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($events_typess as $events_types): ?>
    <tr>
      <td><?php echo $lc->action_buttons($events_types->getId()) ?></td>      
      <td><?php echo $events_types->getName() ?></td>
      <td><?php echo renderBooleanValue($events_types->getDefaultValue()) ?></td>
      <td><?php echo renderBackgroundColorBlock($events_types->getBackgroundColor(),$events_types->getBackgroundColor()) ?></td>
      <td><?php echo $events_types->getSortOrder() ?></td>
      <td><?php echo renderBooleanValue($events_types->getActive()) ?></td>            
    </tr>
    <?php endforeach; ?>
    <?php if(sizeof($events_typess)==0) echo '<tr><td colspan="5">' . __('No Records Found') . '</td></tr>';?>
  </tbody>
</table>
</div>
