<h3 class="page-title"><?php echo __('Common Reports') ?></h3>

<form action="<?php echo url_for('myCommonReports/index?hide=reports') ?>" method="post">
<div class="table-scrollable">
	<table class="table table-striped table-bordered table-hover">
  <thead>
    <tr>
      <th><?php echo __('Hide') ?></th>            
      <th><?php echo __('Type') ?></th>
      <th width="100%"><?php echo __('Name') ?></th>
      <th><?php echo __('Display on dashboard') ?></th>      
      <th><?php echo __('Display in menu') ?></th>                  
    </tr>
  </thead>
  <tbody>   
    <?php 
    $count_mandatory = 0;
    foreach ($projects_reports as $reports):   
      if($is_mandatory = (bool)$reports->getIsMandatory()==1) $count_mandatory++;       
    ?>
    <tr>      
      <td><?php if(!$is_mandatory) echo input_checkbox_tag('hidden[projectsReports]',$reports->getId(),array('checked'=>in_array('projectsReports'.$reports->getId(),$hidden_reports))) ?></td>
      <td><?php echo __('Projects Reports') ?></td>      
      <td><?php echo link_to($reports->getName(),'projectsReports/view?id=' . $reports->getId()) . ($is_mandatory ? ' (' . __('Mandatory Report') . ')':'') ?></td>      
      <td><?php echo renderBooleanValue($reports->getDisplayOnHome()) ?></td>      
      <td><?php echo renderBooleanValue($reports->getDisplayInMenu()) ?></td>      
    </tr>
    <?php endforeach; ?>
        
    <?php foreach ($user_reports as $reports): 
      if($is_mandatory = (bool)$reports->getIsMandatory()==1) $count_mandatory++;
    ?>
    <tr>      
      <td><?php if(!$is_mandatory) echo input_checkbox_tag('hidden[userReports]',$reports->getId(),array('checked'=>in_array('userReports'.$reports->getId(),$hidden_reports))) ?></td>
      <td><?php echo __('Tasks Reports') ?></td>      
      <td><?php echo link_to($reports->getName(),'userReports/view?id=' . $reports->getId()) . ($is_mandatory ? ' (' . __('Mandatory Report') . ')':'') ?></td>      
      <td><?php echo renderBooleanValue($reports->getDisplayOnHome()) ?></td>      
      <td><?php echo renderBooleanValue($reports->getDisplayInMenu()) ?></td>      
    </tr>
    <?php endforeach; ?>
            
    <?php foreach ($tickets_reports as $reports): 
      if($is_mandatory = (bool)$reports->getIsMandatory()==1) $count_mandatory++;
    ?>
    <tr>      
      <td><?php if(!$is_mandatory) echo input_checkbox_tag('hidden[ticketsReports]',$reports->getId(),array('checked'=>in_array('ticketsReports'.$reports->getId(),$hidden_reports))) ?></td>
      <td><?php echo __('Tickets Reports') ?></td>      
      <td><?php echo link_to($reports->getName(),'ticketsReports/view?id=' . $reports->getId()) . ($is_mandatory ? ' (' . __('Mandatory Report') . ')':'') ?></td>      
      <td><?php echo renderBooleanValue($reports->getDisplayOnHome()) ?></td>      
      <td><?php echo renderBooleanValue($reports->getDisplayInMenu()) ?></td>      
    </tr>
    <?php endforeach; ?>
            
    <?php foreach ($discussions_reports as $reports): 
      if($is_mandatory = (bool)$reports->getIsMandatory()==1) $count_mandatory++;
    ?>
    <tr>      
      <td><?php if(!$is_mandatory) echo input_checkbox_tag('hidden[discussionsReports]',$reports->getId(),array('checked'=>in_array('discussionsReports'.$reports->getId(),$hidden_reports))) ?></td>
      <td><?php echo __('Projects Reports') ?></td>      
      <td><?php echo link_to($reports->getName(),'discussionsReports/view?id=' . $reports->getId()) . ($is_mandatory ? ' (' . __('Mandatory Report') . ')':'') ?></td>      
      <td><?php echo renderBooleanValue($reports->getDisplayOnHome()) ?></td>      
      <td><?php echo renderBooleanValue($reports->getDisplayInMenu()) ?></td>      
    </tr>
    <?php endforeach; ?>
    
    
    
    <?php 
    $count_reports = sizeof($projects_reports)+sizeof($user_reports)+sizeof($tickets_reports)+sizeof($discussions_reports); 
    if($count_reports==0) echo '<tr><td colspan="5">' . __('No Records Found') . '</td></tr>';?>
  </tbody>
</table>
</div>
<?php if($count_reports>0 and $count_reports!=$count_mandatory) echo submit_tag(__('Update'));?>
</form>


