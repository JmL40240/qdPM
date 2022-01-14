<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<?php $form->setDefault('bind_type',$sf_request->getParameter('bind_type')) ?>
<?php if(!$form->getObject()->isNew()) $form->setDefault('users_groups_access',explode(',',$form['users_groups_access']->getValue())) ?>

<form class="form-horizontal"  id="extraFieldsTabs" action="<?php echo url_for('extraFieldsTabs/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<div class="modal-body">
  <div class="form-body">
  
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>

<?php echo $form->renderHiddenFields(false) ?>
<?php echo input_hidden_tag('bind_type',$sf_request->getParameter('bind_type')) ?>
<?php echo $form->renderGlobalErrors() ?>



<ul class="nav nav-tabs">
	<li class="active">
    <a href="#tab_general" data-toggle="tab"><?php echo __('General') ?></a>
  </li>    
  <?php if($sf_request->getParameter('bind_type')!='users' and $sf_request->getParameter('bind_type')!='contacts' and $sf_request->getParameter('bind_type')!='events'): ?>
  <li>
    <a href="#tab_access" data-toggle="tab"><?php echo __('Access') ?></a>
  </li>
  <?php endif ?>
</ul>

<div class="tab-content" >
  <div class="tab-pane fade active in" id="tab_general">
    
    <div class="form-group">
    	<label class="col-md-3 control-label"><?php echo $form['name']->renderLabel() ?></label>
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
  
  <?php if($sf_request->getParameter('bind_type')!='users' and $sf_request->getParameter('bind_type')!='contacts' and $sf_request->getParameter('bind_type')!='events'): ?>  
    <div class="tab-pane fade" id="tab_access">
      <?php echo __('Select user groups which will have access to Form Tab.<br>By default access is not limited.')?>
      
      <div class="form-group">
      	<label class="col-md-3 control-label"><?php echo $form['users_groups_access']->renderLabel() ?></label>
      	<div class="col-md-9">
      	 <?php echo $form['users_groups_access'] ?>	
      	</div>
      </div>
    </div>
    <?php endif ?>
  
</div>  
  
  </div>
</div>

<?php echo ajax_modal_template_footer() ?>  
</form>


<?php include_partial('global/formValidator',array('form_id'=>'extraFieldsTabs')); ?>
