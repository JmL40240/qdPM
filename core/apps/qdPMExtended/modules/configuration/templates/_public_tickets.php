<h3 class="page-title"><?php echo __('Public Tickets') ?></h3>

<div><?php echo __('Users can submit Tickets without registration.') ?></div>

<br>

<table class="contentTable">
  <tr>
    <th><label for="cfg_app_use_public_tickets"><b><?php echo __('Use Public Tickets'); ?></b></label></th>
    <td><?php echo select_tag('cfg[app_use_public_tickets]',sfConfig::get('app_use_public_tickets'),array('choices'=>$default_selector),array('class'=>'form-control')) ?></td>
  </tr>
  <tr>
    <th><label for="cfg_app_public_tickets_allow_attachments">&nbsp;- <?php echo __('Allow attachments in public tickets form'); ?></label></th>
    <td><?php echo select_tag('cfg[app_public_tickets_allow_attachments]',sfConfig::get('app_public_tickets_allow_attachments'),array('choices'=>$default_selector),array('class'=>'form-control')) ?></td>
  </tr>
  <tr>
    <th><label for="cfg_app_public_tickets_use_antispam">&nbsp;- <?php echo __('Use antispam protection in form'); ?></label></th>
    <td><?php echo select_tag('cfg[app_public_tickets_use_antispam]',sfConfig::get('app_public_tickets_use_antispam'),array('choices'=>$default_selector),array('class'=>'form-control')) ?></td>
  </tr>
</table>

<br>
<div><b><?php echo __('Integration Code') ?></b></div>
<p><?php echo __('Integration code helps you integrate the Public Ticket form into your web site. Just copy code below and paste it into your page.<br>You can change "width" or "height" parameters if needed.<br> See "css/submitTickets/styles.css" to update css for public tickets form.'); ?></p>
<br>

<?php

$code = '<iframe width="700" height="600" scrolling="no" frameborder="0" style="border: 0" src="' . url_for('publicTickets/submitTicket',true). '"></iframe>';

echo textarea_tag('code',$code,array('style'=>'height: 70px;','class'=>'form-control'));

?>
<br>