<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h4 class="modal-title"><?php echo __('Export') ?></h4>
</div>

<form method="post" action="<?php echo url_for('users/export') ?>">

<div class="modal-body">

<div><?php echo __('Select fields to export') ?> <?php echo '<a href="#" onClick="return checkAllInContainer(\'extport_fields\')">' . __('Select All') . '</a>' ?></div><br>


<div id="extport_fields"><?php echo select_tag('fields',array('Name','ProjectsStatus'),array('choices'=>$columns,'expanded'=>true,'multiple'=>true)) ?></div><br>

<div><?php echo __('Filename') . ': ' .  input_tag('filename',__('Users'),array('size'=>40)) ?></div><br>

<div><?php echo __('Format') . ': '. select_tag('format','csv',array('choices'=>array('csv'=>'csv','txt'=>'txt'))) ?></div><br>



<?php echo input_hidden_tag('selected_items') ?>
</div>

<?php echo ajax_modal_template_footer(__('Export')) ?>

</form>

<script>
  set_selected_items();
</script>