
<?php $form->setDefault('tickets_types',explode(',', $form['tickets_types']->getValue())); ?>

<form class="form-horizontal"  id="departments" action="<?php echo url_for('departments/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<div class="modal-body">
  <div class="form-body">
  
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>

<?php echo $form->renderHiddenFields(false) ?>

<?php echo $form->renderGlobalErrors() ?>


<ul class="nav nav-tabs">
	<li class="active">
    <a href="#tab_general" data-toggle="tab"><?php echo __('General') ?></a>
  </li>
	<li>
    <a href="#tab_ticket_types" data-toggle="tab"><?php echo __('Ticket Types') ?></a>
  </li>        	
  <li>
    <a href="#tab_public_ticket" data-toggle="tab"><?php echo __('Public Ticket') ?></a>
  </li>
  <li>
    <a href="#tab_email_tickets" data-toggle="tab"><?php echo __('Email Tickets') ?></a>
  </li>
  <li>
    <a href="#tab_email_patterns" data-toggle="tab"><?php echo __('Email Patterns') ?></a>
  </li>
</ul>
      
               
        <div class="tab-content" >
          <div class="tab-pane fade active in" id="tab_general">
          
            <div class="form-group">
            	<label class="col-md-3 control-label"><span class="required">*</span>  <?php echo $form['name']->renderLabel() ?></label>
            	<div class="col-md-9">
            		<?php echo $form['name'] ?>
            	</div>
            </div>
            
            <div class="form-group">
            	<label class="col-md-3 control-label"><?php echo $form['users_id']->renderLabel() ?></label>
            	<div class="col-md-9">
            		<?php echo $form['users_id'] ?>
            	</div>
            </div>
            
            <div class="form-group">
            	<label class="col-md-3 control-label"><?php echo $form['sort_order']->renderLabel() ?></label>
            	<div class="col-md-9">
            		<?php echo $form['sort_order'] ?>
            	</div>
            </div>
            
            <div class="form-group">
            	<label class="col-md-3 control-label"><?php echo $form['active']->renderLabel() ?></label>
            	<div class="col-md-9">
            		<?php echo $form['active'] ?>
            	</div>
            </div>
                                  
          </div>
          
          <div class="tab-pane fade" id="tab_ticket_types">
            <?php echo __('Select the Ticket Types that will be available for this Department only') ?>
            
            <div class="form-group">
            	<label class="col-md-3 control-label"><?php echo $form['tickets_types']->renderLabel() ?></label>
            	<div class="col-md-9">
            		<?php echo $form['tickets_types'] ?>
            	</div>
            </div>

          </div>
          
          <div class="tab-pane fade" id="tab_public_ticket">
          
            <div class="form-group">
            	<label class="col-md-3 control-label"><?php echo $form['public_status']->renderLabel() ?></label>
            	<div class="col-md-9">
            		<?php echo $form['public_status'] ?>
            	</div>
            </div>
            
          </div>
          
          <div class="tab-pane fade" id="tab_email_tickets">
            <ul>
              <li><?php echo __('to get Tickets by email you have to setup cron, read more installation instruction'); ?></li>
              <li><?php echo __('IMAP functions should be enabled on your server'); ?></li>              
            </ul> 
            
            <div class="form-group">
            	<label class="col-md-3 control-label"><?php echo __('Get Tickets by email') ?></label>
            	<div class="col-md-9">
            		<p class="form-control-static"><?php echo $form['use_for_email_tickets'] ?></p>
            	</div>
            </div>
            
            <div class="form-group">
            	<label class="col-md-3 control-label"><?php echo $form['imap_server']->renderLabel() ?></label>
            	<div class="col-md-9">
            		<?php echo $form['imap_server'] ?>
                <span class="help-block"><?php echo __('For example'); ?>: mail.server.com:143<br>imap.gmail.com:993/imap/ssl<br> mail.server.com:143/notls</span>
            	</div>
            </div>
            
            <div class="form-group">
            	<label class="col-md-3 control-label"><?php echo $form['imap_mailbox']->renderLabel() ?></label>
            	<div class="col-md-9">
            		<?php echo $form['imap_mailbox'] ?>
            	</div>
            </div>
            
            <div class="form-group">
            	<label class="col-md-3 control-label"><?php echo $form['imap_login']->renderLabel() ?></label>
            	<div class="col-md-9">
            		<?php echo $form['imap_login'] ?>
            	</div>
            </div>
            
            <div class="form-group">
            	<label class="col-md-3 control-label"><?php echo $form['imap_pass']->renderLabel() ?></label>
            	<div class="col-md-9">
            		<?php echo $form['imap_pass'] ?>
            	</div>
            </div>
            
            <div class="form-group">
            	<label class="col-md-3 control-label"><?php echo $form['imap_delete_emails']->renderLabel() ?></label>
            	<div class="col-md-9">
            		<?php echo $form['imap_delete_emails'] ?>
                <span class="help-block"><?php echo __('Delete messages from the server'); ?></span>
            	</div>
            </div>
          
          </div>
          
          <div class="tab-pane fade" id="tab_email_patterns">
                                    
            <div><?php echo __('You can setup custom email patterns for Ticket emails.')?></div>
            <div><?php echo __('Patterns will be using for Public Tickets and Email Tickets.')?></div>
            <div><br><?php echo __('Use next keys:')?></div>
            <div>[ID] - <?php echo __('ticket id')?></div>
            <div>[DESCRIPTION] - <?php echo __('description of ticket or comment')?></div>
            <div>[USERNAME] - <?php echo __('name of ticket creator')?></div>
            <table style="margin-top: 5px; width: 100%">
            <tr>
              <th><b><?php echo __('A new ticket has been opened') ?></b> <a href="#" onClick="show_original_text('departments_new_ticket_message','Hello [USERNAME],<br><br>A new ticket has been opened up for you.<br><br>Your Ticket ID: [ID] Please reference this ticket # should you contact us.<br><br>Ticket Message:<br>================================================================<br>Detailed description of the issue<br>--------------------------------------------------------------------------------<br>[DESCRIPTION]'); "><?php echo __('Show Original')?></a></th>
            </tr>
            <tr> 
              <td>
                <?php echo $form['new_ticket_message']->renderError() ?>
                <?php echo $form['new_ticket_message'] ?> 
              </td>
            </tr>
            <tr>
              <th style="padding-top: 5px;"><b><?php echo ('Ticket has been updated') ?></b> <a href="#" onClick="show_original_text('departments_ticket_comment_message','Hello [USERNAME],<br><br>Your ticket [ID] has been updated:<br>================================================================<br>[DESCRIPTION]'); "><?php echo __('Show Original')?></a></th>
            </tr>
            <tr>
              <td>
                <?php echo $form['ticket_comment_message']->renderError() ?>
                <?php echo $form['ticket_comment_message'] ?>
              </td>
            </tr>
            </table>
          </div>
      
        </div>
        


    
  </div>
</div>

<?php include_partial('global/formValidatorExt',array('form_id'=>'departments')); ?>

<?php echo ajax_modal_template_footer() ?>  
  
</form>

