
<?php if($form->getObject()->isNew()) $form->setDefault('created_by',$sf_user->getAttribute('id')) ?>

<form class="form-horizontal" action="<?php echo url_for('projectsComments/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php print 'enctype="multipart/form-data" ' ?>>
<div class="modal-body">
  <div class="form-body">
  
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>


<?php echo $form->renderHiddenFields(false) ?>
<?php echo input_hidden_tag('projects_id',$sf_request->getParameter('projects_id')) ?>

<?php echo $form->renderGlobalErrors() ?>

<ul class="nav nav-tabs">
	<li class="active">
    <a href="#tab_general" data-toggle="tab"><?php echo __('General') ?></a>
  </li>
        
  <!--<li>
    <a href="#tab_attachments" data-toggle="tab"><?php echo __('Attachments') ?></a>
  </li>-->
</ul>


      
  <div class="tab-content" >
    <div class="tab-pane fade active in" id="tab_general">
         
      <?php if(Users::hasProjectsAccess('edit',$sf_user, $projects)  and $form->getObject()->isNew()){ ?>
       
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
          
    <?php  } ?>
                
          <?php if(app::countItemsByTable('ProjectsStatus')>0  and $form->getObject()->isNew()): ?>
          <div class="form-group">
          	<label class="col-md-3 control-label"> <?php echo $form['projects_status_id']->renderLabel() ?></label>
          	<div class="col-md-9">
          		<?php echo $form['projects_status_id'] ?>
          	</div>
          </div>      
          <?php endif ?>
          
          
          <div class="form-group">
          	<label class="col-md-3 control-label"> <?php echo $form['description']->renderLabel() ?><?php include_component('patterns','patternsList',array('type'=>'projects_comments','field_id'=>'projects_comments_description'))?></label>
          	<div class="col-md-9">
          		<?php echo $form['description'] ?>
          	</div>
          </div>

         
        </div>
        
        <!--<div  class="tab-pane fade" id="tab_attachments">
          <?php //include_component('attachments','attachments',array('bind_type'=>'projectsComments','bind_id'=>($form->getObject()->isNew()?0:$form->getObject()->getId()))) ?>
        </div>
      </div>-->
      
  </div>
</div>

<?php echo ajax_modal_template_footer() ?>

</form>


