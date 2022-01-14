<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<?php if($form->getObject()->isNew()) $form->setDefault('created_by',$sf_user->getAttribute('id')) ?>

<form class="form-horizontal"  action="<?php echo url_for('tasksComments/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php print 'enctype="multipart/form-data" ' ?>>
<div class="modal-body">
  <div class="form-body">
  
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" id="sf_method" value="put" />
<?php endif; ?>
  
  
<?php echo $form->renderHiddenFields(false) ?>
<?php echo input_hidden_tag('projects_id',$sf_request->getParameter('projects_id')) ?>
<?php echo input_hidden_tag('tasks_id',$sf_request->getParameter('tasks_id')) ?>
<?php echo input_hidden_tag('set_worked_hours',$sf_request->getParameter('set_worked_hours')) ?>
            
<?php echo $form->renderGlobalErrors() ?>
  
<ul class="nav nav-tabs">
	<li class="active">
    <a href="#tab_general" data-toggle="tab"><?php echo __('Réalisé (J)') ?></a>
  </li>
        
  <!--<li>
    <a href="#tab_attachments" data-toggle="tab"><?php //echo __('Attachments') ?></a>
  </li>-->
</ul>



  <div class="tab-content" >
    <div class="tab-pane fade active in" id="tab_general">
        
      <div class="row">
      
      
      <?php if($form->getObject()->isNew()){ ?>
      
        <div class="col-md-6">
		
		     <div class="form-group">
              	<label class="col-md-4 control-label"> <?php echo $form['worked_hours']->renderLabel() ?></label>
              	<div class="col-md-8">
              		<?php echo $form['worked_hours'] ?>
              	</div>
              </div>
			  
			   <?php if(sfConfig::get('app_allow_adit_tasks_comments_date')=='on'):?>
            <div class="form-group">
            	<label class="col-md-4 control-label"> <?php echo $form['created_at']->renderLabel() ?></label>
            	<div class="col-md-8">
            		<div class="control-label"><?php echo $form['created_at'] ?></div>
            	</div>
            </div>            
          <?php endif ?>
              
              <?php /*if(app::countItemsByTable('TasksStatus')>0  and $form->getObject()->isNew()){*/ if(1 == 99){ ?>              
              <div class="form-group">
              	<label class="col-md-4 control-label"> <?php echo $form['tasks_status_id']->renderLabel() ?></label>
              	<div class="col-md-8">
              		<?php echo $form['tasks_status_id'] ?>
                  <?php 
                    if(count($tasks_tree = TasksTree::getTasksTree($sf_user,$sf_request->getParameter('projects_id'),$sf_request->getParameter('tasks_id')))>0)
                    { 
                      echo '<div style="margin-top: 5px;">' . input_checkbox_tag('update_child',implode(',',TasksTree::getTasksTreeIdOrder($tasks_tree))) . ' <label for="update_child">' . __('set this status for all child tasks') . '</label></div>';
                    } 
                  ?>
              	</div>
              </div> 
              <?php /*endif*/ }?>
              
              
        <?php /*if(Users::hasTasksAccess('edit',$sf_user,$tasks, $projects)  and $form->getObject()->isNew()){ */ if(1==99){ ?>
          
		  
		  
              <?php if(app::countItemsByTable('TasksPriority')>0): ?>
              <div class="form-group">
              	<label class="col-md-4 control-label"> <?php echo $form['tasks_priority_id']->renderLabel() ?></label>
              	<div class="col-md-8">
              		<?php echo $form['tasks_priority_id'] ?>
              	</div>
              </div>   
              <?php endif ?>
                                                     
              <?php if(app::countItemsByTable('TasksLabels')>0): ?>
              <div class="form-group">
              	<label class="col-md-4 control-label"> <?php echo $form['tasks_labels_id']->renderLabel() ?></label>
              	<div class="col-md-8">
              		<?php echo $form['tasks_labels_id'] ?>
              	</div>
              </div>
              <?php endif ?>
              
              <?php if(app::countItemsByTable('TasksTypes')>0): ?>
              <div class="form-group">
              	<label class="col-md-4 control-label"> <?php echo $form['tasks_types_id']->renderLabel() ?></label>
              	<div class="col-md-8">
              		<?php echo $form['tasks_types_id'] ?>
              	</div>
              </div>
              <?php endif ?>
              
              
              <div class="form-group">
              	<label class="col-md-4 control-label"> <?php echo $form['due_date']->renderLabel() ?></label>
              	<div class="col-md-8">
              		<div class="input-group input-medium date datetimepicker"><?php echo $form['due_date'] ?><span class="input-group-btn"><button class="btn btn-default date-set" type="button"><i class="fa fa-calendar"></i></button></span></div>
              	</div>
              </div>              
             
          <?php  } ?>
                           
          </div>
          <div class="col-md-6">
          
          <?php  
            $label_class = 'col-md-5';
            $content_class = 'col-md-7';
          }
          else
          { 
            $label_class = 'col-md-3';
            $content_class = 'col-md-9';
          ?>
          <div class="col-md-12">
          <?php } ?>
       
             
              
              <?php /*if($form->getObject()->isNew()):*/ if(1 == 99){ ?>
                <div class="form-group">
                	<label class="<?php echo $label_class ?> control-label"> <?php echo $form['togo_hours']->renderLabel() ?></label>
                	<div class="<?php echo $content_class ?>">
                		<?php echo $form['togo_hours'] ?>
                	</div>
                </div>
                <div class="form-group">
                	<label class="<?php echo $label_class ?> control-label"> <?php echo $form['progress']->renderLabel() ?></label>
                	<div class="<?php echo $content_class ?>">
                		<?php echo $form['progress'] ?>
                	</div>
                </div>
              <?php } /*endif*/ ?> 
			  
			
			
            </div>
			
          </div>  
              

            
          
          <!--<div class="form-group">
          	<label class="col-md-2 control-label"> 
              <?php //echo $form['description']->renderLabel() ?>
              <?php //include_component('patterns','patternsList',array('type'=>'tasks_comments','field_id'=>'tasks_comments_description')) ?>
              <?php //if(Users::hasAccess('view','tickets',$sf_user,$sf_request->getParameter('projects_id'))) include_component('tickets','relatedTicketsToTasksComments',array('tasks_id'=>$sf_request->getParameter('tasks_id'),'field_id'=>'tasks_comments_description')) ?>
            </label>
          	<div class="col-md-10">
          		<?php //echo $form['description'] ?>
          	</div>
          </div>-->
          
         
        
        </div>
        
        <div  class="tab-pane fade" id="tab_attachments">
          <?php include_component('attachments','attachments',array('bind_type'=>'comments','bind_id'=>($form->getObject()->isNew()?0:$form->getObject()->getId()))) ?>
        </div>
       </div>
       
  </div>
</div>

<?php echo ajax_modal_template_footer() ?>
</form>

<script type="text/javascript">    
  $(function() {          
    if($('#set_worked_hours').val()=='timer')
    {
      tasks_timer_hours = $('#tasks_timer_hours').html();
      
      if(tasks_timer_hours.length>0 && tasks_timer_hours!='0.00')
      {
        $('#tasks_comments_worked_hours').val(tasks_timer_hours);
      }
    }
    
  });
</script> 
