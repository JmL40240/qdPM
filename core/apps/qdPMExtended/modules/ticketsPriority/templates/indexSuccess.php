<h3 class="page-title"><?php echo __('Tickets Priorities') ?></h3>
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
      <th><?php echo __('Icon') ?></th>
      <th><?php echo __('Sort Order') ?></th>
      <th><?php echo __('Active?') ?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($tickets_prioritys as $tickets_priority): ?>
    <tr>
      <td><?php echo $lc->action_buttons($tickets_priority->getId()) ?></td>
      <td><?php echo $tickets_priority->getName() ?></td>
      <td><?php echo renderBooleanValue($tickets_priority->getDefaultValue()) ?></td>    
      <td><?php if(strlen($tickets_priority->getIcon())>0) echo image_tag('icons/p/'.$tickets_priority->getIcon()) ?></td>
      <td><?php echo $tickets_priority->getSortOrder() ?></td>      
      <td><?php echo renderBooleanValue($tickets_priority->getActive()) ?></td>
    </tr>
    <?php endforeach; ?>
    <?php if(sizeof($tickets_prioritys)==0) echo '<tr><td colspan="6">' . __('No Records Found') . '</td></tr>';?>
  </tbody>
</table>
</div>
