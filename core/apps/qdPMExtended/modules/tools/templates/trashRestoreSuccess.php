<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h4 class="modal-title"><?php echo __('Restore?') ?></h4>
</div>
<form method="post" action="<?php echo url_for('tools/trashRestore') ?>">

<div class="modal-body">
  <div><?php echo __('Are you sure you want to restore selected items?') ?> </div><br>

  <?php echo input_hidden_tag('selected_items') ?>
</div>

<?php echo ajax_modal_template_footer(__('Restore')) ?>

</form>

<script>
  set_selected_items();
</script>