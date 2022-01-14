<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h4 class="modal-title"><?php echo __('Link Discussions') ?></h4>
</div>

<?php
  $is_filter = array();    
  $is_filter['status'] = app::countItemsByTable('DiscussionsStatus');
  $is_filter['type'] = app::countItemsByTable('DiscussionsTypes');
?>

<form action="<?php echo url_for('discussions/bindDiscussions') ?>" method="post" onSubmit="return hasCheckedInContainer('itmes_listing_<?php echo $tlId ?>')">
<?php echo input_hidden_tag('projects_id',$sf_request->getParameter('projects_id')) ?>
<?php echo input_hidden_tag('related_tasks_id',$sf_request->getParameter('related_tasks_id')) ?>
<?php echo input_hidden_tag('related_tickets_id',$sf_request->getParameter('related_tickets_id')) ?>

<div class="ajax-modal-width-790"></div>

<div class="modal-body">

<table class="table" id="itmes_listing_<?php echo $tlId ?>" >
  <thead>
    <th width="10" class="{sorter: false}"><div></div></th>
    <th><div><?php echo __('Id') ?></div></th>
              
    <?php if($is_filter['type']): ?>
    <th><div><?php echo __('Type') ?></div></th>
    <?php endif; ?>
          
    <th><div><?php echo __('Name') ?></div></th>
    
    <?php if($is_filter['status']): ?>
    <th><div><?php echo __('Status') ?></div></th>
    <?php endif; ?>
                 
    <th><div><?php echo __('Created By') ?></div></th>
  </thead>    
  <tbody>
<?php foreach($discussions_list as $discussions): ?>
    <tr>
      <td><?php echo input_checkbox_tag('discussions[]',$discussions['id']) ?></td>
      <td><?php echo $discussions['id'] ?></td>
                      
      <?php if($is_filter['type']): ?>
      <td><?php echo app::getArrayNameWithBg($discussions, 'DiscussionsTypes') ?></td>
      <?php endif; ?>
                  
      <td>
        <?php echo link_to($discussions['name'],'discussionsComments/index?discussions_id=' . $discussions['id'] . ($discussions['projects_id']>0?'&projects_id=' . $discussions['projects_id']:'')) ?>        
      </td>
            
      <?php if($is_filter['status']): ?>
      <td><?php echo app::getArrayNameWithBg($discussions,'DiscussionsStatus') ?></td>
      <?php endif; ?>
                                              
      <td><?php echo app::getArrayName($discussions,'Users'); ?></td>    
    </tr>  
<?php endforeach ?>
  
  <?php if(sizeof($discussions_list)==0) echo '<tr><td colspan="20">' . __('No Records Found') . '</td></tr>';?>

  </tbody>
</table>
</div>

  <?php echo ajax_modal_template_footer(__('Bind')) ?>
  
</form>

<?php 
  if(count($discussions_list)>0)
  { 
    include_partial('global/jsPagerSimpleSearch',array('table_id'=>'itmes_listing_' . $tlId)); 
  }
?>