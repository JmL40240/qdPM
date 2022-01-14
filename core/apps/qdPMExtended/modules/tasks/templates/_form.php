
<?php if($form->getObject()->isNew()) $form->setDefault('projects_id',$sf_request->getParameter('projects_id')) ?>
<?php if($form->getObject()->isNew()) $form->setDefault('created_by',$sf_user->getAttribute('id')) ?>
<?php if(!$form->getObject()->isNew()) $form->setDefault('assigned_to',explode(',',$form['assigned_to']->getValue())) ?>
<?php if($sf_request->getParameter('parent_id')>0) $form->setDefault('parent_id',$sf_request->getParameter('parent_id')) ?>

<form class="form-horizontal" role="form"  id="tasks" action="<?php echo url_for('tasks/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php print 'enctype="multipart/form-data" ' ?>>
<div class="modal-body">
  <div class="form-body">
  
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>

<?php echo $form->renderHiddenFields(false) ?>
<?php echo input_hidden_tag('projects_id',$sf_request->getParameter('projects_id')) ?>
<?php echo input_hidden_tag('redirect_to',$sf_request->getParameter('redirect_to')) ?>
<?php echo input_hidden_tag('related_tickets_id',$sf_request->getParameter('related_tickets_id')) ?>
<?php echo input_hidden_tag('related_discussions_id',$sf_request->getParameter('related_discussions_id')) ?>
<?php echo $form->renderGlobalErrors() ?>

<?php include_component('app','copyToRelated',array('form_name'=>'tasks')) ?>


<ul class="nav nav-tabs">
	<li class="active">
    <a href="#tab_general" data-toggle="tab"><?php echo __('General') ?></a>
  </li>
  <?php echo ExtraFieldsTabs::renderTabsHeaders('tasks',$sf_user) ?>
	<li>
    <a href="#tab_time" data-toggle="tab"><?php echo __('Time') ?></a>
  </li>        	
  <li>
    <a href="#tab_attachments" data-toggle="tab"><?php echo __('Attachments') ?></a>
  </li>
</ul>


        

        <div class="tab-content" >
          <div class="tab-pane fade active in" id="tab_general"> 
          
            <?php if(!$form->getObject()->isNew()): ?>
            <div class="form-group">
            	<label class="col-md-3 control-label"> <?php echo $form['parent_id']->renderLabel() ?></label>
            	<div class="col-md-9">
            		<?php echo $form['parent_id'] ?>
            	</div>
            </div> 
            <?php endif ?>      
                        
            <?php if(app::countItemsByTable('TasksTypes')>0): ?>
            <div class="form-group">
            	<label class="col-md-3 control-label"> <?php echo $form['tasks_type_id']->renderLabel() ?></label>
            	<div class="col-md-9">
            		<?php echo $form['tasks_type_id'] ?>
            	</div>
            </div> 
            <?php endif ?>
            
            
            <div class="form-group">
            	<label class="col-md-3 control-label"><span class="required">*</span> <?php echo $form['name']->renderLabel() ?></label>
            	<div class="col-md-9">
            		<?php echo $form['name'] ?>
            	</div>
            </div> 
       
            
            <?php if(app::countItemsByTable('TasksStatus')>0): ?>
            <div class="form-group">
            	<label class="col-md-3 control-label"> <?php echo $form['tasks_status_id']->renderLabel() ?></label>
            	<div class="col-md-9">
            		<?php echo $form['tasks_status_id'] ?>
                
                <?php
                  if(!$form->getObject()->isNew())
                  { 
                    if(count($tasks_tree = TasksTree::getTasksTree($sf_user,$sf_request->getParameter('projects_id'),$form->getObject()->getId()))>0)
                    { 
                      echo '<div style="margin-top: 5px;">' . input_checkbox_tag('update_child',implode(',',TasksTree::getTasksTreeIdOrder($tasks_tree))) . ' <label for="update_child">' . __('set this status for all child tasks') . '</label></div>';
                    }
                  } 
                  ?>
            	</div>
            </div>
            <?php endif ?>
            
            <?php if(app::countItemsByTable('TasksPriority')>0): ?>
            <div class="form-group">
            	<label class="col-md-3 control-label"> <?php echo $form['tasks_priority_id']->renderLabel() ?></label>
            	<div class="col-md-9">
            		<?php echo $form['tasks_priority_id'] ?>
            	</div>
            </div>
            <?php endif ?>
            
            <?php if(app::countItemsByTable('TasksLabels')>0): ?>
            <div class="form-group">
            	<label class="col-md-3 control-label"> <?php echo $form['tasks_label_id']->renderLabel() ?></label>
            	<div class="col-md-9">
            		<?php echo $form['tasks_label_id'] ?>
            	</div>
            </div>
            <?php endif ?>
            
            <?php if(app::countItemsByTable('TasksGroups',$sf_request->getParameter('projects_id'))>0): ?>
            <div class="form-group">
            	<label class="col-md-3 control-label"> <?php echo $form['tasks_groups_id']->renderLabel() ?></label>
            	<div class="col-md-9">
            		<?php echo $form['tasks_groups_id'] ?>
            	</div>
            </div>
            <?php endif ?>
            
            <?php if(app::countItemsByTable('ProjectsPhases',$sf_request->getParameter('projects_id'))>0): ?>
            <div class="form-group">
            	<label class="col-md-3 control-label"> <?php echo $form['projects_phases_id']->renderLabel() ?></label>
            	<div class="col-md-9">
            		<?php echo $form['projects_phases_id'] ?>
            	</div>
            </div>
            <?php endif ?>
            
            <?php if(app::countItemsByTable('Versions',$sf_request->getParameter('projects_id'))>0): ?>
            <div class="form-group">
            	<label class="col-md-3 control-label"> <?php echo $form['versions_id']->renderLabel() ?></label>
            	<div class="col-md-9">
            		<?php echo $form['versions_id'] ?>
            	</div>
            </div>
            <?php endif ?>
            
            <div class="form-group">
            	<label class="col-md-3 control-label"> <?php echo $form['assigned_to']->renderLabel() ?><br><a href="#" onClick="return checkAllInContainer('assigned_to')"><small><?php echo __('Select All')?></small></a></label>
            	<div class="col-md-9">
            		<div id="assigned_to" class="checkboxesList"><?php echo $form['assigned_to'] ?></div>
            	</div>
            </div>
          
            <?php echo ExtraFieldsList::renderFormFiledsByType('tasks',$form->getObject(),$sf_user,'input')?>
            
            <div class="form-group">
            	<label class="col-md-3 control-label"> <?php echo $form['description']->renderLabel() ?>
              <?php include_component('patterns','patternsList',array('type'=>'tasks_description','field_id'=>'tasks_description'))?>
              </label>
            	<div class="col-md-9">
            		<?php echo $form['description'] ?>
            	</div>
            </div>

            
            <?php echo ExtraFieldsList::renderFormFiledsByType('tasks',$form->getObject(),$sf_user,'text')?>
            <?php echo ExtraFieldsList::renderFormFiledsByType('tasks',$form->getObject(),$sf_user,'file')?>
            
            
            <?php if(Users::hasAccess('edit','tasks',$sf_user,$sf_request->getParameter('projects_id')) and $form->getObject()->isNew()): ?>            
            <div class="form-group">
            	<label class="col-md-3 control-label"> <?php echo $form['created_by']->renderLabel() ?></label>
            	<div class="col-md-9">
            		<?php echo $form['created_by'] ?>
            	</div>
            </div>                       
            <?php endif ?>
                        
          </div>
          
          <?php echo ExtraFieldsTabs::renderTabsContent('tasks',$form->getObject(), $sf_user) ?>
            
          <div class="tab-pane fade" id="tab_time">
          
            <div class="form-group">
            	<label class="col-md-3 control-label"> <?php echo $form['estimated_time']->renderLabel() ?></label>
            	<div class="col-md-9">
            		<?php echo $form['estimated_time'] ?>
            	</div>
            </div> 
            
            <!--<div class="form-group">
            	<label class="col-md-3 control-label"> <?php echo $form['togo_hours']->renderLabel() ?></label>
            	<div class="col-md-9">
            		<?php //echo $form['togo_hours'] ?>
            	</div>
            </div> -->
            
            <div class="form-group">
            	<label class="col-md-3 control-label"> <?php echo $form['start_date']->renderLabel() ?></label>
            	<div class="col-md-9">            	
                <div class="input-group input-medium date datetimepicker"><?php echo $form['start_date'] ?><span class="input-group-btn"><button class="btn btn-default date-set" type="button"><i class="fa fa-calendar"></i></button></span></div>
            	</div>
            </div> 
            
            <div class="form-group">
            	<label class="col-md-3 control-label"> <?php echo $form['due_date']->renderLabel() ?></label>
            	<div class="col-md-9">            		
                <div class="input-group input-medium date datetimepicker"><?php echo $form['due_date'] ?><span class="input-group-btn"><button class="btn btn-default date-set" type="button"><i class="fa fa-calendar"></i></button></span></div>
            	</div>
            </div> 
            <?php if(1 == 99){ ?>
            <div class="form-group">
            	<label class="col-md-3 control-label"> <?php echo $form['progress']->renderLabel() ?></label>
            	<div class="col-md-9">
            		<?php echo $form['progress'] ?>
            	</div>
            </div> 
			<?php } ?>
          </div>
          
          <div class="tab-pane fade" id="tab_attachments">
            <?php include_component('attachments','attachments',array('bind_type'=>'tasks','bind_id'=>($form->getObject()->isNew()?0:$form->getObject()->getId()))) ?>
          </div>
          
        </div>
        
<?php echo ExtraFields::getJsListPerGroup('TasksTypes'); ?>        
        
<?php include_partial('global/formValidatorExt',array('form_id'=>'tasks')); ?>        
        
  </div>
</div>
        
<?php echo ajax_modal_template_footer() ?>        

</form>

<script type="text/javascript">    
  $(function() {             
    set_extra_fields_per_group($('#tasks_tasks_type_id').val());                                                                
  });
</script> 