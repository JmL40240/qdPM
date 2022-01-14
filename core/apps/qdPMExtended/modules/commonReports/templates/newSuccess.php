

<?php echo ajax_modal_template(__('New Report')) ?>


<form class="form-horizontal" role="form">
<div class="modal-body" style="padding-bottom: 0px;">
  <div class="form-body" >
  
  <div class="form-group" style="margin-bottom: 0px;">
  	<label class="col-md-3 control-label"> <?php echo __('Type')?></label>
  	<div class="col-md-9">
      <?php  echo select_tag('report_type','',array('choices'  => $choices),array('class'=>'form-control','onChange'=>'load_form_by_report_type(\'form_container\',\'' . url_for('commonReports/newReport') . '\',this.value)')) ?>
  	</div>
  </div>

  </div>
</div>
</form>    

<div  id="form_container"></div>

<script type="text/javascript">
  $(document).ready(function(){ 
      load_form_by_report_type('form_container','<?php echo url_for("commonReports/newReport") ?>',$('#report_type').val());            
  });     
</script>
