<?php if(count($tasks_list)>0): ?>
<h4><?php echo __('Child Tasks') ?></h4>

<table class="table">
<?php foreach($tasks_list as $tasks): ?>
  <tr id="related_task_<?php echo $tasks['id'] ?>">
    <td><?php echo link_to((isset($tasks['TasksLabels'])?$tasks['TasksLabels']['name'] . ': ':'') . $tasks['name'] . (isset($tasks['TasksStatus']) ? ' [' . $tasks['TasksStatus']['name'] . ']':''), 'tasksComments/index?tasks_id=' . $tasks['id'] . '&projects_id=' . $tasks['projects_id']) ?></td>    
  </tr>  
<?php endforeach ?>
</table>

<?php if(Users::hasAccess('insert','tasks',$sf_user,$sf_request->getParameter('projects_id'))and !$is_email): ?>
  <div style="margin-bottom: 10px; margin-top: 5px; text-align: right;"><?php echo link_to_modalbox('+ ' . __('Add'),'tasks/new?parent_id=' . $sf_request->getParameter('tasks_id') . '&projects_id=' . $sf_request->getParameter('projects_id') . '&redirect_to=parentTask') . ' | ' . link_to_modalbox(__('Link'),'tasks/bindChildTasks?parent_id=' . $sf_request->getParameter('tasks_id') . '&projects_id=' . $sf_request->getParameter('projects_id'))?></div>
<?php endif ?>

<?php endif ?>