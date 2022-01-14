
<?php echo ajax_modal_template(__('Configuration')) ?>

<form action="<?php echo url_for('scheduler/configuration') ?>" method="post">
<div class="modal-body">
  <div class="form-body">
  
<input type="hidden" name="sf_method" value="put" />
<?php echo input_hidden_tag('users_id',$sf_request->getParameter('users_id')) ?>
<table>
  <!--tr>
    <td><?php echo input_checkbox_tag('scheduler_evens_onmenu',1,array('checked'=>$checked['onmenu']))?></td>
    <td><label for="scheduler_evens_onmenu"><?php echo __('Display today\'s events in the menu') ?></label></td>
  </tr-->
  <tr>
    <td><?php echo input_checkbox_tag('scheduler_evens_onhome',1,array('checked'=>$checked['ondashboard']))?></td>
    <td><label for="scheduler_evens_onhome"><?php echo __('Display today\'s events in the dashboard') ?></label></td>
  </tr>
  <tr>
    <td><?php echo input_checkbox_tag('scheduler_email_evens',1,array('checked'=>$checked['byemail']))?></td>
    <td><label for="scheduler_email_evens"><?php echo __('Send today\'s events by email') ?></label></td>
  </tr>
</table>

  </div>
</div>

<?php echo ajax_modal_template_footer(); ?>
</form>