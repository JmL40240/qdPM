
<form class="form-horizontal"  id="ticketsComments" action="<?php echo url_for('ticketsComments/copy') ?>" method="post">
<div class="modal-body">
  <div class="form-body">
  
  <input type="hidden" name="sf_method" value="put" />
  
  <?php echo input_hidden_tag('projects_id',$sf_request->getParameter('projects_id')) ?>
  <?php echo input_hidden_tag('tickets_id',$sf_request->getParameter('tickets_id')) ?>
  <?php echo input_hidden_tag('id',$sf_request->getParameter('id')) ?>
  
  
<?php
  $choices = array();
  
  $choices[''] = '';
  
  $q = Doctrine_Core::getTable('Tickets')->createQuery('t')
        ->leftJoin('t.TicketsPriority tp')
        ->leftJoin('t.TicketsStatus ts')          
        ->leftJoin('t.TicketsTypes tt')
        ->leftJoin('t.TicketsGroups tg')                    
        ->leftJoin('t.Departments td')
        ->leftJoin('t.Projects p')
        ->leftJoin('t.Users')                    
        ->addWhere('t.in_trash is null')
        ->addWhere('p.in_trash is null')
        ->addWhere('ts.status_group!="closed"')
        ->addWhere('t.projects_id=?',(int)$sf_request->getParameter('projects_id'))
        ->addWhere('t.id!=?',$sf_request->getParameter('tickets_id'))
        ->orderBy('id desc');

  foreach($q->execute() as $ticket)
  {
    $choices[$ticket->getId()] = '#' . $ticket->getId() . ' - ' . $ticket->getName();
  }        

?>  
  
  <div class="form-group">
  	<label class="col-md-3 control-label"><?php echo __('Copy To') ?></label>
  	<div class="col-md-9">
  		<?php echo select_tag('copy_to','',array('choices'  => $choices),array('class'=>'form-control input-xlarge chosen-select','required'=>'required')) ?>
  	</div>
  </div>
  
<?php
  $choices = array();
  $choices['copy'] = __('Copy');
  $choices['move'] = __('Move');
?>
  
  <div class="form-group">
  	<label class="col-md-3 control-label"><?php echo __('Action') ?></label>
  	<div class="col-md-9">
  		<?php echo select_tag('comment_action','',array('choices'  => $choices),array('class'=>'form-control input-small')) ?>
  	</div>
  </div>
  
  </div>
</div>

<?php echo ajax_modal_template_footer() ?>     
</form>  