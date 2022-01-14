
<form id="publicTickets" action="<?php echo url_for('publicTickets/submitProcess') ?>" method="post" enctype="multipart/form-data">
<?php echo $form->renderHiddenFields(false) ?>
<?php echo input_hidden_tag('form_type',$sf_request->getParameter('form_type',$sf_context->getActionName())) ?>
 
<?php echo $form->renderGlobalErrors() ?>

<table class="contentTable">
  <tr>
    <th><?php echo $form['user_name']->renderLabel() ?></th>
    <td>
      <?php echo $form['user_name']->renderError() ?>
      <?php echo $form['user_name'] ?>
    </td>
  </tr>
  <tr>
    <th><?php echo $form['user_email']->renderLabel() ?></th>
    <td>
      <?php echo $form['user_email']->renderError() ?>
      <?php echo $form['user_email'] ?>
    </td>
  </tr>
 <tr><td><br></td></tr>
  <tr>
    <th><?php echo $form['departments_id']->renderLabel() ?></th>
    <td>
      <?php echo $form['departments_id']->renderError() ?>
      <?php if(count($choices = Departments::getChoices(array(1,2)))>1) { echo $form['departments_id']; }else{ echo current($choices); } ?>
    </td>
  </tr>
  <tr>
    <th><?php echo $form['name']->renderLabel() ?></th>
    <td>
      <?php echo $form['name']->renderError() ?>
      <?php echo $form['name'] ?>
    </td>
  </tr>
  <tr>
    <th><?php echo $form['description']->renderLabel() ?></th>
    <td>
      <?php echo $form['description']->renderError() ?>
      <?php echo $form['description'] ?>
    </td>
  </tr>
  
  <?php if(sfConfig::get('app_public_tickets_allow_attachments')=='on'): ?>
  <tr>
    <th><?php echo __('Attach a file') ?></th>
    <td><?php echo input_file_tag('file')?></td>
  </tr>
  <?php endif ?>
  
  <?php if(sfConfig::get('app_public_tickets_use_antispam')=='on'): ?>
  <tr>
    <th><?php echo $form['antispam']->renderLabel() ?><br><?php echo __('Sum of') . ' ' . $sf_user->getAttribute('antispam_query') . '=?'?></th>
    <td>
      <?php echo $form['antispam']->renderError() ?>
      <?php echo $form['antispam'] ?>
    </td>
  </tr>
  <?php endif ?>
</table>

<br>
<?php echo submit_tag(__('Submit Ticket')) ?>
</form>

<?php include_partial('global/formValidator',array('form_id'=>'publicTickets')); ?>
