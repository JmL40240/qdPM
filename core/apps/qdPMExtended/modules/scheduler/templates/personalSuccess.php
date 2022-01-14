<div class="row">
  <div class="col-md-6">
    <h3 class="page-title"><?php echo __('Personal Scheduler') ?></h3>
  </div>
  <div class="col-md-6" >

<table align="right">
  <tr>
    <td><?php echo link_to_modalbox(__('Configuration'),'scheduler/configuration?users_id=' . $sf_user->getAttribute('id')) ?></td>    
    <?php if($sf_user->hasCredential('public_scheduler_access_full_access') or $sf_user->hasCredential('public_scheduler_access_view_only')): ?>
    <td style="padding-left: 15px;"><?php echo link_to(__('Switch to public scheduler'),'scheduler/index') ?></td>
    <?php endif?>
  </tr>
</table>
  
  </div>
</div>


<?php include_component('scheduler','viewScheduler', array('scheduler_time'=>'personal_scheduler_current_time','users_id'=>$sf_user->getAttribute('id'),'month'=>$sf_request->getParameter('month'))) ?>

<?php include_partial('global/jsTips'); ?>
