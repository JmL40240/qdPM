<h3 class="page-title"><?php echo __('From Tabs') . ' (' . __($sf_request->getParameter('bind_type')) . ')' ?></h3>

<?php
$lc = new cfgListingController($sf_context->getModuleName(),'bind_type=' . $sf_request->getParameter('bind_type','projects'));
echo $lc->insert_button() . ' ' .  $lc->sort_button(). ' ' . button_to_tag(__('Back to Extra Fields'),'extraFields/index?bind_type=' . $sf_request->getParameter('bind_type'));
?>
<div class="table-scrollable">
<table class="table table-striped table-bordered table-hover">
  <thead>
    <tr>
      <th><?php echo __('Action') ?></th>
      <th width="100%"><?php echo __('Name') ?></th> 
      <th><?php echo __('Access') ?></th>     
      <th><?php echo __('Sort Order') ?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($extra_fields_tabss as $extra_fields_tabs): ?>
    <tr>
      <td><?php echo $lc->action_buttons($extra_fields_tabs->getId()) ?></td>
      <td><?php echo $extra_fields_tabs->getName() ?></td> 
      <td><?php if(strlen($extra_fields_tabs->getUsersGroupsAccess())>0) { echo UsersGroups::getNameById($extra_fields_tabs->getUsersGroupsAccess()); } ?></td>     
      <td><?php echo $extra_fields_tabs->getSortOrder() ?></td>
    </tr>
    <?php endforeach; ?>
    <?php if(count($extra_fields_tabss)==0) echo '<tr><td colspan="3">' . __('No Records Found') . '</td></tr>';?>
  </tbody>
</table>
</div>