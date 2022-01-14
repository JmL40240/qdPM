<h3 class="page-title""><?php echo __('Tasks Listing') ?></h3>

<div><?php echo __('Select tasks fields which will be display in tasks listing by default.<br>Also you can configure own tasks listing for each projects type, see  "Configurations->Projects->Types"'); ?></div>
<br>

<?php echo select_tag('cfg[app_tasks_columns_list]',explode(',',sfConfig::get('app_tasks_columns_list')),array('choices'=>Tasks::getTasksColumnChoices(),'expanded'=>true,'multiple'=>true)) ?> 
    