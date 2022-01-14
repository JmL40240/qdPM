
<?php $form->setDefault('extra_fields',explode(',', $form['extra_fields']->getValue())); ?>

<form class="form-horizontal"  id="ticketsTypes" action="<?php echo url_for('ticketsTypes/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<div class="modal-body">
  <div class="form-body">
  
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>

<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>

<?php echo $form->renderHiddenFields(false) ?>
<?php echo $form->renderGlobalErrors() ?>

<ul class="nav nav-tabs">
	<li class="active">
    <a href="#tab_general" data-toggle="tab"><?php echo __('General') ?></a>
  </li>
	<li>
    <a href="#tab_extra_fields" data-toggle="tab"><?php echo __('Extra Fields') ?></a>
  </li>        	  
</ul>

<div class="tab-content" >
    <div class="tab-pane fade active in" id="tab_general">
      <div class="form-group">
      	<label class="col-md-3 control-label"><span class="required">*</span>  <?php echo $form['name']->renderLabel() ?></label>
      	<div class="col-md-9">
      		<?php echo $form['name'] ?>
      	</div>
      </div>
      
      <div class="form-group">
      	<label class="col-md-3 control-label"> <?php echo $form['background_color']->renderLabel() ?></label>
      	<div class="col-md-9">
         <div class="input-group input-small color colorpicker-default" data-color="<?php echo (!$form->getObject()->isNew() ? $form['background_color']->getValue():'#ff0000')?>" >
      		<?php echo $form['background_color'] ?>
          <span class="input-group-btn">
    				<button class="btn btn-default" type="button"><i style="background-color: #3865a8;"></i>&nbsp;</button>
    			</span>
        </div>
      	</div>
      </div>
      
      <div class="form-group">
      	<label class="col-md-3 control-label"> <?php echo $form['default_value']->renderLabel() ?></label>
      	<div class="col-md-9">
      		<p class="form-control-static"><?php echo $form['default_value'] ?></p>
      	</div>
      </div>
      
      <div class="form-group">
      	<label class="col-md-3 control-label"> <?php echo $form['active']->renderLabel() ?></label>
      	<div class="col-md-9">
      		<p class="form-control-static"><?php echo $form['active'] ?></p>
      	</div>
      </div>
      
      <div class="form-group">
      	<label class="col-md-3 control-label"><?php echo $form['sort_order']->renderLabel() ?></label>
      	<div class="col-md-9">
      		<?php echo $form['sort_order'] ?>
      	</div>
      </div>
      
    </div>
    
    <div class="tab-pane fade" id="tab_extra_fields">
      <?php echo __('Select extra fields which will be appear for this type.')?>
        <table>
        <tr>
          <th valign="top"><?php echo $form['extra_fields']->renderLabel() ?></th>
          <td>
            <?php echo $form['extra_fields']->renderError() ?>
            <div id="extra_fields_list"><?php echo $form['extra_fields'] ?><br></div>
            <i><?php if(strlen((string)$form['extra_fields'])==0) echo __('No Extra Fields Found')?></i>
            <?php if(strlen((string)$form['extra_fields'])>0) echo  input_checkbox_tag('set_off_extra_fields',1, array('onClick'=>'set_off_extra_fields_list()','checked'=>($form['extra_fields']->getValue()==array('set_off_extra_fields') ? true:false))) . ' <label for="set_off_extra_fields">' . __('Don\'t use extra fields') . '</label>'; ?>
            
          </td>
        </tr>
        </table>    
    </div>
</div>    

  </div>
</div>
<?php echo ajax_modal_template_footer() ?> 

</form>


<script type="text/javascript">
  $(function() {
        
    <?php if($form['extra_fields']->getValue()==array('set_off_extra_fields')) echo 'set_off_extra_fields_list()' ?>
  });
</script>

<?php include_partial('global/formValidator',array('form_id'=>'ticketsTypes')); ?>