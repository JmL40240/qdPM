
<?php if($form->getObject()->isNew()) $form->setDefault('users_id',$sf_user->getAttribute('id')) ?>
<?php if(!$form->getObject()->isNew()) $form->setDefault('users_groups_id',explode(',',$form['users_groups_id']->getValue())) ?>

<form class="form-horizontal"  id="projectsReports" action="<?php echo url_for('projectsReports/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
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


 <h3 class="form-section"><?php echo __('Projects Filters') ?></h3>
 


       
        
            <table>
              <tr>      
                <?php echo app::getReportFormFilterByTable('Priority','projects_reports[projects_priority_id]','ProjectsPriority',$form['projects_priority_id']->getValue()) ?>
                <?php echo app::getReportFormFilterByTable('Status','projects_reports[projects_status_id]','ProjectsStatus',$form['projects_status_id']->getValue()) ?>
                <?php echo app::getReportFormFilterByTable('Type','projects_reports[projects_type_id]','ProjectsTypes',$form['projects_type_id']->getValue()) ?>
                <?php echo app::getReportFormFilterByTable('Group','projects_reports[projects_groups_id]','ProjectsGroups',$form['projects_groups_id']->getValue(),$sf_user) ?>        
              </tr>  
            </table>
            
            <table>
              <tr>
                <?php echo app::getReportFormExtraFieldsFilterByTable('projects_reports','projects',$form['extra_fields']->getValue(),$sf_user)?>
              </tr>
            </table>
            
         
         <table>
              <tr>
          <?php
          
          if($sf_request->getParameter('redirect_to')!='commonReports')
          {
            if(count($choices = app::getProjectChoicesByUser($sf_user,true))>0)
            { 
              if(!is_string($v = $form['projects_id']->getValue())) $v = '';
              echo '<td style="padding-right: 10px;"><b>' . __('Projects') . '</b><br>' . select_tag('projects_reports[projects_id]',explode(',',$v),array('choices'=>$choices,'multiple'=>true),array('style'=>'height: 200px;','class'=>'form-control input-medium')) . '</td>';
            }          
            if(count($choices = app::getItemsChoicesByTable('Users'))>0 and (Users::hasAccess('insert','projects',$sf_user) or Users::hasAccess('edit','projects',$sf_user)))
            { 
              if(!is_string($v = $form['in_team']->getValue())) $v = '';
              echo '<td style="padding-right: 10px;"><b>' . __('In Team') . '</b><br>' . select_tag('projects_reports[in_team]',explode(',',$v),array('choices'=>$choices,'multiple'=>true),array('style'=>'height: 200px;','class'=>'form-control input-medium')) . '</td>';
            }
          }
          ?>      
          </tr>
        </table>
        
  </div>
</div>

<?php echo ajax_modal_template_footer() ?>

</form>

<?php include_partial('global/formValidator',array('form_id'=>'projectsReports')); ?>

