

<form class="form-horizontal"  id="contacts" action="<?php echo url_for('contacts/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<div class="modal-body">
  <div class="form-body">

<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>

<?php echo $form->renderHiddenFields(false) ?>
<?php echo $form->renderGlobalErrors() ?>


<ul class="nav nav-tabs">
	<li class="active">
    <a href="#tab_general" data-toggle="tab"><?php echo __('General') ?></a>
  </li>
  <?php echo ExtraFieldsTabs::renderTabsHeaders('contacts',$sf_user) ?>

</ul>

      
<div class="tab-content" >
  <div class="tab-pane fade active in" id="tab_general">
  
  
    <div class="form-group">
    	<label class="col-md-3 control-label"><span class="required">*</span> <?php echo $form['name']->renderLabel() ?></label>
    	<div class="col-md-9">
    		<?php echo $form['name'] ?>
    	</div>
    </div>  
    
    <div class="form-group">
    	<label class="col-md-3 control-label"><span class="required">*</span> <?php echo $form['email']->renderLabel() ?></label>
    	<div class="col-md-9">
    		<?php echo $form['email'] ?>
    	</div>
    </div> 
    
    <div class="form-group">
    	<label class="col-md-3 control-label"><?php echo $form['contacts_groups_id']->renderLabel() ?></label>
    	<div class="col-md-9">
    		<?php echo $form['contacts_groups_id'] ?>
    	</div>
    </div> 
  
              
    <?php echo ExtraFieldsList::renderFormFileds('contacts',$form->getObject(),$sf_user) ?>
          
  </div>
           
  <?php echo ExtraFieldsTabs::renderTabsContent('contacts',$form->getObject(), $sf_user) ?> 
            
</div>

  </div>
</div>

<?php echo ajax_modal_template_footer() ?> 

</form>
 
<?php include_partial('global/formValidator',array('form_id'=>'contacts')); ?>
