<div class="row">
  <div class="col-md-9">
    <h3 class="page-title"><?php echo $projects_reports->getName() ?></h3>
  </div>
  <div class="col-md-3" style="text-align:right">
    <?php if($projects_reports->getReportType()!='common') echo button_tag_modalbox(__('Edit Report'),'projectsReports/edit?id=' .$sf_request->getParameter('id') . '&redirect_to=view') ?>
  </div>
</div>

<?php include_component('projects','listing',array('reports_id'=>$sf_request->getParameter('id'))) ?>