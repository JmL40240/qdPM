<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h4 class="modal-title"><?php echo __('Link Tasks') ?></h4>
</div>

<?php
  $is_filter = array();    
  $is_filter['status'] = app::countItemsByTable('TasksStatus');
  $is_filter['label'] = app::countItemsByTable('TasksLabels');
?>

<form action="<?php echo url_for('tasks/bindChildTasks') ?>" method="post" onSubmit="return hasCheckedInContainer('itmes_listing_<?php echo $tlId ?>')">
<?php echo input_hidden_tag('projects_id',$sf_request->getParameter('projects_id')) ?>
<?php echo input_hidden_tag('parent_id',$sf_request->getParameter('parent_id')) ?>

<div class="ajax-modal-width-790"></div>

<div class="modal-body">


<table class="table" id="itmes_listing_<?php echo $tlId ?>">
  <thead>
    <th width="10" class="{sorter: false}"><div></div></th>
    <th><div><?php echo __('Id') ?></div></th>
          
    <?php if($is_filter['label']): ?>
    <th><div><?php echo __('Label') ?></div></th>
    <?php endif; ?>
              
    <th><div><?php echo __('Name') ?></div></th>
    
    <?php if($is_filter['status']): ?>
    <th><div><?php echo __('Status') ?></div></th>
    <?php endif; ?>
                 
    <th><div><?php echo __('Created By') ?></div></th>
  </thead>    
  <tbody>
<?php foreach($tasks_list as $tasks): ?>
    <tr>
      <td><?php echo input_checkbox_tag('tasks[]',$tasks['id']) ?></td>
      <td><?php echo $tasks['id'] ?></td>                
      
      <?php if($is_filter['label']): ?>
      <td><?php echo app::getArrayNameWithBg($tasks, 'TasksLabels') ?></td>
      <?php endif; ?>
                  
      <td>
        <?php echo link_to($tasks['name'],'tasksComments/index?tasks_id=' . $tasks['id'] . ($tasks['projects_id']>0?'&projects_id=' . $tasks['projects_id']:'')) ?>        
      </td>
      
      <?php if($is_filter['status']): ?>
      <td><?php echo app::getArrayNameWithBg($tasks,'TasksStatus') ?></td>
      <?php endif; ?>
                        
                      
      <td><?php echo app::getArrayName($tasks,'Users'); ?></td>    
    </tr>  
<?php endforeach ?>
  
  <?php if(sizeof($tasks_list)==0) echo '<tr><td colspan="20">' . __('No Records Found') . '</td></tr>';?>

  </tbody>
</table>
</div>

  <?php echo ajax_modal_template_footer(__('Bind')) ?>
  
</form>

<?php 
  if(count($tasks_list)>0)
  { 
    include_partial('global/jsPagerSimpleSearch',array('table_id'=>'itmes_listing_' . $tlId)); 
  }
?>