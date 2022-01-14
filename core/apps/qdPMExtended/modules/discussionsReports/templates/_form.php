
<?php if($form->getObject()->isNew()) $form->setDefault('users_id',$sf_user->getAttribute('id')) ?>
<?php if(!$form->getObject()->isNew()) $form->setDefault('users_groups_id',explode(',',$form['users_groups_id']->getValue())) ?>

<form class="form-horizontal"  id="discussionsReports" action="<?php echo url_for('discussionsReports/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
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
      <a href="#tab_discussions_filters" data-toggle="tab"><?php echo __('Discussions Filters') ?></a>
    </li>
  	<li>
      <a href="#tab_extra" data-toggle="tab"><?php echo __('Extra') ?></a>
    </li>        	
    <li>
      <a href="#tab_projects_filters" data-toggle="tab"><?php echo __('Projects Filters') ?></a>
    </li>
  </ul>            
        
<div class="tab-content" >
  <div class="tab-pane fade active in" id="tab_discussions_filters">
            
            
                  <table>
                    <tr>      
                      <?php echo app::getReportFormFilterByTable('Priority','discussions_reports[discussions_priority_id]','DiscussionsPriority',$form['discussions_priority_id']->getValue()) ?>
                      <?php echo app::getReportFormFilterByTable('Status','discussions_reports[discussions_status_id]','DiscussionsStatus',$form['discussions_status_id']->getValue()) ?>
                      <?php echo app::getReportFormFilterByTable('Type','discussions_reports[discussions_types_id]','DiscussionsTypes',$form['discussions_types_id']->getValue()) ?>
                      <?php echo app::getReportFormFilterByTable('Group','discussions_reports[discussions_groups_id]','DiscussionsGroups',$form['discussions_groups_id']->getValue()) ?>        
                    </tr>  
                  </table>
                  <table>
                    <tr>
                      <?php echo app::getReportFormExtraFieldsFilterByTable('discussions_reports','discussions',$form['extra_fields']->getValue(),$sf_user)?>
                    </tr>
                  </table>          
                
                <table> 
                  <tr>
                <?php
                if($sf_request->getParameter('redirect_to')!='commonReports')
                {
                  if(count($choices = Users::getChoices(array(),'discussions'))>0 and (Users::hasAccess('insert','discussions',$sf_user) or Users::hasAccess('edit','discussions',$sf_user)))
                  { 
                    if(!is_string($v = $form['assigned_to']->getValue())) $v = '';
                    echo '<td style="padding-right: 10px;"><b>' . __('Assigned To') . '</b><br>' . select_tag('discussions_reports[assigned_to]',explode(',',$v),array('choices'=>$choices,'multiple'=>true),array('style'=>'height: 200px;','class'=>'form-control input-medium')) . '</td>';
                  }                                    
  
                  if(count($choices = Users::getChoices(array(),'discussions_insert'))>0 and (Users::hasAccess('insert','discussions',$sf_user) or Users::hasAccess('edit','discussions',$sf_user)))
                  { 
                    if(!is_string($v = $form['created_by']->getValue())) $v = '';
                    echo '<td style="padding-right: 10px;"><b>' . __('Created By') . '</b><br>' . select_tag('discussions_reports[created_by]',explode(',',$v),array('choices'=>$choices,'multiple'=>true),array('style'=>'height: 200px;','class'=>'form-control input-medium')) . '</td>';
                  }
                } 
                ?>
              </tr>
            </table>
          </div>
          
          <div class="tab-pane fade" id="tab_extra">
            
            <?php echo __('Discussions Created') ?>:
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
          </div>  
          
          <div class="tab-pane fade" id="tab_projects_filters">     
            
            
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
              <?php
              if($sf_request->getParameter('redirect_to')!='commonReports')
              {
                if(count($choices = app::getProjectChoicesByUser($sf_user,true,'discussions'))>0)
                { 
                  if(!is_string($v = $form['projects_id']->getValue())) $v = '';
                  echo '<td style="padding-right: 10px;"><b>' . __('Projects') . '</b><br>' . select_tag('discussions_reports[projects_id]',explode(',',$v),array('choices'=>$choices,'multiple'=>true),array('style'=>'height: 200px;','class'=>'form-control input-medium')) . '</td>';
                }
              }          
              ?>      
              </tr>
            </table>
          </div>
        </div>
        
  </div>
</div>

<?php echo ajax_modal_template_footer() ?>

</form>

<?php include_partial('global/formValidator',array('form_id'=>'discussionsReports')); ?>

