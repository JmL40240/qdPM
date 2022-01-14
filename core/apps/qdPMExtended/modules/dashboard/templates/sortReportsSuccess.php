<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h4 class="modal-title"><?php echo __('Sort Items') ?></h4>
</div>

<form action="<?php echo url_for('dashboard/index')?>" method="post">
<div class="modal-body">

<?php echo __('Just move an item up or down.') ?>

<div class="dd" id="nestable_list_1">
<ol class="dd-list" id="sorted_items" >
<?php

foreach($reports as $report)
  {
    if(in_array($report,$hidden_common_reports)) continue;
  
    switch(true)
    {
      case strstr($report,'personalEvents'):          
          echo '<li class="dd-item" data-id="personalEvents"><div class="dd-handle">' . __('Personal Scheduler') . '</div></li>';           
        break;
      case strstr($report,'publicEvents'):            
          echo '<li class="dd-item" data-id="publicEvents"><div class="dd-handle">' . __('Public Scheduler') . '</div></li>';           
        break;  
      case strstr($report,'projectsReports'):
          if($r = Doctrine_Core::getTable('ProjectsReports')->find(str_replace('projectsReports','',$report)))
          {  
            echo '<li class="dd-item" data-id="projectsReports' . $r->getId() . '"><div class="dd-handle">' . $r->getName() . '</div></li>';
          } 
        break;
      case strstr($report,'userReports'):
          if($r = Doctrine_Core::getTable('UserReports')->find(str_replace('userReports','',$report)))
          {  
            echo '<li class="dd-item" data-id="userReports' . $r->getId() . '"><div class="dd-handle">' . $r->getName() . '</div></li>';
          } 
        break;
      case strstr($report,'ticketsReports'):
          if($r = Doctrine_Core::getTable('TicketsReports')->find(str_replace('ticketsReports','',$report)))
          {  
            echo '<li class="dd-item" data-id="ticketsReports' . $r->getId() . '"><div class="dd-handle">' . $r->getName() . '</div></li>';
          } 
        break;
      case strstr($report,'discussionsReports'):
          if($r = Doctrine_Core::getTable('DiscussionsReports')->find(str_replace('discussionsReports','',$report)))
          {  
            echo '<li class="dd-item" data-id="discussionsReports' . $r->getId() . '"><div class="dd-handle">' . $r->getName() . '</div></li>';
          } 
        break;
    }
  }
?> 

</ol>
</div>

</div>

<?php echo ajax_modal_template_footer() ?>
</form>

<script>

$(function() {

  $('#nestable_list_1').nestable({maxDepth:1}).on('change', function(){
    droppableOnUpdate('nestable_list_1','<?php echo url_for("dashboard/sortReports?put=1") ?>')            
  });

  
});


</script> 