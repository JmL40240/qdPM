<h3 class="page-title"><?php echo __('Contacts Groups') ?></h3>
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
      <th><?php echo __('Sort Order') ?></th>      
    </tr>
  </thead>
  <tbody>
    <?php foreach ($contacts_groupss as $contacts_groups): ?>
    <tr>
      <td><?php echo $lc->action_buttons($contacts_groups->getId()) ?></td>
      <td><?php echo $contacts_groups->getName() ?></td>
      <td><?php echo $contacts_groups->getSortOrder() ?></td>
    </tr>
    <?php endforeach; ?>
    <?php if(sizeof($contacts_groupss)==0) echo '<tr><td colspan="4">' . __('No Records Found') . '</td></tr>';?>
  </tbody>
</table>
</div>