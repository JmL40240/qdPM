
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h4 class="modal-title"><?php echo __('Sort Filters') ?></h4>
</div>

<div class="modal-body">

<?php echo __('Just move an item up or down.') ?>

<?php
  switch($sf_context->getModuleName())
  {
    case 'usersProjectsReport':
    case 'projects':
        $t = 'ProjectsReports';         
      break;
    case 'usersTasksReport':  
    case 'ganttChart':
    case 'timeReport':
    case 'tasks':
        $t = 'UserReports';         
      break;
    case 'tickets':
        $t = 'TicketsReports';         
      break;
    case 'discussions':
        $t = 'DiscussionsReports';         
      break;
        
  }
  
  $itmes = Doctrine_Core::getTable($t)
          ->createQuery()
          ->addWhere('report_type=?',$sf_request->getParameter('sort_filters'))
          ->addWhere('users_id=?',$sf_user->getAttribute('id'))
          ->orderBy('sort_order, name')
          ->fetchArray();
?>

<div class="dd" id="nestable_list_1">
  <ol class="dd-list" id="sorted_items" >
  <?php
    foreach($itmes as $v)
    {
      echo '<li class="dd-item"  data-id="' . $v['id'] . '"><div class="dd-handle">' . $v['name'] . '</div></li>';
    }
  ?>
  </ol>
</div>

</div>

<div class="modal-footer">
  <?php echo button_to_tag(__('Save'),$sf_context->getModuleName() . '/index' . ($sf_request->hasParameter('projects_id')?'?projects_id=' . $sf_request->getParameter('projects_id'):''),array('class'=>'btn btn-primary')) ?>
  <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Close') ?></button>
</div>

<script>
  $(function() {
    $('#nestable_list_1').nestable({maxDepth:1}).on('change', function(){
      droppableOnUpdate('nestable_list_1','<?php echo url_for("app/SortItemsProcess?t=" . $t)?>')            
    });
  });
</script>     
      
