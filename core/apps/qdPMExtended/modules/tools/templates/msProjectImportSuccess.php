<h3 class="page-title"><?php echo __('Import Tasks from MS Project')?></h3>

<div><?php echo __('You can import tasks from MS Project in XML format.')?></div><br>

<form  class="form-horizontal" id="import" action="<?php echo url_for('tools/msProjectImport')?>" method="post" enctype="multipart/form-data">
<input type="hidden" name="sf_method" value="put" />

<div class="form-group">
  	<label class="col-md-3 control-label"><?php echo __('Project') ?></label>
  	<div class="col-md-9">
  		<?php echo select_tag('projects_id',$sf_request->getParameter('project'),array('choices'=>Projects::getChoices('',$sf_user)),array('class'=>'form-control input-medium required'))?>
  	</div>
  </div> 
  
  <div class="form-group">
  	<label class="col-md-3 control-label"><?php echo __('File') ?></label>
  	<div class="col-md-9">
  		<input type="file" name="import_file" class="required">
  	</div>
  </div>  

  <?php echo submit_tag(__('Import')) ?>
</form>

<?php include_partial('global/formValidator',array('form_id'=>'import')); ?>