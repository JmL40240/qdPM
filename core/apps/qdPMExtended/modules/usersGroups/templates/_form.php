<?php $form->setDefault('allow_manage_reports',explode(',', $form['allow_manage_reports']->getValue())); ?>
<?php $form->setDefault('projects_custom_access',explode(',', $form['projects_custom_access']->getValue())); ?>
<?php $form->setDefault('tasks_custom_access',explode(',', $form['tasks_custom_access']->getValue())); ?>
<?php $form->setDefault('tickets_custom_access',explode(',', $form['tickets_custom_access']->getValue())); ?>
<?php $form->setDefault('discussions_custom_access',explode(',', $form['discussions_custom_access']->getValue())); ?>


<form class="form-horizontal" role="form"  id="usersGroups" action="<?php echo url_for('usersGroups/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<div class="modal-body">
  <div class="form-body">
  
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>

<?php echo $form->renderHiddenFields(false) ?>
<?php echo $form->renderGlobalErrors() ?>

<div class="form-group">
	<label class="col-md-3 control-label"><span class="required">*</span> <?php echo $form['name']->renderLabel() ?></label>
	<div class="col-md-9">
		<?php echo $form['name'] ?>
	</div>
</div>

<div class="form-group">
	<label class="col-md-3 control-label"><span class="required">*</span> <?php echo $form['default_value']->renderLabel() ?></label>
	<div class="col-md-9">
		<?php echo $form['default_value'] ?>
	</div>
</div>

<div class="form-group">
	<label class="col-md-3 control-label"><span class="required">*</span> <?php echo $form['ldap_default']->renderLabel() ?></label>
	<div class="col-md-9">
		<?php echo $form['ldap_default'] ?>
	</div>
</div>
                       
<ul class="nav nav-tabs">
	<li class="active">
    <a href="#tab_access" data-toggle="tab"><?php echo __('Basic Access') ?></a>
  </li>
	<li>
    <a href="#tab_extra" data-toggle="tab"><?php echo __('Extra Access Configuration') ?></a>
  </li>        	
</ul>

<div class="tab-content" >
    <div class="tab-pane fade active in" id="tab_access">
    
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
              <td><label for="users_groups_allow_manage_reports_projects"><?php echo __('Projects Reports') ?></label></td>
              <td><input name="users_groups[allow_manage_reports][]" type="checkbox" value="projects" id="users_groups_allow_manage_reports_projects" <?php echo UsersGroups::is_checked_reports_field('projects',$form->getObject()) ?> ></td>                                              
            </tr>
            <tr>
              <td><label for="users_groups_allow_manage_reports_projectsusers"><?php echo __('Users per Projects') ?></label></td>
              <td><input name="users_groups[allow_manage_reports][]" type="checkbox" value="projectsusers" id="users_groups_allow_manage_reports_projectsusers" <?php echo UsersGroups::is_checked_reports_field('projectsusers',$form->getObject()) ?> ></td>                                              
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
            <tr>
              <td><label for="users_groups_allow_manage_reports_tasks"><?php echo __('Tasks Reports') ?></label></td>
              <td><input name="users_groups[allow_manage_reports][]" type="checkbox" value="tasks" id="users_groups_allow_manage_reports_tasks" <?php echo UsersGroups::is_checked_reports_field('tasks',$form->getObject()) ?> ></td>                                              
            </tr>
            <tr>
              <td><label for="users_groups_allow_manage_reports_gantt"><?php echo __('Gantt Chart') ?></label></td>
              <td><input name="users_groups[allow_manage_reports][]" type="checkbox" value="gantt" id="users_groups_allow_manage_reports_gantt" <?php echo UsersGroups::is_checked_reports_field('gantt',$form->getObject()) ?> ></td>                                              
            </tr>
            <tr>
              <td><label for="users_groups_allow_manage_reports_time"><?php echo __('Time Report') ?></label></td>
              <td><input name="users_groups[allow_manage_reports][]" type="checkbox" value="time" id="users_groups_allow_manage_reports_time" <?php echo UsersGroups::is_checked_reports_field('time',$form->getObject()) ?> ></td>                                              
            </tr>
            <tr>
              <td><label for="users_groups_allow_manage_reports_time_personal"><?php echo __('Personal Time Report') ?></label></td>
              <td><input name="users_groups[allow_manage_reports][]" type="checkbox" value="time_personal" id="users_groups_allow_manage_reports_time_personal" <?php echo UsersGroups::is_checked_reports_field('time_personal',$form->getObject()) ?> ></td>                                              
            </tr>
            <tr>
              <td><label for="users_groups_allow_manage_reports_tasksusers"><?php echo __('Users per Tasks') ?></label></td>
              <td><input name="users_groups[allow_manage_reports][]" type="checkbox" value="tasksusers" id="users_groups_allow_manage_reports_tasksusers" <?php echo UsersGroups::is_checked_reports_field('tasksusers',$form->getObject()) ?> ></td>                                              
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
            <tr>
              <td><label for="users_groups_allow_manage_reports_tickets"><?php echo __('Tickets Reports') ?></label></td>
              <td><input name="users_groups[allow_manage_reports][]" type="checkbox" value="tickets" id="users_groups_allow_manage_reports_tickets" <?php echo UsersGroups::is_checked_reports_field('tickets',$form->getObject()) ?> ></td>                                              
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
            <tr>
              <td><label for="users_groups_allow_manage_reports_discussions"><?php echo __('Discussions Reports') ?></label></td>
              <td><input name="users_groups[allow_manage_reports][]" type="checkbox" value="discussions" id="users_groups_allow_manage_reports_discussions" <?php echo UsersGroups::is_checked_reports_field('discussions',$form->getObject()) ?> ></td>                                              
            </tr>
          </table>
      	</div>
      </div>

    </div>
    
    <div class="tab-pane fade" id="tab_extra">
    
       <div class="form-group">
      	<label class="col-md-3 control-label"> <?php echo $form['allow_manage_configuration']->renderLabel() ?></label>
      	<div class="col-md-9">
      		<div class="checkbox-list"><label class="checkbox-inline"><?php echo $form['allow_manage_configuration'] ?></label></div>
      	</div>
      </div>
      
      <div class="form-group">
      	<label class="col-md-3 control-label"> <?php echo $form['allow_manage_users']->renderLabel() ?></label>
      	<div class="col-md-9">
      		<div class="checkbox-list"><label class="checkbox-inline"><?php echo $form['allow_manage_users'] ?></label></div>
      	</div>
      </div>
      
      <div class="form-group">
      	<label class="col-md-3 control-label"> <?php echo __('Users Activity') ?> </label>
      	<div class="col-md-9">
      		<div class="checkbox-list"><label class="checkbox-inline"><input name="users_groups[allow_manage_reports][]" type="checkbox" value="activity" id="users_groups_allow_manage_reports_activity" <?php echo UsersGroups::is_checked_reports_field('activity',$form->getObject()) ?> ></label></div>
      	</div>
      </div>
      
      <div class="form-group">
      	<label class="col-md-3 control-label"> <?php echo __('Personal Activity Report') ?></label>
      	<div class="col-md-9">
      		<div class="checkbox-list"><label class="checkbox-inline"><input name="users_groups[allow_manage_reports][]" type="checkbox" value="activity_personal" id="users_groups_allow_manage_reports_activity_personal" <?php echo UsersGroups::is_checked_reports_field('activity_personal',$form->getObject()) ?> ></label></div>
      	</div>
      </div>
      
      
      <div class="form-group">
      	<label class="col-md-3 control-label"> <?php echo $form['allow_manage_patterns']->renderLabel() ?></label>
      	<div class="col-md-9">
      		<div class="checkbox-list"><label class="checkbox-inline"><?php echo $form['allow_manage_patterns'] ?></label></div>
      	</div>
      </div>
      
      <div class="form-group">
      	<label class="col-md-3 control-label"> <?php echo $form['allow_manage_contacts']->renderLabel() ?></label>
      	<div class="col-md-9">
      		<div class="checkbox-list"><label class="checkbox-inline"><?php echo $form['allow_manage_contacts'] ?></label></div>
      	</div>
      </div>
      
      <div class="form-group">
      	<label class="col-md-3 control-label"> <?php echo $form['allow_manage_public_wiki']->renderLabel() ?></label>
      	<div class="col-md-9">
      		<div class="checkbox-list"><label class="checkbox-inline"><?php echo $form['allow_manage_public_wiki'] ?></label></div>
      	</div>
      </div>
      
      <div class="form-group">
      	<label class="col-md-3 control-label"> <?php echo $form['allow_manage_public_scheduler']->renderLabel() ?></label>
      	<div class="col-md-9">
      		<div class="checkbox-list"><label class="checkbox-inline"><?php echo $form['allow_manage_public_scheduler'] ?></label></div>
      	</div>
      </div>
      
      <div class="form-group">
      	<label class="col-md-3 control-label"> <?php echo $form['allow_manage_personal_scheduler']->renderLabel() ?></label>
      	<div class="col-md-9">
      		<div class="checkbox-list"><label class="checkbox-inline"><?php echo $form['allow_manage_personal_scheduler'] ?></label></div>
      	</div>
      </div>
    
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