<h3 class="page-title"><?php echo __('Patterns') ?></h3>

<?php
$lc = new cfgListingController($sf_context->getModuleName());
echo $lc->insert_button();
?>
<div class="table-scrollable">
	<table class="table table-striped table-bordered table-hover">
  <thead>
    <tr>
      <th><?php echo __('Action') ?></th>
      <th><?php echo __('Type') ?></th>
      <th width="100%"><?php echo __('Name') ?></th>
      <th><?php echo __('Description') ?></th>            
    </tr>
  </thead>
  <tbody>
    <?php foreach ($patternss as $patterns): ?>
    <tr>
      <td><?php echo $lc->action_buttons($patterns->getId()) ?></td>
      <td><?php echo Patterns::getPatternsTypeById($patterns->getType(),$sf_user) ?></td>
      <td><?php echo $patterns->getName() ?></td>
      <td><?php echo $patterns->getDescription() ?></td>            
    </tr>
    <?php endforeach; ?>
    <?php if(sizeof($patterns)==0) echo '<tr><td colspan="4">' . __('No Records Found') . '</td></tr>';?>
  </tbody>
</table>
</div>
