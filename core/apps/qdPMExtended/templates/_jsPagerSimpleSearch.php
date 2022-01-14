
<script type="text/javascript">
  $(document).ready(function(){
  
    var table = $('#<?php echo $table_id ?>').dataTable({
      "iDisplayLength": <?php echo sfConfig::get('app_rows_per_page') ?>,
      "sPaginationType": "bootstrap",
      "bSort": false,        
      "bFilter":true,            
      "bLengthChange":false,
      "pagingType": "simple_numbers",      
      "oLanguage": {                    
                        "oPaginate": {
                            "sPrevious": "<i class=\"fa fa-angle-left\"></i>",
                            "sNext": "<i class=\"fa fa-angle-right\"></i>"
                        },
                        "sInfo": "<?php echo __('Displaying') ?> _START_ - _END_, <?php echo __('Total') ?>: _TOTAL_ "
                    }
      });
                                                                
  });
  
