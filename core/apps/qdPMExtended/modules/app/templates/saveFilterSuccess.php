
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h4 class="modal-title"><?php echo __('Save Filter') ?></h4>
</div>


<form class="form-horizontal" id="saveFilter" action="<?php echo url_for($sf_context->getModuleName() . '/doSaveFilter' . ((int)$sf_request->getParameter('projects_id')>0 ? '?projects_id=' . $sf_request->getParameter('projects_id') : ''))?>" method="post">

<div class="modal-body">

  <div class="form-group">
  	<label class="col-md-3 control-label"> <?php echo __('Name') ?> </label>
  	<div class="col-md-9">
  		<?php echo input_tag('name','',array('class'=>'form-control required'))?>
  	</div>
  </div>
  
  <div class="form-group">
  	<label class="col-md-3 control-label"> <?php echo __('Default?') ?> </label>
  	<div class="col-md-9">
  		<input type="checkbox" value="1" name="is_default" id="is_default">        
      <i><?php echo __('This filter will be used by default after login.') ?></i>
  	</div>
  </div>
      
</div>

<div class="modal-footer">
  <button type="submit" class="btn btn-primary"><?php echo __('Save') ?></button>
  <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Close') ?></button>
</div>

</form>

<?php include_partial('global/formValidator',array('form_id'=>'saveFilter')); ?>