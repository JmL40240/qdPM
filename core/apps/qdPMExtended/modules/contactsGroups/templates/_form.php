<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form class="form-horizontal" id="contactsGroups" action="<?php echo url_for('contactsGroups/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
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
  
      </div>
</div>  
        
<?php echo ajax_modal_template_footer() ?>
</form>

<?php include_partial('global/formValidator',array('form_id'=>'contactsGroups')); ?>
