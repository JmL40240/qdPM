<h3 class="page-title"><?php echo __('My Account') ?></h3>

<form class="form-horizontal"  id="users" action="<?php echo url_for('myAccount/update') ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
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
  <?php echo ExtraFieldsTabs::renderTabsHeaders('users',$sf_user) ?>
</ul>      

<div class="tab-content" >
  <div class="tab-pane fade active in" id="tab_general"> 
  
  <div class="form-group">
  	<label class="col-md-3 control-label"> <?php echo __('Group') ?></label>
  	<div class="col-md-9">
  		<p class="form-control-static"><?php $user = $sf_user->getAttribute('user'); echo $user->getUsersGroups()->getName(); ?></p>
  	</div>
  </div>
  
  <div class="form-group">
  	<label class="col-md-3 control-label"><span class="required">*</span> <?php echo $form['name']->renderLabel() ?></label>
  	<div class="col-md-9">
  		<?php echo $form['name'] ?>
  	</div>
  </div>
  
  <div class="form-group">
  	<label class="col-md-3 control-label"> <?php echo $form['new_password']->renderLabel() ?></label>
  	<div class="col-md-9">
  		<?php echo $form['new_password'] ?>
  	</div>
  </div>
  
  <div class="form-group">
  	<label class="col-md-3 control-label"><span class="required">*</span> <?php echo $form['email']->renderLabel() ?></label>
  	<div class="col-md-9">
  		<?php echo $form['email'] ?>
      <div id="email_error" class="error"></div>
  	</div>
  </div>
  
  <?php echo ExtraFieldsList::renderFormFileds('users',$form->getObject(),$sf_user) ?>
  
  <div class="form-group">
  	<label class="col-md-3 control-label"> <?php echo $form['photo']->renderLabel() ?></label>
  	<div class="col-md-9">
  		<?php echo $form['photo'] ?>
      <div><?php if(strlen($form['photo']->getValue())>0) echo renderUserPhoto($form['photo']->getValue())  . '<br>'. $form['remove_photo'] . ' ' . $form['remove_photo']->renderLabel() ?></div>
  	</div>
  </div>
  
  <div class="form-group">
  	<label class="col-md-3 control-label"> <?php echo $form['culture']->renderLabel() ?></label>
  	<div class="col-md-9">
  		<?php echo $form['culture'] ?>
  	</div>
  </div>
  
  <div class="form-group">
  	<label class="col-md-3 control-label"> <?php echo $form['default_home_page']->renderLabel() ?></label>
  	<div class="col-md-9">
  		<?php echo $form['default_home_page'] ?>
  	</div>
  </div>
  
  </div>
   <?php echo ExtraFieldsTabs::renderTabsContent('users',$form->getObject(), $sf_user) ?>    
</div>    

  </div>
</div>  


              
  <div class="modal-footer">    
    <input type="button" class="btn btn-primary" value="<?php echo __('Save')?>" id="submit_button" onClick="check_user_form('users','<?php echo url_for('users/checkUser' . (!$form->getObject()->isNew()? '?id=' . $form->getObject()->getId():'' )) ?>')"/>
    
    <div>      
      <?php if($form->getObject()->isNew()) echo '&nbsp;&nbsp;' . $form['notify'] . '&nbsp;' . $form['notify']->renderLabel(); ?>
      <div id="loading" ></div>    
    </div>
  </div>
</form>

<?php include_partial('global/formValidator',array('form_id'=>'users')); ?>

<?php echo ExtraFields::getJsListPerGroup('UsersGroups'); ?>

<script type="text/javascript">    
  $(function() {     

    set_extra_fields_per_group($('#users_users_group_id').val());
    
    $("#submit_button").click(function() {
        $("#users").valid()                              
    });
              
  });
</script> 
