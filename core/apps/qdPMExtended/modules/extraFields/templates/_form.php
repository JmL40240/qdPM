<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<?php $form->setDefault('bind_type',$sf_request->getParameter('bind_type')) ?>
<?php if(!$form->getObject()->isNew()) $form->setDefault('users_groups_access',explode(',',$form['users_groups_access']->getValue())) ?>
<?php if(!$form->getObject()->isNew()) $form->setDefault('view_only_access',explode(',',$form['view_only_access']->getValue())) ?>

<form class="form-horizontal" id="extraFields" action="<?php echo url_for('extraFields/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
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
  <?php if($sf_request->getParameter('bind_type')!='users'): ?>
  <li>
    <a href="#tab_access" data-toggle="tab"><?php echo __('Access') ?></a>
  </li>
  <?php endif ?>
</ul>
      
      
<div class="tab-content" >
  <div class="tab-pane fade active in" id="tab_general">
  
    <?php if(ExtraFieldsTabs::countByType($sf_request->getParameter('bind_type'))>0):?>
    <div class="form-group">
    	<label class="col-md-3 control-label"><?php echo $form['extra_fields_tabs_id']->renderLabel() ?></label>
    	<div class="col-md-9">
    	<?php echo $form['extra_fields_tabs_id'] ?>	
    	</div>
    </div>
    <?php endif ?>
  
    <div class="form-group">
    	<label class="col-md-3 control-label"><?php echo $form['name']->renderLabel() ?></label>
    	<div class="col-md-9">
    	<?php echo $form['name'] ?>	
    	</div>
    </div>
    
    <div class="form-group">
    	<label class="col-md-3 control-label"><?php echo $form['type']->renderLabel() ?></label>
    	<div class="col-md-9">
    	<?php echo $form['type'] ?>	
      <div id="default_values_notes"></div>
      <div id="default_values" style="display: none"><?php echo $form['default_values'] ?></div>
    	</div>
    </div>
    
    
    <div class="form-group">
    	<label class="col-md-3 control-label"><?php echo $form['sort_order']->renderLabel() ?></label>
    	<div class="col-md-9">
    	<?php echo $form['sort_order'] ?>	
    	</div>
    </div>
    
    <div class="form-group">
    	<label class="col-md-3 control-label"><?php echo $form['display_in_list']->renderLabel() ?></label>
    	<div class="col-md-9">
    	<?php echo $form['display_in_list'] ?>	
    	</div>
    </div>
    
    <div class="form-group">
    	<label class="col-md-3 control-label"><?php echo $form['is_required']->renderLabel() ?></label>
    	<div class="col-md-9">
    	<?php echo $form['is_required'] ?>	
    	</div>
    </div>
    
    <div class="form-group">
    	<label class="col-md-3 control-label"><?php echo $form['active']->renderLabel() ?></label>
    	<div class="col-md-9">
    	<?php echo $form['active'] ?>	
    	</div>
    </div>
      
  </div>
  
  <?php if($sf_request->getParameter('bind_type')!='users'): ?>  
  <div class="tab-pane fade" id="tab_access">
    <?php echo __('Select User Groups that will have access to Extra Field.<br>By default access is NOT limited.')?>
    <table style="margin-top: 10px;">
    <tr>
      <th><b><?php echo __('Groups') ?></b></th>
      <th style="padding-left: 7px;"><b><?php echo __('Access')?><b></th>
    </tr>
    <?php foreach(UsersGroups::getChoicesByType() as $k=>$v): ?>
      <tr>
        <td><?php echo input_checkbox_tag('extra_fields[users_groups_access][]',$k, array('class'=>'users_groups_access','checked'=>in_array($k,$form['users_groups_access']->getValue()))) . ' <label for="extra_fields_users_groups_access_' . $k . '">' . $v . '</label>' ?></td>
        <td style="padding-left: 7px;"><?php echo select_tag('extra_fields[view_only_access][' . $k . ']',(in_array($k,$form['view_only_access']->getValue()) ? $k:''),array('choices'=>array(''=>__('Edit'),$k=>__('View Only'))),array('style'=>'display:' . (in_array($k,$form['users_groups_access']->getValue()) ? '':'none')))?></td>
      </tr>
    <?php endforeach ?>
    </table>
  </div>
  <?php endif ?>
</div>
  
  </div>
</div>  

<?php echo ajax_modal_template_footer() ?>      
      
</form>

<?php
$n = array();
$n['text'] = __('Simple input text field.');
$n['number'] = __('This field used for numbers.');
$n['formula'] = __('Value of this field will be calculated by formula entered below.<br>Use [Field ID] to setup field value in formula.<br>Example: ([36]+[54])/2<br>Where 36 and 54 are ID of numeric fields.')   . '<br><b>' . __('Formula'). '</b>:';
$n['textarea'] = __('Simple textarea field.');
$n['textarea_wysiwyg'] = __('WYSIWYG editor will be automatically added to this field.');
$n['date_dropdown'] = __('Date with dropdown select');
$n['date_time_dropdown'] = __('Date - Time with dropdown select');
$n['pull_down'] = __('You have to enter default values for this field below.<br>Enter each value in new line.');
$n['checkbox'] = __('You have to enter default values for this field below.<br>Enter each value in new line.');
$n['radiobox'] = __('You have to enter default values for this field below.<br>Enter each value in new line.');

?>

<script type="text/javascript">


  function renderFieldNotes(ftype)
  {
    var n = new Array();
    
    <?php
      foreach($n as $k=>$v)
      {
        echo 'n["' . $k . '"]="' . addslashes($v) . '";' . "\n";
      }
    ?>
    
    if(n[ftype])
    {
      return n[ftype]; 
    }
    else
    {
      return '';
    }
  }
  

  $(function() {            
        
    $("#extra_fields_type").change(function() {         
        $("#default_values_notes").html(renderFieldNotes($(this).val()));
        
        if($(this).val()=='formula' || $(this).val()=='pull_down' || $(this).val()=='checkbox' || $(this).val()=='radiobox')
        {
          $('#default_values').css('display','block');
        }
        else
        {
          $('#default_values').css('display','none');
        }                                     
    });
    
    type = $('#extra_fields_type').val();
    
    $("#default_values_notes").html(renderFieldNotes(type));
    
    if(type=='formula' || type=='pull_down' || type=='checkbox' || type=='radiobox')
    {
      $('#default_values').css('display','block');
    }   
    
    $('.users_groups_access').bind('change', function() {       
       if($(this).attr('checked'))
       {                  
         $('#extra_fields_view_only_access_'+$(this).val()).css('display','')
       }
       else
       {
         $('#extra_fields_view_only_access_'+$(this).val()).val('')
         $('#extra_fields_view_only_access_'+$(this).val()).css('display','none')
       }       
    });
    
       
  });
</script>

<?php include_partial('global/formValidator',array('form_id'=>'extraFields')); ?>
