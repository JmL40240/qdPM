<div class="row">
  <div class="col-md-9">
    <h3 class="page-title"><?php echo $discussions_reports->getName() ?></h3>
  </div>
  <div class="col-md-3" style="text-align:right">    
    <?php if($discussions_reports->getReportType()!='common') echo button_tag_modalbox(__('Edit Details'),'discussionsReports/edit?id=' .$sf_request->getParameter('id') . '&redirect_to=view') ?>
  </div>
</div>

<?php include_component('discussions','listing',array('reports_id'=>$sf_request->getParameter('id'))) ?>