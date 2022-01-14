<?php include_component('projects','shortInfo', array('projects'=>$projects)) ?>

<div class="row">
    <div class="col-md-8 tasks-info">

<?php include_component('tasksComments','breadcrump',array('tasks'=>$tasks)) ?>

    <div class="panel panel-default item-description">
			<div class="panel-heading">
				<h3 class="panel-title">
        
          <table>
            <tr>
              <td><?php include_component('tasksComments','goto',array('tasks'=>$tasks,'projects'=>$projects)) ?></td>
              <td><?php echo ($tasks->getTasksLabelId()>0 ? $tasks->getTasksLabels()->getName(). ': ':'') . $tasks->getName() . ($tasks->getTasksStatusId()>0 ? ' [' . $tasks->getTasksStatus()->getName(). '] ':'') ?></td>    
              <td><?php include_partial('tasksComments/gotoNext') ?></td>
            </tr>
          </table>        
        
        </h3>
			</div>
			<div class="panel-body">

<?php $comments_access = Users::getAccessSchema('tasksComments',$sf_user,$projects->getId());?>

<div class="item-description-panel">
<table>
  <?php if($comments_access['insert'] and sfConfig::get('app_use_tasks_timetracker')=='on'): ?>
    <td style="padding-right: 15px;"><?php echo '<a href="#" id="tasks_timer_open">' . '<i class="fa fa-clock-o"></i> ' . __('Timer') . '</a>' ?></td>
  <?php endif ?>
  
  <?php if(Users::hasAccess('insert','tasksComments',$sf_user,$projects->getId())): ?>
    <td style="padding-right: 15px;"><?php echo link_to_modalbox('<i class="fa fa-comment-o"></i> ' . __('Saisir Réalisé (J)'),'tasksComments/new?projects_id=' . $projects->getId() . '&tasks_id=' . $tasks->getId() . '&redirect_to=tasksComments') ?></td>
  <?php endif ?>
  
  <?php if(Users::hasAccess('edit','tasks',$sf_user,$projects->getId())): ?>
    <td style="padding-right: 15px;"><?php echo link_to_modalbox('<i class="fa fa-edit"></i>  ' . __('Edit Details'),'tasks/edit?projects_id=' . $projects->getId() . '&id=' . $tasks->getId() . '&redirect_to=tasksComments') ?></td>
  <?php endif ?>
  
  <?php if(count($more_actions)>0): ?>
    <td>
      <?php echo renderYuiMenu('more_actions',$more_actions) ?>
      <script type="text/javascript">
        YAHOO.util.Event.onContentReady("more_actions", function () 
        {
            var oMenuBar = new YAHOO.widget.MenuBar("more_actions", {autosubmenudisplay: true,hidedelay: 750,submenuhidedelay: 0,showdelay: 150,lazyload: true });
            oMenuBar.render();
        });
    </script>
    
    </td>
  <?php endif ?>
</table>
</div>





  
    <?php include_component('tasksComments', 'tasksTimer',array('tasks'=>$tasks)) ?>
 
    
    <div class="itemDescription"><?php echo  replaceTextToLinks($tasks->getDescription()) ?></div>
    <div id="extraFieldsInDescription"><?php echo ExtraFieldsList::renderDescriptionFileds('tasks',$tasks,$sf_user,$tasks->getTasksTypes()->getExtraFields()) ?></div>
    <div><?php include_component('attachments','attachmentsList',array('bind_type'=>'tasks','bind_id'=>$tasks->getId())) ?></div>
  </div>
</div>    


<?php echo input_hidden_tag('item_name',$tasks->getName()) . input_hidden_tag('item_description',$tasks->getDescription()); ?>

<?php
if($comments_access['view']):

$lc = new cfgListingController($sf_context->getModuleName(),'projects_id=' . $sf_request->getParameter('projects_id') . '&tasks_id=' . $tasks->getId());
?>


<?php  if($comments_access['insert'])echo $lc->insert_button(__('Saisir Réalisé (J)')) ?>

<div <?php echo (count($tasks_comments)==0 ? 'class="table-scrollable"':'')?> >
<table class="table table-striped table-bordered table-hover" id="comments-table">
  <thead>
    <tr>
      <th><?php echo __('Action') ?></th>
      <th width="100%"><?php echo __('Réalisés (J)') ?></th>
      <th><?php echo __('Réalisé le') ?></th>          
    </tr>
  </thead>
  <tbody>
    <?php foreach ($tasks_comments as $c): ?>
    <tr>
      <td>
        <?php 
          if($comments_access['edit'] and $comments_access['view_own'])
          {
            if($c['created_by']==$sf_user->getAttribute('id')) echo $lc->action_buttons($c['id']);
          }
          elseif($comments_access['edit'])
          {
            echo $lc->action_buttons($c['id']);
          }
           ?>
      </td>            
      <td style="white-space:normal">
        <?php echo replaceTextToLinks($c['description']) ?>
        <div><?php include_component('attachments','attachmentsList',array('bind_type'=>'comments','bind_id'=>$c['id'])) ?></div>
        <div><?php include_component('tasksComments','info',array('c'=>$c)) ?></div>
      </td>
      <td><?php echo app::dateTimeFormat($c['created_at']) . '<br>' . $c['Users']['name'] . '<br>' .renderUserPhoto($c['Users']['photo']) ?></td>      
    </tr>
    <?php endforeach; ?>
    <?php if(count($tasks_comments)==0) echo '<tr><td colspan="3">' . __('No Records Found') . '</td></tr>' ?>
  </tbody>
</table>
</div>
<?php //if($comments_access['insert']) echo $lc->insert_button(__('Saisir Réalisé (J)')); ?>

<?php if(count($tasks_comments)>0) include_partial('global/jsPagerSimple',array('table_id'=>'comments-table')) ?>

<?php endif ?>

    </div>
    
    <div class="col-md-4">

    <div class="panel panel-info item-details">
  		<div class="panel-heading">  			
  			 <h3 class="panel-title"><?php echo __('Details') ?></h3>  			
  		</div>
  		<div class="panel-body item-details">            
      <?php include_component('tasks','details',array('tasks'=>$tasks)) ?>
      </div>
    </div>
    </div>
</div> 
