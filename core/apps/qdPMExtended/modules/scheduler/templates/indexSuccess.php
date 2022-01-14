<div class="row">
  <div class="col-md-6">
    <h3 class="page-title"><?php echo __('Public Scheduler') ?></h3>
  </div>
  <div class="col-md-6" >

  <table align="right">
    <tr>
      <td><?php echo link_to_modalbox(__('Configuration'),'scheduler/configuration?users_id=' . $sf_request->getParameter('users_id')) ?></td>    
      <?php if($sf_user->hasCredential('allow_manage_personal_scheduler')): ?>
      <td style="padding-left: 15px;"><?php echo link_to(__('Switch to my personal scheduler'),'scheduler/personal') ?></td>
      <?php endif?>
    </tr>
  </table>
  
  </div>
</div>

<?php include_component('scheduler','viewScheduler', array('scheduler_time'=>'scheduler_current_time','users_id'=>null,'month'=>$sf_request->getParameter('month'))) ?>

<?php include_partial('global/jsTips'); ?>
