<?php
   $in_team = array(0);
   
   $pchoices = array();
   $pchoices[''] = '';
   $q = Doctrine_Core::getTable('Projects')->createQuery('p')
          ->leftJoin('p.ProjectsPriority pp')
          ->leftJoin('p.ProjectsStatus ps')
          ->leftJoin('p.ProjectsTypes pt')
          ->leftJoin('p.ProjectsGroups pg')
          ->leftJoin('p.Users')
          ->addWhere('in_trash is null');
          
    if(Users::hasAccess('view_own','projects',$sf_user))
    {       
      $q->addWhere("find_in_set('" . $sf_user->getAttribute('id') . "',p.team) or p.created_by='" . $sf_user->getAttribute('id') . "'");
    }
    
    if($filters['users_id']>0)
    {
      $q->addWhere("find_in_set('" . $filters['users_id'] . "',p.team) or p.created_by='" . $filters['users_id'] . "'");  
    }
    
    if($filters['projects_id']>0)
    {
      $q->addWhere('p.id=?',$filters['projects_id']);
    }
    
    foreach($q->orderBy('p.name')->execute() as $p)
    {
      $pchoices[$p->getId()] = $p->getName();
      $in_team = array_merge($in_team,explode(',',$p->getTeam()));
    }
    
    $in_team = array_unique($in_team);
    
    
    $uchoices = array();
    $uchoices[''] = '';
    
    $q = Doctrine_Core::getTable('Users')->createQuery('u')->leftJoin('u.UsersGroups ug')
        ->addWhere('u.active=1')
        ->orderBy('ug.name, u.name');   
        
    if(Users::hasAccess('view_own','projects',$sf_user) or $filters['projects_id']>0)
    {      
      $q->whereIn('u.id',$in_team);      
    }    
                             
    foreach($q->execute() as $v)
    {
      $uchoices[$v->getUsersGroups()->getName()][$v->getId()]=$v->getName();
    }
        
?>



<form action="<?php echo url_for('usersActivity/' . $sf_context->getActionName()) ?>" method="post">
<input type="hidden" name="sf_method" value="put" />
<?php echo ($sf_request->hasParameter('projects_id')? input_hidden_tag('projects_id',$sf_request->getParameter('projects_id')):'') ?>
<table>
  <tr>
    <?php if($sf_context->getActionName()!='personal'):?>
    <td><?php echo __('User') ?>:&nbsp;</td>
    <td><?php echo select_tag('filters[users_id]',$filters['users_id'],array('choices'=>$uchoices),array('class'=>'form-control'))?></td>
    <?php endif ?>
</tr>
</table>

<table  style="margin-top:5px;">
<tr>    
    <?php if(!$sf_request->hasParameter('projects_id')): ?>
    
    <td><?php echo __('Project') ?>:&nbsp;</td>
    <td><?php echo select_tag('filters[projects_id]',$filters['projects_id'],array('choices'=>$pchoices),array('class'=>'form-control'))?></td>
    <?php endif ?>
  </tr>
</table>

<table style="margin-top:5px;">
  <tr>    
    <td><?php echo __('From') ?>:</td>
    <td>
      <div class="input-group input-medium date datepicker"><?php echo input_tag('filters[from]',$filters['from'],array('class'=>'form-control datepicker')) ?><span class="input-group-btn"><button class="btn btn-default date-set" type="button"><i class="fa fa-calendar"></i></button></span></div>
    </td>
</tr>
<tr>    
    <td><?php echo __('To') ?>:&nbsp;</td>
    <td>
      <div class="input-group input-medium date datepicker"><?php echo input_tag('filters[to]',$filters['to'],array('class'=>'form-control datepicker')) ?><span class="input-group-btn"><button class="btn btn-default date-set" type="button"><i class="fa fa-calendar"></i></button></span></div>
    </td>
</tr>
</table>

<table  style="margin-top:5px;">
<tr>    
    <td><?php echo __('Days before today') ?>:</td>
    <td style="padding-left: 10px;"><?php echo select_tag('filters[days]',$filters['days'],array('choices'=>array('',1,2,3,4,5,6,7,8,10,14,15,28,30,31)),array('onChange'=>'clear_filters_dates_fields()'),array('class'=>'form-control')) ?></td>
    
    
    <td style="padding-left: 10px;"><?php echo submit_tag(__('Update')) ?></td>
  </tr>
</table>
</form>

<script type="text/javascript">    
  $(function() {

         
  });
  
  function clear_filters_dates_fields()
  {
    $('#filters_from').val('');
    $('#filters_to').val('');
  }
</script>   

<br>
<table>
<?php  
  if(count($atcivity_list)==0) echo '<tr><td>' . __('No Records Found') . '</td></tr>';
    
  $today = '';
  foreach($atcivity_list as $time=>$v)
  {
    if($today!=app::i18n_date(app::getDateFormat(),$time))
    {
      $today=app::i18n_date(app::getDateFormat(),$time); 
      
      echo '
        <tr>
          <td colspan="2" ><b>' . $today . '</b></td>
        </tr>
      ';
    }
    
    $subject = '';
    
    switch($v['table'])
    {
      case 'Projects':
            $item = Doctrine_Core::getTable($v['table'])->createQuery('p')->leftJoin('p.Users u')->addWhere('p.id=?',$v['id'])->fetchOne();
            $subject = __('Project') . ': <u>' . link_to($item->getName(),'projectsComments/index?projects_id=' . $item->getId()) . '</u> ' . __('created by')  . ' <u>'. app::getObjectName($item->getUsers()) . '</u><br>';
        break;
      case 'ProjectsComments':
            $item = Doctrine_Core::getTable($v['table'])->createQuery('pc')->leftJoin('pc.Users u')->leftJoin('pc.Projects p')->addWhere('pc.id=?',$v['id'])->fetchOne();
            $subject = __('Comment for project') . ': <u>' . link_to($item->getProjects()->getName(),'projectsComments/index?projects_id=' . $item->getProjectsId()) . '</u> ' . __('created by')  . ' <u>'. app::getObjectName($item->getUsers()) . '</u><br>';
            if($item->getProjectsStatusId()>0) $subject .= '<small style="color: gray;">' . __('Status') . ': <u>' . $item->getProjectsStatus()->getName() . '</u></small>&nbsp;&nbsp;';  
        break;
      case 'Tasks':
            $item = Doctrine_Core::getTable($v['table'])->createQuery('t')->leftJoin('t.Users u')->addWhere('t.id=?',$v['id'])->fetchOne();
            $subject = __('Task') . ': <u>' . link_to($item->getName(),'tasksComments/index?projects_id=' . $item->getProjectsId() . '&tasks_id=' . $item->getId()) . '</u> ' . __('created by')  . ' <u>'. app::getObjectName($item->getUsers()) . '</u><br>';
        break;
      case 'TasksComments':
            $item = Doctrine_Core::getTable($v['table'])->createQuery('tc')->leftJoin('tc.Users u')->leftJoin('tc.Tasks t')->addWhere('tc.id=?',$v['id'])->fetchOne();
            $subject = __('Comment for tasks') . ': <u>' . link_to($item->getTasks()->getName(),'tasksComments/index?projects_id=' . $item->getTasks()->getProjectsId() . '&tasks_id=' . $item->getTasksId()) . '</u> ' . __('created by')  . ' <u>'. app::getObjectName($item->getUsers()) . '</u><br>';
            if($item->getTasksStatusId()>0) $subject .= '<small style="color: gray;">' . __('Status') . ': <u>' . $item->getTasksStatus()->getName() . '</u></small>&nbsp;&nbsp;';
        break; 
      case 'Tickets':
            $item = Doctrine_Core::getTable($v['table'])->createQuery('t')->leftJoin('t.Users u')->addWhere('t.id=?',$v['id'])->fetchOne();
            $subject = __('Ticket') . ': <u>' . link_to($item->getName(),'ticketsComments/index?projects_id=' . $item->getProjectsId() . '&tickets_id=' . $item->getId()) . '</u> ' . __('created by')  . ' <u>'. app::getObjectName($item->getUsers()) . '</u><br>';
        break;
      case 'TicketsComments':
            $item = Doctrine_Core::getTable($v['table'])->createQuery('tc')->leftJoin('tc.Users u')->leftJoin('tc.Tickets t')->addWhere('tc.id=?',$v['id'])->fetchOne();
            $subject = __('Comment for ticket') . ': <u>' . link_to($item->getTickets()->getName(),'ticketsComments/index?projects_id=' . $item->getTickets()->getProjectsId() . '&tickets_id=' . $item->getTicketsId()) . '</u> ' . __('created by')  . ' <u>'. app::getObjectName($item->getUsers()) . '</u><br>';
            if($item->getTicketsStatusId()>0) $subject .= '<small style="color: gray;">' . __('Status') . ': <u>' . $item->getTicketsStatus()->getName() . '</u></small>&nbsp;&nbsp;';
        break;
      case 'Discussions':
            $item = Doctrine_Core::getTable($v['table'])->createQuery('t')->leftJoin('t.Users u')->addWhere('t.id=?',$v['id'])->fetchOne();
            $subject = __('Discussion') . ': <u>' . link_to($item->getName(),'discussionsComments/index?projects_id=' . $item->getProjectsId() . '&discussions_id=' . $item->getId()) . '</u> ' . __('created by')  . ' <u>'. app::getObjectName($item->getUsers()) . '</u><br>';
        break;
      case 'DiscussionsComments':
            $item = Doctrine_Core::getTable($v['table'])->createQuery('tc')->leftJoin('tc.Users u')->leftJoin('tc.Discussions t')->addWhere('tc.id=?',$v['id'])->fetchOne();
            $subject = __('Comment for discussion') . ': <u>' . link_to($item->getDiscussions()->getName(),'discussionsComments/index?projects_id=' . $item->getDiscussions()->getProjectsId() . '&discussions_id=' . $item->getDiscussionsId()) . '</u> ' . __('created by')  . ' <u>'. app::getObjectName($item->getUsers()) . '</u><br>';
            if($item->getDiscussionsStatusId()>0) $subject .= '<small style="color: gray;">' . __('Status') . ': <u>' . $item->getDiscussionsStatus()->getName() . '</u></small>&nbsp;&nbsp;';
        break;
    }
    
    $subject .= '<small style="color: gray;">' . truncate_text(strip_tags($item->getDescription()),150) . '</small>';
    
    echo '
      <tr>
        <td valign="top" style="color: gray; padding-left: 25px; padding-right: 10px;">' . date('H:i',$time) . '</td>
        <td style="padding-bottom: 7px;">' . $subject . '</td>
      </tr>
    ';
  }
?>
</table>