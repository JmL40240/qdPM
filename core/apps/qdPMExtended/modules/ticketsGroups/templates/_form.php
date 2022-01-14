
<form class="form-horizontal" id="ticketsGroups" action="<?php echo url_for('ticketsGroups/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<div class="modal-body">
  <div class="form-body">
  
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>

<?php echo $form->renderHiddenFields(false) ?>
<?php echo $form->renderGlobalErrors() ?>

  <div class="form-group">
  	<label class="col-md-3 control-label"><span class="required">*</span> <?php echo $form['name']->renderLabel() ?></label>
  	<div class="col-md-9">
  		<?php echo $form['name'] ?>
  	</div>
  </div>
  
  <div class="form-group">
  	<label class="col-md-3 control-label"><?php echo $form['sort_order']->renderLabel() ?></label>
  	<div class="col-md-9">
  		<?php echo $form['sort_order'] ?>
  	</div>
  </div>
  
  <div class="form-group">
  	<label class="col-md-3 control-label"><?php echo $form['default_value']->renderLabel() ?></label>
  	<div class="col-md-9">
  		<p class="form-control-static"><?php echo $form['default_value'] ?></p>
  	</div>
  </div>
  
  <div class="form-group">
  	<label class="col-md-3 control-label"><?php echo $form['active']->renderLabel() ?></label>
  	<div class="col-md-9">
  		<p class="form-control-static"><?php echo $form['active'] ?></p>
  	</div>
  </div>

    </div>  
</div>  

<?php echo ajax_modal_template_footer() ?>

</form>

<?php include_partial('global/formValidator',array('form_id'=>'ticketsGroups')); ?>



