<?php
  $lc = new listingController('tasks',$url_params,$sf_request,$sf_user);
  $extra_fields = ExtraFieldsList::getFieldsByType('tasks',$sf_user,true,array('all'=>true));
  $extra_fields_all = ExtraFieldsList::getFieldsByType('tasks',$sf_user,false,array('all'=>true));
  $totals = array();
  $totals['EstimatedTime'] = 0;
  $totals['WorkHours'] = 0;
  $totals['TogoHours'] = 0;
  $totals['ActualTime'] = 0;
    
  $is_filter = array();
  $is_filter['TasksPriority'] = app::countItemsByTable('TasksPriority');
  $is_filter['TasksLabels'] = app::countItemsByTable('TasksLabels');
  $is_filter['TasksStatus'] = app::countItemsByTable('TasksStatus');
  $is_filter['TasksTypes'] = app::countItemsByTable('TasksTypes');
  $is_filter['TasksGroups'] = app::countItemsByTable('TasksGroups',$sf_request->getParameter('projects_id'));      
  $is_filter['Versions'] = app::countItemsByTable('Versions',$sf_request->getParameter('projects_id'));
  $is_filter['ProjectsPhases'] = app::countItemsByTable('ProjectsPhases',$sf_request->getParameter('projects_id'));
  
  $in_listing = explode(',',sfConfig::get('app_tasks_columns_list'));
            
  foreach($is_filter as $k=>$v)
  {
    if($v==0 and array_search($k,$in_listing)>0)
    {      
      unset($in_listing[array_search($k,$in_listing)]);
    }
  }
      
  if($sf_request->hasParameter('projects_id'))
  {
    if($projects = Doctrine_Core::getTable('Projects')->find($sf_request->getParameter('projects_id')))
    {
      if($projects->getProjectsTypesId()>0)
      {
        if(strlen($projects->getProjectsTypes()->getTasksColumnsList())>0)
        {
          $in_listing = explode(',',$projects->getProjectsTypes()->getTasksColumnsList());
        }
      }
    }
  }
  
  $cols = 1;
  
  $has_comments_access = Users::hasAccess('view','tasksComments',$sf_user);
?>   

<table width="100%">
  <tr>
    <td>
      <table>
        <tr>
          <?php if($display_insert_button): ?>
          <td style="padding-right: 15px;"><?php  echo $lc->insert_button(__('Add Task')) ?></td>
          <?php endif ?>
          <td style="padding-right: 15px;"><div id="tableListingMultipleActionsMenu"><?php echo $lc->rednerWithSelectedAction($tlId) ?></div></td>
          
          <?php if($sf_request->hasParameter('projects_id')): ?>
            <td style="padding-right: 15px;"><?php include_component('tasks','viewType', array('projects'=>$projects)) ?></td>
          <?php endif ?>          
        </tr>
      </table>
    </td>
<?php if(!isset($is_dashboard) and !$reports_id): ?>            
    <td align="right">
      <table>
        <tr>
          <td><?php include_component('app','searchMenu') ?></td>
          <td><?php include_component('app','orderByMenu',array('module'=>'tasks')) ?></td>          
        </tr>
      </table>
    </td> 
<?php endif ?>  
  </tr>
</table>

<?php include_partial('app/searchResult') ?>
      
<div <?php echo  (count($tasks_list)==0 ? 'class="table-scrollable"':'')?> >
        
<table class="table table-striped table-bordered table-hover tasks-table" id="itmes_listing_<?php echo $tlId ?>"  <?php echo (count($tasks_list)>0 ? 'style="display:none"':'')?> >
  <thead>
    <tr>
      <?php echo $lc->rednerMultipleSelectTh() ?>
      <?php echo $lc->rednerActionTh() ?>      
      
      <?php if(in_array('Id',$in_listing)):  ?>
      <th data-bsType="numeric"><div><?php echo __('Id') ?></div></th>
      <?php endif; ?>
      
      <?php if(in_array('TasksGroups',$in_listing)):  ?>
      <th><div><?php echo __('Group') ?></div></th>
      <?php endif; ?>
      
      <?php if(in_array('Versions',$in_listing)):  ?>
      <th><div><?php echo __('Version') ?></div></th>
      <?php endif; ?>
      
      <?php if(in_array('ProjectsPhases',$in_listing)):  ?>
      <th><div><?php echo __('Phase') ?></div></th>
      <?php endif; ?>
      
      <?php if(in_array('TasksPriority',$in_listing)):  ?>
      <th><div><?php echo __('Priority') ?></div></th>
      <?php endif; ?>
            
      <?php if(in_array('TasksTypes',$in_listing)):  ?>
      <th><div><?php echo __('Type') ?></div></th>
      <?php endif; ?>
	  
	   <?php if(in_array('TasksStatus',$in_listing)):  ?>
      <th><div><?php echo __('Status') ?></div></th>  
      <?php endif; ?>
	  
		<?php if(in_array('StartDate',$in_listing)):  ?>
      <th><div><?php echo __('Start Date') ?></div></th>
      <?php endif; ?>
      
      <?php if(in_array('DueDate',$in_listing)):  ?>
      <th><div><?php echo __('Due Date') ?></div></th>
      <?php endif; ?>

	  <?php if(in_array('AssignedTo',$in_listing)): ?>            
      <th><div><?php echo __('Assigned To') ?></div></th>
      <?php endif; ?>	  
                                              
      <?php if(in_array('Name',$in_listing)):  ?>
      <th ><div><?php echo __('Name') ?></div></th>
      <?php endif; ?>    
      
      <?php if(in_array('TasksLabels',$in_listing)):  ?>
      <th><div><?php echo __('Label') ?></div></th>
      <?php endif; ?>
	  
      <?php if(in_array('CreatedBy',$in_listing)):  ?>            
      <th><div><?php echo __('Created By') ?></div></th>
      <?php endif; ?>
      
      <?php if(in_array('EstimatedTime',$in_listing)):  ?>
      <th data-bsType="numeric"><div><?php echo __('Est. Time') ?></div></th>
      <?php endif; ?>
      
      <?php if(in_array('WorkHours',$in_listing)):  ?>
      <th data-bsType="numeric"><div><?php echo __('Work Hours') ?></div></th>
      <?php endif; ?>
      
      <!--<?php //if(in_array('TogoHours',$in_listing)):  ?>
      <th data-bsType="numeric"><div><?php //echo __('Hours To Go') ?></div></th>
      <?php //endif; ?>-->
      
      <?php if(in_array('ActualTime',$in_listing)):  ?>
      <th data-bsType="numeric"><div><?php echo __('Actual Time') ?></div></th>
      <?php endif; ?>
            
      <?php if(in_array('Progress',$in_listing)):  ?>
      <th><div><?php echo __('Progress') ?></div></th>
      <?php endif; ?>
      
      <?php if(in_array('CreatedAt',$in_listing)):  ?>
      <th><div><?php echo __('Created At') ?></div></th>
      <?php endif; ?>
      
      <?php echo ExtraFieldsList::renderListingThead($extra_fields) ?>
      
      <?php if(!$sf_request->hasParameter('projects_id')): ?>
      <th><div><?php echo __('Project') ?></div></th>
      <?php endif; ?>                  
    </tr>
  </thead>
  
  <tbody>  
    <?php foreach ($tasks_list as $tasks): ?>
    <tr>     
      <?php echo $lc->rednerMultipleSelectTd($tasks['id']) ?>
      <?php echo $lc->renderActionTd($tasks['id'],(!$sf_request->hasParameter('projects_id') ? $tasks['projects_id']:0),false,__('Are you sure you want to delete task') . '\n' . $tasks['name'] . '?') ?>      
      
      <?php if(in_array('Id',$in_listing)): ?>
      <td><?php echo $tasks['id'] ?></td>
      <?php endif; ?>
            
      <?php if(in_array('TasksGroups',$in_listing)): ?>
      <td><?php echo app::getArrayName($tasks,'TasksGroups') ?></td>
      <?php endif; ?>
      
      <?php if(in_array('Versions',$in_listing)): ?>
      <td><?php echo app::getArrayName($tasks,'Versions') ?></td>
      <?php endif; ?>
      
      <?php if(in_array('ProjectsPhases',$in_listing)): ?>
      <td><?php echo app::getArrayName($tasks,'ProjectsPhases') ?></td>
      <?php endif; ?>
      
      <?php if(in_array('TasksPriority',$in_listing)): ?>
      <td><?php echo app::getArrayNameWithIcon($tasks,'TasksPriority') ?></td>
      <?php endif; ?>
            
      <?php if(in_array('TasksTypes',$in_listing)): ?>
      <td><?php echo app::getArrayNameWithBg($tasks,'TasksTypes') ?></td>
      <?php endif; ?>
	  
	   <?php if(in_array('TasksStatus',$in_listing)): ?>
      <td><?php echo app::getArrayNameWithBg($tasks,'TasksStatus') ?></td>
      <?php endif; ?>
	  
	   <?php if(in_array('StartDate',$in_listing)): ?>
      <td><?php echo app::dateTimeFormat($tasks['start_date'],0,true) ?></td>
      <?php endif; ?>
      
      <?php if(in_array('DueDate',$in_listing)): ?>
      <td><?php echo app::dueDateFormat($tasks['due_date'],0,true) ?></td>
      <?php endif; ?>
	  
	    <?php if(in_array('AssignedTo',$in_listing)): ?>            
      <td><?php echo Users::getNameById($tasks['assigned_to'],'<br>',$users_schema) ?></td>
      <?php endif; ?>
	  
	    <?php if(in_array('TasksLabels',$in_listing)): ?>
      <td><?php echo app::getArrayNameWithBg($tasks,'TasksLabels') ?></td>
      <?php endif; ?>
                                    
      <?php if(in_array('Name',$in_listing)): ?>                              
      <td>
        <?php echo link_to($tasks['name'],'tasksComments/index?tasks_id=' . $tasks['id'] . '&projects_id=' . $tasks['projects_id'])  ?> 
        <?php if($has_comments_access) echo  ' '. app::getLastCommentByTable('TasksComments','tasks_id',$tasks['id']) ?>
      </td>
      <?php endif; ?> 
      
      <?php if(in_array('CreatedBy',$in_listing)): ?>            
      <td><?php echo app::getArrayName($tasks,'Users') ?></td>
      <?php endif; ?>
      
      <?php if(in_array('EstimatedTime',$in_listing)): $totals['EstimatedTime']+= $tasks['estimated_time']; ?>
      <td><?php echo $tasks['estimated_time'] ?></td>
      <?php endif; ?>
      
      <?php if(in_array('WorkHours',$in_listing)):  $totals['WorkHours']+= $tasks['work_hours']; ?>
      <td><?php echo $tasks['work_hours'] ?></td>
      <?php endif; ?>
      
      <!--<?php //if(in_array('TogoHours',$in_listing)):  $totals['TogoHours']+= $tasks['togo_hours']; ?>
      <td><?php //echo $tasks['togo_hours'] ?></td>-->
      <?php //endif; ?>
      
      <?php 
        if(in_array('ActualTime',$in_listing)):  
          if($tasks['work_hours']>0 and $tasks['togo_hours']==0)
          {
           $actual_time = (float)$tasks['estimated_time']-(float)$tasks['work_hours'];
          }
          else
          {
            //$actual_time = (float)$tasks['estimated_time']-(float)$tasks['work_hours']+(float)$tasks['togo_hours']; 
			$actual_time = (float)$tasks['estimated_time']-(float)$tasks['work_hours']; 
		  }
          $totals['ActualTime']+= $actual_time;
      
       ?>
      <td><?php echo $actual_time ?></td>
      <?php endif; ?>   
      
      <?php if(in_array('Progress',$in_listing)): ?>
      <td><?php echo (int)$tasks['progress'] ?>%</td>
      <?php endif; ?>
      
      <?php if(in_array('CreatedAt',$in_listing)): ?>
      <td><?php echo app::dateTimeFormat($tasks['created_at'],0,true) ?></td>
      <?php endif; ?>
      
      <?php
        $v = ExtraFieldsList::getValuesList($extra_fields_all,$tasks['id']); 
        echo ExtraFieldsList::renderListingTbody($extra_fields,$v,array('est_time'=>$tasks['estimated_time'],'work_hours'=>$tasks['work_hours']));
        $totals = ExtraFieldsList::getListingTotals($totals, $extra_fields,$v,array('est_time'=>$tasks['estimated_time'],'work_hours'=>$tasks['work_hours']))  
      ?>
      
      <?php if(!$sf_request->hasParameter('projects_id')): ?>
      <td><?php echo link_to(app::getArrayName($tasks,'Projects'),'projectsComments/index?projects_id=' . $tasks['projects_id']) ?></td>
      <?php endif; ?>
    </tr>
    <?php endforeach; ?>
    </tbody>
    
    <?php if(count($tasks_list)>0 and count($totals)>0): ?>
    <tfoot>
    <tr>
      <td></td>
      <?php if($lc->access['edit'] or $lc->access['delete']) echo '<td></td>'?>
      <?php	   
		echo '<td></td>';
		echo '<td></td>';
		echo '<td></td>';
		echo '<td></td>';
		echo '<td></td>';
		echo '<td></td>';
		echo '<td></td>';
		echo '<td>' . $totals["EstimatedTime"] . '</td>';
		echo '<td>' .$totals["WorkHours"] . '</td>';
		//echo '<td>' . $totals["TogoHours"] . '</td>';
		echo '<td>' . ($totals["EstimatedTime"] - $totals["WorkHours"]) . '</td>';
		
        /*foreach($in_listing as $v)
        {
          if(in_array($v,array('EstimatedTime','WorkHours','TogoHours','ActualTime')))
          {
            echo '<td>' . $totals[$v] . '</td>';
          }
          else
          {        
            echo '<td></td>';
          }
        }*/
      ?>
      <?php echo ExtraFieldsList::renderListingTotals($totals,$extra_fields) ?>
      <?php if(!$sf_request->hasParameter('projects_id')) echo '<td></td>' ?>
    </tr>  
    </tfoot>
    <?php endif ?>
    
    <?php if(sizeof($tasks_list)==0) echo '<tr><td colspan="30">' . __('No Records Found') . '</td></tr>';?>
  
</table>
  
</div>

<?php include_partial('global/pager', array('total'=>count($tasks_list), 'pager'=>$pager,'url_params'=>($sf_request->getParameter('projects_id')>0 ? 'projects_id=' . $sf_request->getParameter('projects_id'):'') . ($reports_id>0 ? 'id=' . $reports_id:'') ,'page'=>$sf_request->getParameter('page',1),'reports_action'=>'userReports','reports_id'=>$reports_id)) ?>

<?php include_partial('global/jsTips'); ?>

<?php 
  if(count($tasks_list)>0)
  { 
    include_partial('global/jsPager',array('table_id'=>'itmes_listing_' . $tlId)); 
  }
?>

  