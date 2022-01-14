<?php if($sf_request->hasParameter('projects_id')) include_component('projects','shortInfo', array('projects'=>$projects)) ?>

<h3 class="page-title"><?php echo __('Sort Tasks') ?></h3>

<form action="<?php echo url_for('tasks/index?projects_id=' . $sf_request->getParameter("projects_id")) ?>" method="post" >
  <?php //echo submit_tag(__('Save')) ?>
  
<div class="dd" id="nestable_list_1">  
  <ol class="dd-list">
    <?php echo TasksTree::getTasksHtmlTree($tasks_tree)?>
  </ol>
</div>        
</form>

<script>

  $(document).ready(function(){
  
    $('#nestable_list_1').nestable({group: 1}).on('change', function(){    
      droppableOnUpdate('nestable_list_1','<?php echo url_for("tasks/sortTree?projects_id=" . $sf_request->getParameter("projects_id"))?>')
    });
    
  })
  
</script>  