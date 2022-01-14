<h3 class="page-title"><?php echo __('Projects Priorities') ?></h3>
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
    <?php foreach ($projects_prioritys as $projects_priority): ?>
    <tr>
      <td><?php echo $lc->action_buttons($projects_priority->getId()) ?></td>
      <td><?php echo $projects_priority->getName() ?></td>
      <td><?php echo renderBooleanValue($projects_priority->getDefaultValue()) ?></td>
      <td><?php if(strlen($projects_priority->getIcon())>0) echo image_tag('icons/p/'.$projects_priority->getIcon()) ?></td>
      <td><?php echo $projects_priority->getSortOrder() ?></td>
      <td><?php echo renderBooleanValue($projects_priority->getActive()) ?></td>
    </tr>
    <?php endforeach; ?>
    <?php if(sizeof($projects_prioritys)==0) echo '<tr><td colspan="6">' . __('No Records Found') . '</td></tr>';?>
  </tbody>
</table>
</div>