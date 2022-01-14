<h3 class="page-title"><?php echo __('Discussions Groups') ?></h3>

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
      <th><?php echo __('Sort Order') ?></th>
      <th><?php echo __('Active?') ?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($discussions_groupss as $discussions_groups): ?>
    <tr>
      <td><?php echo $lc->action_buttons($discussions_groups->getId()) ?></td>
      <td><?php echo $discussions_groups->getName() ?></td>
      <td><?php echo renderBooleanValue($discussions_groups->getDefaultValue()) ?></td>
      <td><?php echo $discussions_groups->getSortOrder() ?></td>
      <td><?php echo renderBooleanValue($discussions_groups->getActive()) ?></td>
    </tr>
    <?php endforeach; ?>
    <?php if(count($discussions_groupss)==0) echo '<tr><td colspan="10">' . __('No Records Found') . '</td></tr>';?>
  </tbody>
</table>
</div>
