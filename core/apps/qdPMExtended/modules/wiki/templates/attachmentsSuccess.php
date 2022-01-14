<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h4 class="modal-title"><?php echo __('Attachments') ?></h4>
</div>

<div class="modal-body">
<p><?php echo __('All attached files has own link that you can insert in page content.')?><br></p>

<table>
  <tr>
    <td>                
      <?php include_component('attachments','attachments',array('bind_type'=>'wiki','bind_id'=>($form->getObject()->isNew()?0:$form->getObject()->getId()))) ?>
      <br>
    </td>
  </tr>
</table> 
</div> 

<?php echo ajax_modal_template_footer_simple() ?>    

