
<?php 
  
if($form->getObject()->isNew())
{  
  $start_date_timestamp = $sf_request->getParameter('start')/1000;
  $end_date_timestamp = $sf_request->getParameter('end')/1000;
  
  $offset=date('Z');
      
  if($offset<0)
  {    
    $start_date_timestamp+=abs($offset);
    $end_date_timestamp+=abs($offset);
  }
  else
  {
    $start_date_timestamp-=abs($offset);
    $end_date_timestamp-=abs($offset);
  }
            
  if($sf_request->getParameter('view_name')=='month')
  {
    $start_date = date('Y-m-d',$start_date_timestamp);
    $end_date = date('Y-m-d',strtotime('-1 day',$end_date_timestamp));
  }  
  else
  { 
    $start_date = date('Y-m-d H:i',$start_date_timestamp);
    $end_date = date('Y-m-d H:i',$end_date_timestamp);       
  }
}     

?>
<?php if($form->getObject()->isNew()) $form->setDefault('start_date', $start_date) ?>
<?php if($form->getObject()->isNew()) $form->setDefault('end_date', $end_date) ?>
<?php if($form->getObject()->isNew() and $sf_request->getParameter('users_id')>0) $form->setDefault('users_id', $sf_request->getParameter('users_id')) ?>

<?php $form->setDefault('repeat_days',explode(',', $form['repeat_days']->getValue())); ?>
    
<form class="form-horizontal" id="scheduler" action="<?php echo url_for('scheduler/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php print 'enctype="multipart/form-data" ' ?>>
<div class="modal-body">
  <div class="form-body">
  
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>

<?php echo $form->renderHiddenFields(false) ?>
<?php echo input_hidden_tag('users_id', $sf_request->getParameter('users_id')) ?>

<?php echo $form->renderGlobalErrors() ?>


<ul class="nav nav-tabs">
	<li class="active">
    <a href="#tab_general" data-toggle="tab"><?php echo __('General') ?></a>
  </li>
  <?php echo ExtraFieldsTabs::renderTabsHeaders('events',$sf_user) ?>
	<li>
    <a href="#tab_repeat" data-toggle="tab"><?php echo __('Repeat') ?></a>
  </li>        	
  <li>
    <a href="#tab_attachments" data-toggle="tab"><?php echo __('Attachments') ?></a>
  </li>
</ul>
        
<div class="tab-content" >
    <div class="tab-pane fade active in" id="tab_general">
    
    <?php if(app::countItemsByTable('EventsPriority')>0): ?>
      <div class="form-group">
      	<label class="col-md-3 control-label"> <?php echo $form['events_priority_id']->renderLabel() ?></label>
      	<div class="col-md-9">
      		<?php echo $form['events_priority_id'] ?>
      	</div>
      </div>
    <?php endif ?>
    
    <?php if(app::countItemsByTable('EventsTypes')>0): ?>
      <div class="form-group">
      	<label class="col-md-3 control-label"> <?php echo $form['events_types_id']->renderLabel() ?></label>
      	<div class="col-md-9">
      		<?php echo $form['events_types_id'] ?>
      	</div>
      </div>
    <?php endif ?>
    
      <div class="form-group">
      	<label class="col-md-3 control-label"><span class="required">*</span>  <?php echo $form['event_name']->renderLabel() ?></label>
      	<div class="col-md-9">
      		<?php echo $form['event_name'] ?>
      	</div>
      </div>
      
      <?php echo ExtraFieldsList::renderFormFileds('events',$form->getObject(),$sf_user)?>
      
      <div class="form-group">
      	<label class="col-md-3 control-label"> <?php echo $form['start_date']->renderLabel() ?></label>
      	<div class="col-md-9">
      		<div class="input-group input-medium date datetimepicker"><?php echo $form['start_date'] ?><span class="input-group-btn"><button class="btn btn-default date-set" type="button"><i class="fa fa-calendar"></i></button></span></div>
      	</div>
      </div>
      
      <div class="form-group">
      	<label class="col-md-3 control-label"> <?php echo $form['end_date']->renderLabel() ?></label>
      	<div class="col-md-9">
      		<div class="input-group input-medium date datetimepicker"><?php echo $form['end_date'] ?><span class="input-group-btn"><button class="btn btn-default date-set" type="button"><i class="fa fa-calendar"></i></button></span></div>
      	</div>
      </div>
      
      <div class="form-group">
      	<label class="col-md-3 control-label"> <?php echo $form['description']->renderLabel() ?></label>
      	<div class="col-md-9">
      		<?php echo $form['description'] ?>
      	</div>
      </div>
      
      <?php if($sf_request->getParameter('users_id')>0 and $sf_user->hasCredential('public_scheduler_access_full_access')): ?>
      <div class="form-group">
      	<label class="col-md-3 control-label"> <?php echo $form['public_status']->renderLabel() ?></label>
      	<div class="col-md-9">
      		<p class="form-control-static"><?php echo $form['public_status'] ?></p>
      	</div>
      </div>
      <?php endif ?>
                      
  </div>
          
  <?php echo ExtraFieldsTabs::renderTabsContent('events',$form->getObject(), $sf_user) ?>
          
    <div class="tab-pane fade" id="tab_repeat">
    
      <div class="form-group">
      	<label class="col-md-3 control-label"> <?php echo $form['repeat_type']->renderLabel() ?></label>
      	<div class="col-md-9">
      		<?php echo $form['repeat_type'] ?>
      	</div>
      </div>
      
      <div class="form-group">
      	<label class="col-md-3 control-label"> <?php echo $form['repeat_interval']->renderLabel() ?></label>
      	<div class="col-md-9">
      		<?php echo $form['repeat_interval'] ?>
      	</div>
      </div>
      
      <div class="form-group" id="events_repeat_days_tr">
      	<label class="col-md-3 control-label"> <?php echo $form['repeat_days']->renderLabel() ?></label>
      	<div class="col-md-9">
      		<?php echo $form['repeat_days'] ?>
      	</div>
      </div>
      
      <div class="form-group">
      	<label class="col-md-3 control-label"> <?php echo $form['repeat_end']->renderLabel() ?></label>
      	<div class="col-md-9">
      		<div class="input-group input-medium date datepicker"><?php echo $form['repeat_end'] ?><span class="input-group-btn"><button class="btn btn-default date-set" type="button"><i class="fa fa-calendar"></i></button></span></div>
      	</div>
      </div>
      
      <div class="form-group">
      	<label class="col-md-3 control-label"> <?php echo $form['repeat_limit']->renderLabel() ?></label>
      	<div class="col-md-9">
      		<?php echo $form['repeat_limit'] ?>
      	</div>
      </div>  
    </div>
    
    <div class="tab-pane fade" id="tab_attachments">
      <?php include_component('attachments','attachments',array('bind_type'=>'events','bind_id'=>($form->getObject()->isNew()?0:$form->getObject()->getId()))) ?>
    </div>
          
</div>

  </div>
</div>

<?php echo ajax_modal_template_footer(false,(!$form->getObject()->isNew() ? '<a href="javascript: delete_event();" title="' . __('Delete') . '" class="btn btn-default"><i class="fa fa-trash-o"></i></a> ':'')) ?>  

</form>

<?php echo ExtraFields::getJsListPerGroup('EventsTypes'); ?>

<?php //include_partial('global/formValidator',array('form_id'=>'scheduler')); ?>

<script type="text/javascript">    
  $(function() {                                                           
    check_event_repeat_type($('#events_repeat_type').val())             
    set_extra_fields_per_group($('#events_events_types_id').val());
    
    $('#scheduler').validate({
      submitHandler: function(form)
      {
        $.ajax({type: "POST",
          //url: '<?php echo url_for("ext/calendar/personal","action=save" . (isset($_GET["id"]) ? "&id=" . $_GET["id"] : ''))?>',
          url: $('#scheduler').prop('action'),
          data: $('#scheduler').serializeArray() 
          }).done(function() {
            $('#ajax-modal').modal('hide')
            $('#calendar').fullCalendar('refetchEvents');
          });                    
      }
    });   
                                                                                                                  
  });
  
  function delete_event()
  {
    if(confirm('<?php echo __('Are you sure?') ?>'))
    {
      $.ajax({type: "POST",
          url: '<?php if(!$form->getObject()->isNew()) echo url_for('scheduler/delete?id=' . $form->getObject()->getId() . '&users_id=' . $form->getObject()->getUsersId()) ?>',           
          }).done(function() {
            $('#ajax-modal').modal('hide')
            $('#calendar').fullCalendar('refetchEvents');
          }); 
    }
  }  
  
  
  
</script> 
