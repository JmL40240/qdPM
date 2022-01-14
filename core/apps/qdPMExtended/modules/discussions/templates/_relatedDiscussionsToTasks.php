<?php if(count($discussions_list)>0): ?>
<h4><?php echo __('Related Discussions') ?></h4>

<table class="table">
<?php 
$status = array();
foreach($discussions_list as $discussions): 
if($discussions['discussions_status_id']>0) $status[] = $discussions['discussions_status_id'];
?>
  <tr id="related_ticket_<?php echo $discussions['id'] ?>">
    <td><?php echo link_to((isset($discussions['DiscussionsTypes'])?$discussions['DiscussionsTypes']['name'] . ': ':'') . $discussions['name'] . (isset($discussions['DiscussionsStatus']) ? ' [' . $discussions['DiscussionsStatus']['name'] . ']':''), 'discussionsComments/index?discussions_id=' . $discussions['id'] . '&projects_id=' . $discussions['projects_id'],array('absolute'=>true)) ?></td>
    <td style="text-align: right;"><?php if(!$is_email) echo image_tag('icons/remove_link.png',array('title'=>__('Delete Related'),'style'=>'cursor:pointer','onClick'=>'removeRelated("related_ticket_' . $discussions['id'] . '","' . url_for('app/removeRelatedTaskWithDiscussions?discussions_id=' . $discussions['id'] . '&tasks_id=' . $sf_request->getParameter('tasks_id')) . '")')) ?></td>
  </tr> 
  
  <?php echo app::renderSubRelatedItems($discussions['id'],'TasksToDiscussions',$sf_request->getParameter('tasks_id')) ?>
  <?php echo app::renderSubRelatedItems($discussions['id'],'TicketsToDiscussions') ?>
   
<?php endforeach ?>
</table>

<?php echo app::renderRelatedItemsWarning(array('status'=>$status,'type'=>'discussions','tasks_id'=>$sf_request->getParameter('tasks_id')))?>

<?php if(Users::hasAccess('insert','discussions',$sf_user,$sf_request->getParameter('projects_id')) and !$is_email): ?>
  <div style="margin-bottom: 10px; margin-top: 5px; text-align: right;"><?php echo link_to_modalbox('+ ' . __('Add'),'discussions/new?related_tasks_id=' . $sf_request->getParameter('tasks_id') . '&projects_id=' . $sf_request->getParameter('projects_id')) . ' | ' . link_to_modalbox(__('Link'),'discussions/bindDiscussions?related_tasks_id=' . $sf_request->getParameter('tasks_id') . '&projects_id=' . $sf_request->getParameter('projects_id'))?></div>
<?php endif ?>

<?php endif ?>