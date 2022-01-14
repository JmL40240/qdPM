<?php echo javascript_include_tag('treeview/jquery.treeview.js') ?>
<?php echo javascript_include_tag('treeview/jquery.cookie.js') ?>
<?php echo stylesheet_tag('/js/treeview/jquery.treeview.css') ?>

<ul id="users_tree" style="display: none">
<?php foreach($userscounttasks as $id=>$count): ?>
  <li><?php echo '<a href="#" onclick="return false" title="' . addslashes($usersnames[$id]) . '" class="jt" rel="' . url_for('users/info?id=' . $id). '">' . $usersnames[$id] . ' (' . $count . ')</a>' ?>
    <ul>
      <?php foreach($userstasks[$id] as $tid): ?>
        <li><?php echo link_to($tasksnames[$tid],'tasksComments/index?projects_id=' . $taskstoprojects[$tid] . '&tasks_id=' . $tid,array('title'=>__('Task Info'),'class'=>'jt','rel'=>url_for('tasks/info?projects_id=' . $taskstoprojects[$tid]. '&id=' . $tid))) ?></li>
      <?php endforeach?>  
    </ul>
  </li>
<?php endforeach?>
</ul>

<?php if(count($userscounttasks)==0) echo __('No Records Found') ?>

<script>
  $(function() {
    $("#users_tree").css('display','');  
  	$("#users_tree").treeview({collapsed: true});
  });
</script>

<?php include_partial('global/jsTips'); ?>