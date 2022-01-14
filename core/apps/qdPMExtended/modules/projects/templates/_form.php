<?php if($form->getObject()->isNew())$form->setDefault('created_by',$sf_user->getAttribute('id')) ?>

<form class="form-horizontal" role="form"  id="projects" action="<?php echo url_for('projects/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php print 'enctype="multipart/form-data" ' ?>>
<div class="modal-body">
  <div class="form-body">
  
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>

<?php echo $form->renderHiddenFields(false) ?>          
<?php echo input_hidden_tag('redirect_to',$sf_request->getParameter('redirect_to')) ?>

<?php echo $form->renderGlobalErrors() ?>

               
<ul class="nav nav-tabs">
	<li class="active">
    <a href="#tab_general" data-toggle="tab"><?php echo __('General') ?></a>
  </li>
  
  <?php echo ExtraFieldsTabs::renderTabsHeaders('projects',$sf_user) ?>
  
	<li>
    <a href="#tab_team" data-toggle="tab"><?php echo __('Team') ?></a>
  </li> 
  <li>
    <a href="#tab_departments" data-toggle="tab">Domaines<?php //echo __('Departments') ?></a>
  </li>        	
  <li>
    <a href="#tab_attachments" data-toggle="tab">Documents<?php //echo __('Attachments') ?></a>
  </li>
</ul>


<div class="tab-content" >
    <div class="tab-pane fade active in" id="tab_general">
      
      <?php if(app::countItemsByTable('ProjectsPriority')>0): ?>    
      <div class="form-group">
      	<label class="col-md-3 control-label"> <?php echo $form['projects_priority_id']->renderLabel() ?></label>
      	<div class="col-md-9">
      		<?php echo $form['projects_priority_id'] ?>
      	</div>
      </div> 
      <?php endif ?> 
          
      <?php if(app::countItemsByTable('ProjectsTypes')>0): ?>    
      <div class="form-group">
      	<label class="col-md-3 control-label"> <?php echo $form['projects_types_id']->renderLabel() ?></label>
      	<div class="col-md-9">
      		<?php echo $form['projects_types_id'] ?>
      	</div>
      </div> 
      <?php endif ?>   
      
      <?php if(app::countItemsByTable('ProjectsGroups')>0): ?>    
      <div class="form-group">
      	<label class="col-md-3 control-label"> <?php echo $form['projects_groups_id']->renderLabel() ?></label>
      	<div class="col-md-9">
      		<?php echo $form['projects_groups_id'] ?>
      	</div>
      </div> 
      <?php endif ?>   
      
      <?php if(app::countItemsByTable('ProjectsStatus')>0): ?>
      <div class="form-group">
      	<label class="col-md-3 control-label"> <?php echo $form['projects_status_id']->renderLabel() ?></label>
      	<div class="col-md-9">
      		<?php echo $form['projects_status_id'] ?>
      	</div>
      </div>
      <?php endif ?> 
      
      <div class="form-group">
      	<label class="col-md-3 control-label"><span class="required">*</span> <?php echo $form['name']->renderLabel() ?></label>
      	<div class="col-md-9">
      		<?php echo $form['name'] ?>
      	</div>
      </div>  
      
      <?php echo ExtraFieldsList::renderFormFiledsByType('projects',$form->getObject(),$sf_user,'input')?>
      
      <div class="form-group">
      	<label class="col-md-3 control-label"> <?php echo $form['description']->renderLabel() ?>
        <?php include_component('patterns','patternsList',array('type'=>'projects_description','field_id'=>'projects_description'))?>
        </label>
      	<div class="col-md-9">
      		<?php echo $form['description'] ?>
      	</div>
      </div> 
      
      <?php echo ExtraFieldsList::renderFormFiledsByType('projects',$form->getObject(),$sf_user,'text')?>          
      <?php echo ExtraFieldsList::renderFormFiledsByType('projects',$form->getObject(),$sf_user,'file')?>
          
        </div> 
        
        <?php echo ExtraFieldsTabs::renderTabsContent('projects',$form->getObject(), $sf_user) ?>               
        
        <div class="tab-pane fade" id="tab_team">
          <?php include_component('projects','team',array('project'=>$form->getObject())) ?>
        </div>
        
        <div class="tab-pane fade" id="tab_departments">
          <?php //echo __('Select Ticket Departments which will be available for this Project.') ?><br>
          <?php //echo __('By default Department will be available if the User assigned to Department is in the Project team.') ?>
          
          <div class="form-group">
          	<label class="col-md-3 control-label"> Domaine (s)<?php //echo $form['departments']->renderLabel() ?></label>
          	<div class="col-md-9">
          		<?php echo $form['departments'] ?>
          	</div>
          </div>
        </div>
                                      
        <div class="tab-pane fade" id="tab_attachments"> 
          <?php include_component('attachments','attachments',array('bind_type'=>'projects','bind_id'=>($form->getObject()->isNew()?0:$form->getObject()->getId()))) ?>
        </div>
                
      </div>
      
<?php echo ExtraFields::getJsListPerGroup('ProjectsTypes'); ?>      

<?php include_partial('global/formValidatorExt',array('form_id'=>'projects')); ?>
      
  </div>
</div>

<?php echo ajax_modal_template_footer() ?>

</form>



<script type="text/javascript">    
  $(function() {             
    
    set_extra_fields_per_group($('#projects_projects_types_id').val());
                                                                                                                                                       
    $('.check_all_users').bind('click', function() { 
       rnd = $(this).attr('id').replace('check_all_users_','');
       checked = $(this).attr('checked');
       
       $( ".rnd"+rnd ).each(function() {
          if(checked)
          {            
            set_checkbox_checked($(this).attr('id'),true)
          }
          else
          {            
            set_checkbox_checked($(this).attr('id'),false)
          }
          
          updateUserRoles($(this));
       });
    });
    
    $('.projects_team').bind('change', function() {       
       updateUserRoles($(this));
    });
                                                              
  });
</script> 