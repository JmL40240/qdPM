
<div class="row">
  <div class="col-md-9">
    <h3 class="page-title"><?php echo $tasks_reports->getName() ?></h3>
  </div>
  <div class="col-md-3" style="text-align:right">    
    <?php if($tasks_reports->getReportType()!='common') echo button_tag_modalbox(__('Edit Details'),'userReports/edit?id=' .$sf_request->getParameter('id') . '&redirect_to=view') ?>
  </div>
</div>

<?php include_component('tasks','listing',array('reports_id'=>$sf_request->getParameter('id'))) ?>