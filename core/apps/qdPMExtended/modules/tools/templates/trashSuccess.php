<h3 class="page-title"><?php echo __('Trash') ?></h3>

<div>
  <?php 
    if(count($trash)>0) 
    { 
      echo button_to(__('Empty Trash'),'tools/trashEmpty',array('confirm'=>__('Are you sure?'),'class'=>'btn btn-primary')) . ' ' . link_to_mmodalbox(__('Restore Selected'),'tools/trashRestore');
    } 
  ?>
</div>

<table class="table table-striped table-bordered table-hover"  class="tableListing"  id="tableListing">
  <thead>
    <tr>
      <th data-bsortable="false"style="width: 20px;"><input name="multiple_selected_all" id="multiple_selected_all" class="group-checkable" data-set="#tableListing .checkboxes"  type="checkbox"></th>
      <th data-bsortable="false"><?php echo __('Date Added') ?></th>
      <th data-bsortable="false"><?php echo __('Type') ?></th>
      <th data-bsortable="false" width="20%"><?php echo __('Name') ?></th>
      <th data-bsortable="false" width="60%"><?php echo __('Description') ?></th>
    </tr>
  </thead>
  <tbody>
<?php foreach($trash as $t): ?>
    <tr>
      <td><input name="multiple_selected[]" id="multiple_selected_<?php echo $t['type']  . '_'. $t['id'] ?>" type="checkbox" value="<?php echo $t['type']  . '_'. $t['id']  ?>" class="multiple_selected checkboxes"</td>
      <td><?php echo date(app::getDateTimeFormat(),$t['date']); ?></td>
      <td><?php
        switch($t['type'])
        {
          case 'Projects': echo __('Project');
            break;
          case 'Tasks': echo __('Task');
            break;
          case 'Tickets': echo __('Ticket');
            break;
          case 'Discussions': echo __('Discussion');
            break;
          case 'ProjectsComments': echo __('Comment for project');
            break;
          case 'TasksComments': echo __('Comment for task');
            break;
          case 'TicketsComments': echo __('Comment for ticket');
            break;
          case 'DiscussionsComments': echo __('Comment for discussion');
            break;
        }
      ?></td>
      <td  style="white-space:normal"><?php echo $t['name']; ?></td>
      <td style="white-space:normal"><?php echo $t['description']; ?></td>
    </tr>
<?php endforeach ?>
<?php if(count($trash)==0) echo '<tr><td colspan="20">' . __('No Records Found') . '</td></tr>';?>
   <tbody>
</table>

<?php include_partial('global/jsTips'); ?>


<?php
if(count($trash)>0)
{  
  include_partial('global/jsPager',array('table_id'=>'tableListing'));
}
?>  


