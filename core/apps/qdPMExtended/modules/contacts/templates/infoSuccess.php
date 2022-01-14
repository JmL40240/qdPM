
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h4 class="modal-title"><?php echo $contacts->getName() ?></h4>
</div>

<div class="modal-body">

<table class="table">
  <tr>
    <td><?php echo __('Email') ?></td>
    <td><?php echo '<a href="mailto: ' . $contacts->getEmail() . '">' . $contacts->getEmail() . '</a>' ?></td>
  </tr>
  <?php if($contacts->getContactsGroupsId()>0): ?>
  <tr>
    <td><?php echo __('Group') ?></td>
    <td><?php echo $contacts->getContactsGroups()->getName() ?></td>
  </tr>
  <?php endif ?>
  
  <?php echo ExtraFieldsList::renderInfoFileds('contacts',$contacts,$sf_user) ?>
  
</table> 

</div> 

<?php echo ajax_modal_template_footer_simple() ?>