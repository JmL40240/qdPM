
<table >
  <?php if($events->getEventsPriorityId()>0): ?>
  <tr>
    <th><?php echo __('Priority') ?>:&nbsp;</th>
    <td><?php echo $events->getEventsPriority()->getName() ?></td>
  </tr>
  <?php endif ?>
  
  <?php if($events->getEventsTypesId()>0): ?>
  <tr>
    <th><?php echo __('Type') ?>:&nbsp;</th>
    <td><?php echo $events->getEventsTypes()->getName() ?></td>
  </tr>
  <?php endif ?>

  <?php echo str_replace('</th>',':&nbsp;</th>',ExtraFieldsList::renderInfoFileds('events',$events,$sf_user,$events->getEventsTypes()->getExtraFields())) ?>
  
</table>

<?php echo $events->getDescription() ?>

<div><?php include_component('attachments','attachmentsList',array('bind_type'=>'events','bind_id'=>$events->getId())) ?></div>

