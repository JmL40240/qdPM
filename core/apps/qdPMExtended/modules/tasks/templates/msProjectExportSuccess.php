<h1><?php echo __('Export') ?></h1>

<div><?php echo __('You are exporting tasks to MS Project') ?></div><br> 

<form method="post" action="<?php echo url_for('tasks/msProjectExport') ?>">
<?php if($sf_request->hasParameter('projects_id')) echo input_hidden_tag('projects_id',$sf_request->getParameter('projects_id')) ?>


<div><?php echo __('Filename') . ': ' .  input_tag('filename',$projects->getName(),array('size'=>40)) ?></div><br>

<input type="submit" value="<?php echo __('Export') ?>" class="btn">

<?php echo input_hidden_tag('selected_items') ?>
</form>

<script>
  set_selected_items();
</script>