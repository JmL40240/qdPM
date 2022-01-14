
<?php if($form->getObject()->isNew()) $form->setDefault('users_id',$sf_user->getAttribute('id')) ?>
<?php if(!$form->getObject()->isNew()) $form->setDefault('users_groups_id',explode(',',$form['users_groups_id']->getValue())) ?>
<?php if(!$form->getObject()->isNew()) $form->setDefault('report_reminder',explode(',',$form['report_reminder']->getValue())) ?>

<form class="form-horizontal"  id="tasksReports" action="<?php echo url_for('userReports/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<div class="modal-body ajax-modal-width-790">
  <div class="form-body">
  
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>


<?php echo $form->renderHiddenFields(false) ?>   
<?php echo input_hidden_tag('redirect_to',$sf_request->getParameter('redirect_to')) ?>

<?php echo $form->renderGlobalErrors() ?>

  <div class="form-group">
  	<label class="col-md-3 control-label"><span class="required">*</span> <?php echo $form['name']->renderLabel() ?></label>
  	<div class="col-md-9">
  		<?php echo $form['name'] ?>
  	</div>
  </div>

    <div class="form-group">
    	<label class="col-md-3 control-label"><?php echo $form['display_on_home']->renderLabel() ?></label>
    	<div class="col-md-9">
    		<div class="checkbox-list"><label class="checkbox-inline"><?php echo $form['display_on_home'] ?></label></div>
    	</div>
    </div>
    
    <div class="form-group">
    	<label class="col-md-3 control-label"><?php echo $form['display_in_menu']->renderLabel() ?></label>
    	<div class="col-md-9">
    		<div class="checkbox-list"><label class="checkbox-inline"><?php echo $form['display_in_menu'] ?></label></div>
    	</div>
    </div>
    
  <div class="form-group">
  	<label class="col-md-3 control-label"><?php echo $form['listing_order']->renderLabel() ?></label>
  	<div class="col-md-9">
  		<?php echo $form['listing_order'] ?>
  	</div>
  </div>
  
  <?php if($sf_request->getParameter('redirect_to')=='commonReports'): ?>
  <div class="form-group">
  	<label class="col-md-3 control-label"><?php echo $form['is_mandatory']->renderLabel() ?></label>
  	<div class="col-md-9">
  		<?php echo $form['is_mandatory'] ?>
  	</div>
  </div>
  
  <div class="form-group">
  	<label class="col-md-3 control-label"><?php echo $form['users_groups_id']->renderLabel() ?></label>
  	<div class="col-md-9">
  		<?php echo $form['users_groups_id'] ?>
  	</div>
  </div>
  
  <div class="form-group">
  	<label class="col-md-3 control-label"><?php echo $form['display_only_assigned']->renderLabel() ?></label>
  	<div class="col-md-9">
  		<?php echo $form['display_only_assigned'] ?>
  	</div>
  </div>  
  <?php endif ?>  
    

  <ul class="nav nav-tabs">
  	<li class="active">
      <a href="#tab_tasks_filters" data-toggle="tab"><?php echo __('Tasks Filters') ?></a>
    </li>
  	<li>
      <a href="#tab_extra" data-toggle="tab"><?php echo __('Extra') ?></a>
    </li>        	
    <li>
      <a href="#tab_projects_filters" data-toggle="tab"><?php echo __('Projects Filters') ?></a>
    </li>
    <li>
      <a href="#tab_reminder" data-toggle="tab"><?php echo __('Reminder') ?></a>
    </li>
  </ul>     


<div class="tab-content" >
  <div class="tab-pane fade active in" id="tab_tasks_filters">
           
           
                <table>
                  <tr>      
                    <?php echo app::getReportFormFilterByTable('Priority','user_reports[tasks_priority_id]','TasksPriority',$form['tasks_priority_id']->getValue()) ?>
                    <?php echo app::getReportFormFilterByTable('Status','user_reports[tasks_status_id]','TasksStatus',$form['tasks_status_id']->getValue()) ?>
                    <?php echo app::getReportFormFilterByTable('Type','user_reports[tasks_type_id]','TasksTypes',$form['tasks_type_id']->getValue()) ?>
                    <?php echo app::getReportFormFilterByTable('Label','user_reports[tasks_label_id]','TasksLabels',$form['tasks_label_id']->getValue()) ?>        
                  </tr>  
                </table>
                <table>
                  <tr>
                    <?php echo app::getReportFormExtraFieldsFilterByTable('user_reports','tasks',$form['extra_fields']->getValue(),$sf_user)?>
                  </tr>
                </table>
                
               
              <table> 
                <tr> 
                <?php
                if($sf_request->getParameter('redirect_to')!='commonReports')
                {
                  if(count($choices = Users::getChoices(array(),'tasks'))>0 and (Users::hasAccess('insert','tasks',$sf_user) or Users::hasAccess('edit','tasks',$sf_user)))
                  { 
                    if(!is_string($v = $form['assigned_to']->getValue())) $v = '';
                    echo '<td style="padding-right: 10px;"><b>' . __('Assigned To') . '</b><br>' . select_tag('user_reports[assigned_to]',explode(',',$v),array('choices'=>$choices,'multiple'=>true),array('style'=>'height: 200px;','class'=>'form-control input-medium')) . '</td>';
                  }                                    
                
                  if(count($choices = Users::getChoices(array(),'tasks_insert'))>0 and (Users::hasAccess('insert','tasks',$sf_user) or Users::hasAccess('edit','tasks',$sf_user)))
                  { 
                    if(!is_string($v = $form['created_by']->getValue())) $v = '';
                    echo '<td style="padding-right: 10px;"><b>' . __('Created By') . '</b><br>' . select_tag('user_reports[created_by]',explode(',',$v),array('choices'=>$choices,'multiple'=>true),array('style'=>'height: 200px;','class'=>'form-control input-medium')) . '</td>';
                  }
                 } 
                ?>
              </tr>
            </table>
            
          </div>
          
          <div class="tab-pane fade" id="tab_extra">
            <table>
              <tr>                
                <td><?php echo $form['has_related_ticket'] ?></td>
                <th><?php echo $form['has_related_ticket']->renderLabel() ?></th>
              </tr>
              <tr>                
                <td><?php echo $form['has_estimated_time'] ?></td>
                <th><?php echo $form['has_estimated_time']->renderLabel() ?></th>
              </tr>
              <tr>                
                <td><?php echo $form['overdue_tasks'] ?></td>
                <th><?php echo $form['overdue_tasks']->renderLabel() ?></th>
              </tr>
            </table>
            
            <table>
              <tr>                
                <td><?php echo $form['days_before_due_date'] ?></td>
                <th><?php echo $form['days_before_due_date']->renderLabel() ?></th>
              </tr>
            </table>
            
            <br>
            <?php echo __('Tasks Due Date') ?>:
            <table>
              <tr>                
                <th> - <?php echo __('From') ?>:</th>
                <td><div class="input-group input-medium date datepicker"><?php echo $form['due_date_from'] ?><span class="input-group-btn"><button class="btn btn-default date-set" type="button"><i class="fa fa-calendar"></i></button></span></td>                
              </tr>
              <tr>                
                <th> - <?php echo __('To') ?>:</th>
                <td><div class="input-group input-medium date datepicker"><?php echo $form['due_date_to'] ?><span class="input-group-btn"><button class="btn btn-default date-set" type="button"><i class="fa fa-calendar"></i></button></span></td>                
              </tr>
            </table>
            
            <br>
            <?php echo __('Tasks Created') ?>:
            <table>
              <tr>                
                <th> - <?php echo __('From') ?>:</th>
                <td><div class="input-group input-medium date datepicker"><?php echo $form['created_from'] ?><span class="input-group-btn"><button class="btn btn-default date-set" type="button"><i class="fa fa-calendar"></i></button></span></td>                
              </tr>
              <tr>                
                <th> - <?php echo __('To') ?>:</th>
                <td><div class="input-group input-medium date datepicker"><?php echo $form['created_to'] ?><span class="input-group-btn"><button class="btn btn-default date-set" type="button"><i class="fa fa-calendar"></i></button></span></td>                
              </tr>
            </table>
            
            <br>
            <?php echo __('Closed Date') ?>:
            <table>
              <tr>                
                <th> - <?php echo __('From') ?>:</th>
                <td><div class="input-group input-medium date datepicker"><?php echo $form['closed_from'] ?><span class="input-group-btn"><button class="btn btn-default date-set" type="button"><i class="fa fa-calendar"></i></button></span></td>                
              </tr>
              <tr>                
                <th> - <?php echo __('To') ?>:</th>
                <td><div class="input-group input-medium date datepicker"><?php echo $form['closed_to'] ?><span class="input-group-btn"><button class="btn btn-default date-set" type="button"><i class="fa fa-calendar"></i></button></span></td>                
              </tr>
            </table>
          </div>
          
          <div class="tab-pane fade" id="tab_projects_filters">     
            
             
                <table>
                  <tr>      
                    <?php echo app::getReportFormFilterByTable('Priority','user_reports[projects_priority_id]','ProjectsPriority',$form['projects_priority_id']->getValue()) ?>
                    <?php echo app::getReportFormFilterByTable('Status','user_reports[projects_status_id]','ProjectsStatus',$form['projects_status_id']->getValue()) ?>
                    <?php echo app::getReportFormFilterByTable('Type','user_reports[projects_type_id]','ProjectsTypes',$form['projects_type_id']->getValue()) ?>
                    <?php echo app::getReportFormFilterByTable('Group','user_reports[projects_groups_id]','ProjectsGroups',$form['projects_groups_id']->getValue(),$sf_user) ?>        
                  </tr>  
                </table>
                                                
            <table> 
            <tr>
              <?php
              if($sf_request->getParameter('redirect_to')!='commonReports')
              {
                if(count($choices = app::getProjectChoicesByUser($sf_user,true,'tasks'))>0)
                { 
                  if(!is_string($v = $form['projects_id']->getValue())) $v = '';
                  echo '<td style="padding-right: 10px;"><b>' . __('Projects') . '</b><br>' . select_tag('user_reports[projects_id]',explode(',',$v),array('choices'=>$choices,'multiple'=>true),array('style'=>'height: 200px;','class'=>'form-control input-medium')) . '</td>';
                }
              }          
              ?>      
            </tr>
            </table>
          </div>
          
          <div class="tab-pane fade" id="tab_reminder">
            <table>
              <tr>
                <th valign="top"><?php echo $form['report_reminder']->renderLabel() ?><br><a href="#" onClick="return checkAllInContainer('report_reminder')"><small><?php echo __('Select All')?></small></a></th>
                <td><div id="report_reminder"><?php echo $form['report_reminder'] ?></div></td>
              </tr>
            </table>
          </div>
        </div>
   
   
  </div>
</div>

<?php echo ajax_modal_template_footer() ?>
   
</form>

<?php include_partial('global/formValidator',array('form_id'=>'tasksReports')); ?>

