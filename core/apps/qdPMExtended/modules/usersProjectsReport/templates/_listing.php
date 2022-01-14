<?php echo javascript_include_tag('treeview/jquery.treeview.js') ?>
<?php echo javascript_include_tag('treeview/jquery.cookie.js') ?>
<?php echo stylesheet_tag('/js/treeview/jquery.treeview.css') ?>

<ul id="users_tree" style="display: none;">
<?php foreach($userscountprojects as $id=>$count): ?>
  <li><?php echo '<a href="#" onclick="return false" title="' . addslashes($usersnames[$id]) . '" class="jt" rel="' . url_for('users/info?id=' . $id). '">' . $usersnames[$id] . ' (' . $count . ')</a>' ?>
    <ul>
      <?php foreach($usersprojects[$id] as $pid): ?>
        <li><?php echo link_to($projectsnames[$pid],'projects/open?projects_id=' . $pid,array('title'=>__('Project Info'),'class'=>'jt','rel'=>url_for('projects/info?id=' . $pid))) ?></li>
      <?php endforeach?>  
    </ul>
  </li>
<?php endforeach?>
</ul>

<?php if(count($userscountprojects)==0) echo __('No Records Found') ?>

<script>
  $(function() {
    $("#users_tree").css('display','');  
  	$("#users_tree").treeview({collapsed: true});
  });
</script>

<?php include_partial('global/jsTips'); ?>