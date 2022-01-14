<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h4 class="modal-title"><?php echo __('Copy To') ?></h4>
</div>


<form class="form-horizontal" id="copyToForm" action="<?php echo url_for('tasks/copyTo') ?>" method="post">
<div class="modal-body">
  <div class="form-body">
        
<?php echo input_hidden_tag('redirect_to',$sf_request->getParameter('redirect_to')) ?>
<?php if($sf_request->getParameter('projects_id')>0) echo input_hidden_tag('projects_id',$sf_request->getParameter('projects_id')) ?>

<div class="form-group">
	<label class="col-md-3 control-label"><?php echo __('Copy To Project') ?></label>
	<div class="col-md-9">		
    <?php echo select_tag('copy_to',$sf_request->getParameter('projects_id'),array('choices'=>Projects::getChoices('tasks',$sf_user)),array('class'=>'form-control required')) ?>
    <span class="help-block">
      <?php echo __('Note:  Destination Project Team should include all Users assigned to selected Task(s).<br>Users won\'t have access to Tasks if they are assigned to these Tasks but are not in the Project Team')?>
    </span>
	</div>
</div>

<?php echo input_hidden_tag('selected_items',$sf_request->getParameter('tasks_id')) ?>

  </div>
</div>

<?php echo ajax_modal_template_footer(__('Copy')) ?>

</form>

<script>
  set_selected_items();
</script>

<?php include_partial('global/formValidator',array('form_id'=>'copyToForm')); ?>