<h3 class="page-title"><?php echo __('Contacts') ?></h3>

<?php
$extra_fields = ExtraFieldsList::getFieldsByType('contacts',$sf_user);
$lc = new cfgListingController($sf_context->getModuleName());
?>

<table width="100%">
  <tr>
    <td><?php  echo $lc->insert_button(__('Add Contact')) ?></td>
    <td align="right"><div style="float: right;"><?php include_component('app','searchMenuSimple') ?></div></td>
  </tr>
</table>

<?php include_partial('app/searchResult') ?>

<div <?php echo  (count($contacts_list)==0 ? 'class="table-scrollable"':'')?> >
<table class="table table-striped table-bordered table-hover" id="table-users">
  <thead>
    <tr>
      <th data-bSortable="false" ><?php echo __('Action') ?></th>
      <th width="100%"><?php echo __('Name') ?></th>
      <th><?php echo __('Email') ?></th>
      <th><?php echo __('Group') ?></th>
      <?php echo ExtraFieldsList::renderListingThead($extra_fields) ?>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($contacts_list as $contacts): ?>
    <tr>
      <td><?php echo $lc->action_buttons($contacts['id']) ?></td>
      <td><?php echo link_to_modalbox($contacts['name'],'contacts/info?id=' . $contacts['id']) ?></td>
      <td><?php echo '<a href="mailto: ' . $contacts['email'] . '">' . $contacts['email'] . '</a>' ?></td>
      <td><?php echo app::getArrayName($contacts,'ContactsGroups') ?></td>
      <?php
        $v = ExtraFieldsList::getValuesList($extra_fields,$contacts['id']); 
        echo ExtraFieldsList::renderListingTbody($extra_fields,$v);          
      ?>
    </tr>
    <?php endforeach; ?>
    <?php if(sizeof($contacts_list)==0) echo '<tr><td colspan="6">' . __('No Records Found') . '</td></tr>';?>
  </tbody>
</table>
</div>

<?php if(count($contacts_list)>0)include_partial('global/jsPager',array('table_id'=>'table-users')) ?> 
