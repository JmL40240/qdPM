<?php
/**
*qdPM
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@qdPM.net so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade qdPM to newer
* versions in the future. If you wish to customize qdPM for your
* needs please refer to http://www.qdPM.net for more information.
*
* @copyright  Copyright (c) 2009  Sergey Kharchishin and Kym Romanets (http://www.qdpm.net)
* @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
?>
<script type="text/javascript">
$(document).ready(function(){  
  $.extend($.validator.messages, {required: '<?php echo __("This field is required!") ?>'});
  
  $("#<?php echo $form_id ?>").validate({ignore:'',
    
    //custom erro placment to handle radio etc. 
      errorPlacement: function(error, element) {
        if (element.attr("type") == "radio") 
        {
           error.insertAfter(".radio-list-"+element.attr("data-raido-list"));
        } 
        else if (element.attr("type") == "checkbox") 
        {
           error.insertAfter(".checkboxesList"+element.attr("data-checkbox-list"));
        }
        else 
        {  
           error.insertAfter(element);
        }                
      }, 
    invalidHandler: function(e, validator) {
			var errors = validator.numberOfInvalids();
			if (errors) {
				var message = '<div class="alert alert-danger"><?php echo __("Some fields are required. They have been highlighted above.") ?></div>';
				$("#form_error_handler").fadeIn().html(message).delay(2000).fadeOut();								
			} 
		}});
}); 		
</script>

<div id="form_error_handler" style="display:none"></div>
