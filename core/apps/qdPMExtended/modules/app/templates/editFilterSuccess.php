<?php
  switch($sf_context->getModuleName())
  {
    case 'usersProjectsReport':
    case 'projects': $t = 'ProjectsReports';
      break;
    case 'timeReport':  
    case 'usersTasksReport':  
    case 'ganttChart':
    case 'tasks': $t = 'UserReports';
      break;
    case 'tickets': $t = 'TicketsReports';
      break;
  }

  if($r = Doctrine_Core::getTable($t)->find($sf_request->getParameter('edit_user_filter')))
  {
    $name = $r->getName();
    $is_default = $r->getIsDefault();
  }
?>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h4 class="modal-title"><?php echo __('Edit Filter') ?></h4>
</div>

<form class="form-horizontal" id="saveFilter" action="<?php echo url_for($sf_context->getModuleName() . '/doSaveFilter?update_user_filter=' . $sf_request->getParameter('edit_user_filter') . ((int)$sf_request->getParameter('projects_id')>0 ? '&projects_id=' . $sf_request->getParameter('projects_id') : '') )?>" method="post">
  

<div class="modal-body">

  <div class="form-group">
  	<label class="col-md-3 control-label"> <?php echo __('Name') ?> </label>
  	<div class="col-md-9">
  		<?php echo input_tag('name',$name,array('class'=>'form-control required'))?>
  	</div>
  </div>
  
  <div class="form-group">
  	<label class="col-md-3 control-label"> <?php echo __('Default?') ?> </label>
  	<div class="col-md-9">
  		<input type="checkbox" value="1" name="is_default" id="is_default" <?php echo ($is_default==1?'checked="checked"':'')?>>        
      <i><?php echo __('This filter will be used by default after login.') ?></i>
  	</div>
  </div>
  
  <div class="form-group">
  	<label class="col-md-3 control-label"> <?php echo __('Update Filter') ?> </label>
  	<div class="col-md-9">
  		<input type="checkbox" value="1" name="update_values" id="update_values">        
      <i><?php echo __('Current filters will be assigned to this filter.') ?></i>
  	</div>
  </div>
      
<?php echo input_hidden_tag('projects_id',$sf_request->getParameter('projects_id')) ?>      
      
</div>

<div class="modal-footer">
  <button type="submit" class="btn btn-primary"><?php echo __('Save') ?></button>
  <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Close') ?></button>
</div>

</form>
  
<?php include_partial('global/formValidator',array('form_id'=>'saveFilter')); ?>