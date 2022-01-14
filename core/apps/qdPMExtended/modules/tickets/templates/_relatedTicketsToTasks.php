<?php if(count($tickets_list)>0): ?>
<h4><?php echo __('Related Tickets') ?></h4>

<table class="table">
<?php 
$status = array();
foreach($tickets_list as $tickets): 
if($tickets['tickets_status_id']>0) $status[] = $tickets['tickets_status_id'];
?>
  <tr id="related_ticket_<?php echo $tickets['id'] ?>">
    <td><?php echo link_to((isset($tickets['TicketsTypes'])?$tickets['TicketsTypes']['name'] . ': ':'') . $tickets['name'] . (isset($tickets['TicketsStatus']) ? ' [' . $tickets['TicketsStatus']['name'] . ']':''), 'ticketsComments/index?tickets_id=' . $tickets['id'] . '&projects_id=' . $tickets['projects_id'],array('absolute'=>true)) ?></td>
    <td style="text-align: right;"><?php if(!$is_email) echo image_tag('icons/remove_link.png',array('title'=>__('Delete Related'),'style'=>'cursor:pointer','onClick'=>'removeRelated("related_ticket_' . $tickets['id'] . '","' . url_for('app/removeRelatedTicketWithTask?tickets_id=' . $tickets['id'] . '&tasks_id=' . $sf_request->getParameter('tasks_id')) . '")')) ?></td>
  </tr>  
  
  <?php echo app::renderSubRelatedItems($tickets['id'],'TasksToTickets',$sf_request->getParameter('tasks_id')) ?>
  <?php echo app::renderSubRelatedItems($tickets['id'],'DiscussionsToTickets') ?>
  
<?php endforeach ?>
</table>

<?php echo app::renderRelatedItemsWarning(array('status'=>$status,'type'=>'tickets','tasks_id'=>$sf_request->getParameter('tasks_id')))?>

<?php if(Users::hasAccess('insert','tickets',$sf_user,$sf_request->getParameter('projects_id')) and !$is_email): ?>
  <div style="margin-bottom: 10px; margin-top: 5px; text-align: right;"><?php echo link_to_modalbox('+ ' . __('Add'),'tickets/new?related_tasks_id=' . $sf_request->getParameter('tasks_id') . '&projects_id=' . $sf_request->getParameter('projects_id')) . ' | ' . link_to_modalbox(__('Link'),'tickets/bindTickets?related_tasks_id=' . $sf_request->getParameter('tasks_id') . '&projects_id=' . $sf_request->getParameter('projects_id'))?></div>
<?php endif ?>

<?php endif ?>
