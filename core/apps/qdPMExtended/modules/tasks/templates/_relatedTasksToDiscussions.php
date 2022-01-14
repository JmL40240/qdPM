<?php if(count($tasks_list)>0): ?>
<h4><?php echo __('Related Tasks') ?></h4>

<table class="table">
<tr>
  <th><?php echo __('Name') ?></th>
  <th><?php echo __('Est. Time') ?></th>
  <th></th>
</tr>
<?php
$total_est = 0; 
$status = array();
foreach($tasks_list as $tasks): 
if($tasks['tasks_status_id']>0) $status[] = $tasks['tasks_status_id'];
$total_est+=$tasks['estimated_time'];
?>
  <tr id="related_task_<?php echo $tasks['id'] ?>">
    <td><?php echo link_to((isset($tasks['TasksLabels'])?$tasks['TasksLabels']['name'] . ': ':'') . $tasks['name'] . (isset($tasks['TasksStatus']) ? ' [' . $tasks['TasksStatus']['name'] . ']':''), 'tasksComments/index?tasks_id=' . $tasks['id'] . '&projects_id=' . $tasks['projects_id'],array('absolute'=>true)) ?></td>
    <td><?php echo $tasks['estimated_time'] ?></td>
    <td style="text-align: right;"><?php if(!$is_email) echo image_tag('icons/remove_link.png',array('title'=>__('Delete Related'),'style'=>'cursor:pointer','onClick'=>'removeRelated("related_task_' . $tasks['id'] . '","' . url_for('app/removeRelatedTaskWithDiscussions?tasks_id=' . $tasks['id'] . '&discussions_id=' . $sf_request->getParameter('discussions_id')) . '")')) ?></td>
  </tr>  
  
  <?php echo app::renderSubRelatedItems($tasks['id'],'TicketsToTasks') ?>
  <?php echo app::renderSubRelatedItems($tasks['id'],'DiscussionsToTasks',$sf_request->getParameter('discussions_id')) ?>
  
<?php endforeach ?>

<?php
  
  $button_add_html = '';
  if(Users::hasAccess('insert','tasks',$sf_user,$sf_request->getParameter('projects_id')) and !$is_email)
  {
    $button_add_html = link_to_modalbox('+ ' . __('Add'),'tasks/new?related_discussions_id=' . $sf_request->getParameter('discussions_id') . '&projects_id=' . $sf_request->getParameter('projects_id')) . ' | ' . link_to_modalbox(__('Link'),'tasks/bindTasks?related_discussions_id=' . $sf_request->getParameter('discussions_id') . '&projects_id=' . $sf_request->getParameter('projects_id'));   
  }
  
    echo '
      <tr>
        <td></td>
        <td><b>' . $total_est . '</b></td>
        <td align="right">' . $button_add_html . '</td>
      </tr>
    ';
  
?>
</table>

<?php echo app::renderRelatedItemsWarning(array('status'=>$status,'type'=>'tasks','discussions_id'=>$sf_request->getParameter('discussions_id')))?>

<?php endif ?>