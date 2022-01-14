<h3 class="page-title"><?php echo __('Discussions Types') ?></h3>
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
    <?php foreach ($discussions_typess as $discussions_types): ?>
    <tr>
      <td><?php echo $lc->action_buttons($discussions_types->getId()) ?></td>      
      <td><?php echo $discussions_types->getName() ?></td>
      <td><?php echo renderBooleanValue($discussions_types->getDefaultValue()) ?></td>
      <td><?php echo renderBackgroundColorBlock($discussions_types->getBackgroundColor(),$discussions_types->getBackgroundColor()) ?></td>
      <td><?php echo $discussions_types->getSortOrder() ?></td>
      <td><?php echo renderBooleanValue($discussions_types->getActive()) ?></td>            
    </tr>
    <?php endforeach; ?>
    <?php if(sizeof($discussions_typess)==0) echo '<tr><td colspan="5">' . __('No Records Found') . '</td></tr>';?>
  </tbody>
</table>
</div>
