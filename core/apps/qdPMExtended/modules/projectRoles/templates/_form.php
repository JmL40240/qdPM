<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php $form->setDefault('group_type','project_role'); ?>
<?php $form->setDefault('allow_manage_reports',explode(',', $form['allow_manage_reports']->getValue())); ?>
<?php $form->setDefault('projects_custom_access',explode(',', $form['projects_custom_access']->getValue())); ?>
<?php $form->setDefault('tasks_custom_access',explode(',', $form['tasks_custom_access']->getValue())); ?>
<?php $form->setDefault('tickets_custom_access',explode(',', $form['tickets_custom_access']->getValue())); ?>
<?php $form->setDefault('discussions_custom_access',explode(',', $form['discussions_custom_access']->getValue())); ?>

<form class="form-horizontal" id="usersGroups" action="<?php echo url_for('projectRoles/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<div class="modal-body">
  <div class="form-body">

<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>

<?php echo $form->renderHiddenFields(false) ?>
<?php echo $form->renderGlobalErrors() ?>

      <div class="form-group">
      	<label class="col-md-3 control-label"> <?php echo $form['name']->renderLabel() ?></label>
      	<div class="col-md-9">
      		<?php echo $form['name'] ?>                
      	</div>
      </div>

      <div class="form-group">
      	<label class="col-md-3 control-label"> <?php echo $form['allow_manage_projects']->renderLabel() ?></label>
      	<div class="col-md-9">
      		<?php echo $form['allow_manage_projects'] ?>
          
          <table id="users_groups_allow_manage_projects_custom" style="display: none">
            <tr>
              <td valign="top"><?php echo $form['projects_custom_access']->renderLabel() ?></td>
              <th><?php echo $form['projects_custom_access'] ?></th>                      
            </tr>
          </table>
          
          <table  id="users_groups_allow_manage_projects_extra" style="display: none">
            <tr>
              <th><?php echo $form['projects_comments_access']->renderLabel() ?></th>
              <td><?php echo $form['projects_comments_access'] ?></td>
            </tr>
            <tr>                    
              <th><?php echo $form['allow_manage_projects_wiki']->renderLabel() ?></th>
              <td>
                <?php echo $form['allow_manage_projects_wiki']->renderError() ?>
                <?php echo $form['allow_manage_projects_wiki'] ?>
              </td>
            </tr> 
          </table>
                  
      	</div>
      </div>
      
      <div class="form-group">
      	<label class="col-md-3 control-label"> <?php echo $form['allow_manage_tasks']->renderLabel() ?></label>
      	<div class="col-md-9">
      		<?php echo $form['allow_manage_tasks'] ?>
          
          <table id="users_groups_allow_manage_tasks_custom" style="display: none">
            <tr>
              <td valign="top"><?php echo $form['tasks_custom_access']->renderLabel() ?></td>
              <th><?php echo $form['tasks_custom_access'] ?></th>                      
            </tr>
          </table>
          
          <table id="users_groups_allow_manage_tasks_extra" style="display: none">
            <tr>
              <td><?php echo $form['tasks_comments_access']->renderLabel() ?></td>
              <th><?php echo $form['tasks_comments_access'] ?></th>                      
            </tr>
          </table>
          
      	</div>
      </div>
      
      <div class="form-group">
      	<label class="col-md-3 control-label"> <?php echo $form['allow_manage_tickets']->renderLabel() ?></label>
      	<div class="col-md-9">
      		<?php echo $form['allow_manage_tickets'] ?>
          
          <table id="users_groups_allow_manage_tickets_custom" style="display: none">
            <tr>
              <td valign="top"><?php echo $form['tickets_custom_access']->renderLabel() ?></td>
              <th><?php echo $form['tickets_custom_access'] ?></th>                      
            </tr>
          </table>
          
          <table id="users_groups_allow_manage_tickets_extra" style="display: none">
            <tr>
              <td><?php echo $form['tickets_comments_access']->renderLabel() ?></td>
              <th><?php echo $form['tickets_comments_access'] ?></th>                      
            </tr>
          </table>
      	</div>
      </div>
      
      <div class="form-group">
      	<label class="col-md-3 control-label"> <?php echo $form['allow_manage_discussions']->renderLabel() ?></label>
      	<div class="col-md-9">
      		<?php echo $form['allow_manage_discussions'] ?>
          
          <table id="users_groups_allow_manage_discussions_custom" style="display: none">
            <tr>
              <td valign="top"><?php echo $form['discussions_custom_access']->renderLabel() ?></td>
              <th><?php echo $form['discussions_custom_access'] ?></th>                      
            </tr>
          </table>
          
          <table id="users_groups_allow_manage_discussions_extra" style="display: none">
            <tr>
              <td><?php echo $form['discussions_comments_access']->renderLabel() ?></td>
              <th><?php echo $form['discussions_comments_access'] ?></th>                      
            </tr>
          </table>
      	</div>
      </div>

      

  </div>
</div>
          
  <?php echo ajax_modal_template_footer() ?>  
  
</form>


<?php include_partial('global/formValidator',array('form_id'=>'usersGroups')); ?>

<script type="text/javascript">
  $(function() {        
    check_users_groups_items_access();                
  });
</script>
