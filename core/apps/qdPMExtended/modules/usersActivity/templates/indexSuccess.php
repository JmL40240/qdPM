<?php if($sf_request->hasParameter('projects_id')) include_component('projects','shortInfo', array('projects'=>$projects)) ?>

<h3 class="page-title"><?php echo __('Users Activity') ?></h3>

<?php include_partial('list',array('atcivity_list'=>$atcivity_list,'filters'=>$filters)) ?>