<?php include_component('projects','shortInfo', array('projects'=>$projects)) ?>

<div class="row">
    <div class="col-md-8 project-info">
  
  <div class="panel panel-default item-description">
			<div class="panel-heading">
				<h3 class="panel-title"><?php echo __('Description') ?></h3>
			</div>
			<div class="panel-body">
        <div class="itemDescription"><?php echo  replaceTextToLinks($projects->getDescription()) ?></div>
        <div id="extraFieldsInDescription"><?php echo ExtraFieldsList::renderDescriptionFileds('projects',$projects,$sf_user) ?></div>
        <div><?php include_component('attachments','attachmentsList',array('bind_type'=>'projects','bind_id'=>$projects->getId())) ?></div>
      </div>
    </div>
<?php
$comments_access = Users::getAccessSchema('projectsComments',$sf_user,$projects->getId());
if($comments_access['view']):

$lc = new cfgListingController($sf_context->getModuleName(),'projects_id=' . $sf_request->getParameter('projects_id'));
?>

<?php  if($comments_access['insert'])echo $lc->insert_button(__('Ajouter Revue')) ?>

<div <?php echo (count($projects_comments)==0 ? 'class="table-scrollable"':'')?> >
<table class="table table-striped table-bordered table-hover" id="comments-table">
  <thead>
    <tr>
      <th></th>
      <th width="100%"><?php echo __('Commentaire Revue') ?></th>
      <th><?php echo __('Date Revue') ?></th>          
    </tr>
  </thead>
  <tbody>
    <?php foreach ($projects_comments as $c): ?>
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
        <div><?php include_component('attachments','attachmentsList',array('bind_type'=>'projectsComments','bind_id'=>$c['id'])) ?></div>
        <div><?php include_component('projectsComments','info',array('c'=>$c)) ?></div>
      </td>
      <td><?php echo app::dateTimeFormat($c['created_at']) . '<br>' . $c['Users']['name'] . '<br>' .renderUserPhoto($c['Users']['photo']) ?></td>      
    </tr>
    <?php endforeach; ?>
    <?php if(count($projects_comments)==0) echo '<tr><td colspan="3">' . __('No Records Found') . '</td></tr>' ?>
  </tbody>
</table>
</div>
<?php //sif($comments_access['insert']) echo $lc->insert_button(__('Ajouter Revue')); ?>

<?php if(count($projects_comments)>0) include_partial('global/jsPagerSimple',array('table_id'=>'comments-table')) ?>

<?php endif ?>

    </div>
    
    <div class="col-md-4">

    <div class="panel panel-info item-details">
  		<div class="panel-heading">  			
  			 <h3 class="panel-title"><?php echo __('Details') ?></h3>  			
  		</div>
  		<div class="panel-body item-details">            
      <?php include_component('projects','details',array('projects'=>$projects)) ?>
      </div>
    </div>
    </div>
</div>    
 
