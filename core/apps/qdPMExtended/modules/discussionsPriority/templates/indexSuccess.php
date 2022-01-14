<h3 class="page-title"><?php echo __('Discussions Priorities') ?></h3>
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
    <?php foreach ($discussions_prioritys as $discussions_priority): ?>
    <tr>
      <td><?php echo $lc->action_buttons($discussions_priority->getId()) ?></td>
      <td><?php echo $discussions_priority->getName() ?></td>
      <td><?php echo renderBooleanValue($discussions_priority->getDefaultValue()) ?></td>      
      <td><?php if(strlen($discussions_priority->getIcon())>0) echo image_tag('icons/p/'.$discussions_priority->getIcon()) ?></td>
      <td><?php echo $discussions_priority->getSortOrder() ?></td>    
      <td><?php echo renderBooleanValue($discussions_priority->getActive()) ?></td>
    </tr>
    <?php endforeach; ?>
    <?php if(sizeof($discussions_prioritys)==0) echo '<tr><td colspan="6">' . __('No Records Found') . '</td></tr>';?>
  </tbody>
</table>
</div>
