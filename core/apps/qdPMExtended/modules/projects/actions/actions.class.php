<?php

/**
 * projects actions.
 *
 * @package    sf_sandbox
 * @subpackage projects
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class projectsActions extends sfActions
{
  public function executeOpen(sfWebRequest $request)
  {
    if($ug = Doctrine_Core::getTable('UsersGroups')->find($this->getUser()->getAttribute('users_group_id')))
    {
      $role = Doctrine_Core::getTable('ProjectsRoles')->createQuery()->addWhere('users_id=?',$this->getUser()->getAttribute('id'))->addWhere('projects_id=?',$request->getParameter('projects_id'))->fetchOne();
      
      if($role)
      {
        $ug = Doctrine_Core::getTable('UsersGroups')->find($role->getUsersGroupsId());
      }
      
      switch(true)
      {
        case strlen($ug->getAllowManageTasks())>0:
            $this->redirect('tasks/index?projects_id=' . $request->getParameter('projects_id'));
          break;
        case strlen($ug->getAllowManageTickets())>0:
            $this->redirect('tickets/index?projects_id=' . $request->getParameter('projects_id'));
          break;
          
        case strlen($ug->getAllowManageDiscussions())>0:
            $this->redirect('discussions/index?projects_id=' . $request->getParameter('projects_id'));
          break;
        default:
            $this->redirect('projectsComments/index?projects_id=' . $request->getParameter('projects_id'));
          break;
      }
    }
    else
    {
      $this->redirect('projectsComments/index?projects_id=' . $request->getParameter('projects_id'));
    }
  }
  
  
  protected function checkProjectsAccess($access,$projects=false)
  {
    if($projects)
    {
      Users::checkAccess($this,$access,'projects',$this->getUser(),$projects->getId());
      Projects::checkViewOwnAccess($this,$this->getUser(),$projects);
    }
    else
    {
      Users::checkAccess($this,$access,'projects',$this->getUser());
    }
  }
  
  public function executeIndex(sfWebRequest $request)
  {          
    $this->checkProjectsAccess('view');
              
    if(!$this->getUser()->hasAttribute('projects_filter'))
    {
      $this->getUser()->setAttribute('projects_filter', Projects::getDefaultFilter($this->getUser()));
    }
                     
    $this->filter_by = $this->getUser()->getAttribute('projects_filter');
        
    if($fb = $request->getParameter('filter_by'))
    {
      $this->filter_by[key($fb)]=current($fb);
      $this->getUser()->setAttribute('projects_filter', $this->filter_by);
      
      $this->redirect('projects/index');
    }
    
    if($request->hasParameter('remove_filter'))
    {
      unset($this->filter_by[$request->getParameter('remove_filter')]);    
      $this->getUser()->setAttribute('projects_filter', $this->filter_by);
      
      $this->redirect('projects/index');
    }
     
    if($request->hasParameter('user_filter'))
    {
      $this->filter_by = Projects::useProjectsFilter($request->getParameter('user_filter'),$this->getUser());
      $this->getUser()->setAttribute('projects_filter', $this->filter_by);
      
      $this->redirect('projects/index');
    }
        
    if($request->hasParameter('delete_user_filter'))
    {
      app::deleteUserFilter($request->getParameter('delete_user_filter'),'ProjectsReports',$this->getUser());
    
      $this->getUser()->setFlash('userNotices', t::__('Filter Deleted'));
      
      $this->redirect('projects/index');
    }
    
    if($request->hasParameter('edit_user_filter'))
    {
      $this->setTemplate('editFilter','app');
    }
    
    if($request->hasParameter('sort_filters'))
    {
      $this->setTemplate('sortFilters','app');
    }
    
    if($set_order = $request->getParameter('set_order'))
    {
      app::setListingOrder('projects',$set_order,$this->getUser()->getAttribute('id'));
      
      $this->redirect('projects/index');
    }
    
    app::setPageTitle('Projects',$this->getResponse());   
  }
      
  public function executeInfo(sfWebRequest $request)
  {            
    $this->forward404Unless($this->projects = Doctrine_Core::getTable('Projects')->createQuery()->addWhere('id=?',$request->getParameter('id'))->addWhere('in_trash is null')->fetchOne(), sprintf('Object projects does not exist (%s).', $request->getParameter('id')));
    $this->checkProjectsAccess('view',$this->projects);        
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->checkProjectsAccess('insert');    
    
    $this->form = new ProjectsForm(null, array('sf_user'=>$this->getUser()));
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->checkProjectsAccess('insert');
    
    $this->forward404Unless($request->isMethod(sfRequest::POST));
        
    $this->form = new ProjectsForm(null, array('sf_user'=>$this->getUser()));

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {        
    $this->forward404Unless($projects = Doctrine_Core::getTable('Projects')->createQuery()->addWhere('id=?',$request->getParameter('id'))->addWhere('in_trash is null')->fetchOne(), sprintf('Object projects does not exist (%s).', $request->getParameter('id')));
    $this->checkProjectsAccess('edit',$projects);
        
    $this->form = new ProjectsForm($projects, array('sf_user'=>$this->getUser()));
  }

  public function executeUpdate(sfWebRequest $request)
  {        
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($projects = Doctrine_Core::getTable('Projects')->createQuery()->addWhere('id=?',$request->getParameter('id'))->addWhere('in_trash is null')->fetchOne(), sprintf('Object projects does not exist (%s).', $request->getParameter('id')));
    $this->checkProjectsAccess('edit',$projects);
    
    $this->form = new ProjectsForm($projects, array('sf_user'=>$this->getUser()));

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {        
    $request->checkCSRFProtection();

    $this->forward404Unless($projects = Doctrine_Core::getTable('Projects')->find(array($request->getParameter('id'))), sprintf('Object projects does not exist (%s).', $request->getParameter('id')));
    $this->checkProjectsAccess('delete',$projects);
          
    $this->moveProjectInTrash($projects);

    $this->redirect('projects/index');
  }
  
  protected function moveProjectInTrash($project)
  {
    $project->setInTrash(1);
    $project->setInTrashDate(time());
    $project->save();
  }
  
  protected function getSendTo($form)
  {
    $send_to = array();    
    
    if($form->getObject()->isNew())
    {
      $send_to['new'] = $form['team']->getValue();;
    }
    else              
    { 
      if(is_array($form['team']->getValue())) 
      if(count($new_users = array_diff($form['team']->getValue(),explode(',',$form->getObject()->getTeam())))>0)
      {
        $send_to['new_assigned'] = $new_users;
      }
    
      if($form->getObject()->getProjectsStatusId()!=$form['projects_status_id']->getValue())
      {
        if(isset($send_to['new_assigned']))
        {
          $send_to['status'] = array_diff(explode(',',$form->getObject()->getTeam()),$new_users);
        }
        else
        {
          $send_to['status'] = $form['team']->getValue();
        }  
      }
    }
    
    return $send_to;  
  
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {    
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {    
                
      $team = $form['team']->getValue();
      
      if(!is_array($team)) $team = array();
      
      if(is_array($form['departments']->getValue()))
      {
        
        foreach($form['departments']->getValue() as $v)
        {          
          if($d = Doctrine_Core::getTable('Departments')->find($v))
          {            
            if($d->getUsersId()>0)
            {                        
              $team = array_merge($team,array($d->getUsersId()));              
            }
          }
        }
      }
                                  
      $team = array_unique($team);
                          
      $form->setFieldValue('team',$team);
      $form->setFieldValue('departments',$form['departments']->getValue());
      
              
      $send_to = $this->getSendTo($form);
      
      if($form->getObject()->isNew()){ $previeous_status = false; }else{ $previeous_status = $form->getObject()->getProjectsStatusId(); }
      
      if($form->getObject()->isNew()){ $form->setFieldValue('created_at',date('Y-m-d H:i:s')); }
      
      $form->protectFieldsValue();
      
      $projects = $form->save();
            
      //reset project roles
      Doctrine_Query::create()->delete('ProjectsRoles')->where('projects_id=?', $projects->getId())->execute();
                      
      if($request->hasParameter('project_roles'))
        ProjectsRoles::setRoles($request->getParameter('project_roles'),$projects->getId());
      
      ExtraFieldsList::setValues($request->getParameter('extra_fields'),$projects->getId(),'projects',$this->getUser(),$request);
      
      Attachments::insertAttachments($request->getFiles(),'projects',$projects->getId(),$request->getParameter('attachments_info'),$this->getUser());
      
      $projects = $this->addCommentIfStatusChanged($previeous_status,$projects);
      
      $projects = $this->checkIfAssignedToChanged($send_to,$projects);
      
      Projects::sendNotification($this,$projects,$send_to,$this->getUser());
      
      
      $this->redirect_to($request->getParameter('redirect_to'),$projects->getId());      
    }
  }
  
  protected function checkIfAssignedToChanged($send_to,$projects)
  {
     
    if(isset($send_to['new_assigned']))
    {              
      $c = new ProjectsComments;
      $c->setDescription(t::__('Assigned To') . ': ' .  Users::getNameById(implode(',',$send_to['new_assigned']),', '));
      $c->setProjectsId($projects->getId());
      $c->setCreatedAt(date('Y-m-d H:i:s'));
      $c->setCreatedBy($this->getUser()->getAttribute('id'));
      $c->save();
      
      $projects->setLastCommentDate(time());
      $projects->save();
    }
    
    return $projects;    
  
  }
  
  protected function addCommentIfStatusChanged($previeous_status,$projects)
  {    
    if($previeous_status!=$projects->getProjectsStatusId() and $previeous_status>0)
    {
      $c = new ProjectsComments;
      $c->setProjectsStatusId($projects->getProjectsStatusId());
      $c->setProjectsId($projects->getId());
      $c->setCreatedAt(date('Y-m-d H:i:s'));
      $c->setCreatedBy($this->getUser()->getAttribute('id'));
      $c->save();
      
      $projects->setLastCommentDate(time());
      $projects->save();
    }
     
    return $projects;    
  }
  
  protected function redirect_to($redirect_to,$projects_id=false)
  {
    switch(true)
    {
      case $redirect_to=='dashboard': $this->redirect('dashboard/index');
        break; 
      case $redirect_to=='projectsComments': $this->redirect('projectsComments/index?projects_id=' . $projects_id);
        break;
      case strstr($redirect_to,'projectsReports'): $this->redirect('projectsReports/view?id=' . str_replace('projectsReports','',$redirect_to));
        break;
      default:
        if($projects_id>0)
        { 
          $this->redirect('projectsComments/index?projects_id=' . $projects_id);
        }
        else
        {
          $this->redirect('projects/index');
        }        
        break;  
    }
  }
  
  
  public function executeSaveFilter(sfWebRequest $request)
  {
    $this->setTemplate('saveFilter','app');
  }
  
  public function executeDoSaveFilter(sfWebRequest $request)
  {
    Projects::saveProjectsFilter($request,$this->getUser()->getAttribute('projects_filter'),$this->getUser());
    
    $this->getUser()->setFlash('userNotices', t::__('Filter Saved'));
    $this->redirect('projects/index');
  }
  
  public function executeExport(sfWebRequest $request)
  {
    /*check access*/
    Users::checkAccess($this,'view',$this->getModuleName(),$this->getUser());
  
    $this->columns = array('id'=>t::__('Id'),
                           'ProjectsPriority'=>t::__('Priority'),
                           'ProjectsStatus'=>t::__('Status'),                                                      
                           'name'=>t::__('Name'),
                           'description'=>t::__('Description'),
                           'team'=>t::__('Team'),
                           'ProjectsTypes'=>t::__('Type'),
                           'ProjectsGroups'=>t::__('Group'),                           
                           'Users'=>t::__('Created By'),
                           'created_at'=>t::__('Created At'),
                           );
                           
    $extra_fields = ExtraFieldsList::getFieldsByType('projects',$this->getUser(),false,array('all'=>true));
    
    foreach($extra_fields as $v)
    {
      $this->columns['extra_field_' . $v['id']]=$v['name'];
    }                           
    
    $this->columns['url']=t::__('Url');
    
    if($fields = $request->getParameter('fields'))
    {
      $separator = "\t";
      $format = $request->getParameter('format','.csv');
      $filename = $request->getParameter('filename','projects');
			
			header("Content-type: Application/octet-stream");      
			header("Content-disposition: attachment; filename=" . $filename . "." . $format);
			header("Pragma: no-cache");
			header("Expires: 0");
    
      $content = '';
      foreach($fields as $f)
      {
        $content .= str_replace(array("\n\r","\r","\n",$separator),' ',$this->columns[$f]) . $separator;
      }
      $content .= "\n";
      
      if($format=='csv')
      {
        echo chr( 0xFF ) . chr( 0xFE ) . mb_convert_encoding( $content, 'UTF-16LE', 'UTF-8' );
      }
      else
      {
        echo $content;
      }
    
      if(strlen($request->getParameter('selected_items')==0)) exit();
      
       $q= Doctrine_Core::getTable('Projects')->createQuery('p')
          ->leftJoin('p.ProjectsPriority pp')
          ->leftJoin('p.ProjectsStatus ps')
          ->leftJoin('p.ProjectsTypes pt')
          ->leftJoin('p.ProjectsGroups pg')
          ->leftJoin('p.Users')
          ->addWhere('p.in_trash is null')
          ->whereIn('p.id',explode(',',$request->getParameter('selected_items')));
          
      if(Users::hasAccess('view_own','projects',$this->getUser()))
      {       
        $q->addWhere("find_in_set('" . $this->getUser()->getAttribute('id') . "',p.team) or p.created_by='" . $this->getUser()->getAttribute('id') . "'");
      }
      
      $q = app::addListingOrder($q,'projects',$this->getUser()->getAttribute('id'));    
          
      $projects = $q->fetchArray();
      
      $totals = array();
          
      foreach($projects as $p)
      {
        $ex_values = ExtraFieldsList::getValuesList($extra_fields,$p['id']);
        
        $content = '';
        
        foreach($fields as $f)
        {
          $v = '';
          
          if(in_array($f,array('id','name','description')))
          {            
            $v=$p[$f];
          }
          elseif(strstr($f,'extra_field_'))
          {
            if($ex = Doctrine_Core::getTable('ExtraFields')->find(str_replace('extra_field_','',$f)))
            {
              $v = ExtraFieldsList::renderFieldValueByType($ex,$ex_values,array(),true);
              
              if(in_array($ex->getType(),array('number','formula')))
              {
                if(!isset($totals[$ex->getId()])) $totals[$ex->getId()] = 0;
                                
                $totals[$ex->getId()]+= $v;                
              }
              
              $v = str_replace('<br>',', ',$v);
            }
          }
          elseif($f=='team')
          {  
            $v = Users::getNameById($p[$f],', ');
          }
          elseif($f=='created_at')
          {            
            if(strlen($p[$f])>0)
            {
              $v = date(app::getDateTimeFormat(),app::getDateTimestamp($p[$f]));
            }            
          }
          elseif($f=='url')
          {
            $v = app::public_url('projectsComments/index?projects_id=' . $p['id']);
          }
          else
          {            
            $v=app::getArrayName($p,$f);
          }
          
          $content .= str_replace(array("\n\r","\r","\n",$separator),' ',strip_tags($v)) . $separator;
        }
        
        $content .= "\n";
      
        if($format=='csv')
        {
          echo chr( 0xFF ) . chr( 0xFE ) . mb_convert_encoding( $content, 'UTF-16LE', 'UTF-8' );
        }
        else
        {
          echo $content;
        }        
      }
      
      $content = '';
      
      foreach($fields as $f)
      {
        $v = '';          
        
        if(strstr($f,'extra_field_'))
        {          
          if(isset($totals[str_replace('extra_field_','',$f)])) $v = $totals[str_replace('extra_field_','',$f)];          
        }
                
        $content .= str_replace(array("\n\r","\r","\n",$separator),' ',$v) . $separator;
      }
      
      $content .= "\n";
      
      if($format=='csv')
      {
        echo chr( 0xFF ) . chr( 0xFE ) . mb_convert_encoding( $content, 'UTF-16LE', 'UTF-8' );
      }
      else
      {
        echo $content;
      } 
            
      exit(); 
    }
  }
  
  public function executeMultipleEdit(sfWebRequest $request)
  {
  
    Users::checkAccess($this,'edit',$this->getModuleName(),$this->getUser());
    
    $this->fields = array();
    
    $choices = app::getItemsChoicesByTable('ProjectsPriority',true); 
    if(count($choices)>1) $this->fields['projects_priority_id'] = array('title'=>t::__('Priority'),'choices'=>$choices);
    
    $choices = app::getItemsChoicesByTable('ProjectsStatus',true); 
    if(count($choices)>1) $this->fields['projects_status_id'] = array('title'=>t::__('Status'),'choices'=>$choices);
    
    $choices = app::getItemsChoicesByTable('ProjectsTypes',true); 
    if(count($choices)>1) $this->fields['projects_types_id'] = array('title'=>t::__('Type'),'choices'=>$choices);
    
    $choices = app::getItemsChoicesByTable('ProjectsGroups',true,array(),$this->getUser()); 
    if(count($choices)>1) $this->fields['projects_groups_id'] = array('title'=>t::__('Group'),'choices'=>$choices);
    
    $extra_fields = ExtraFieldsList::getFieldsByType('projects',$this->getUser(),false,array('all'=>true));
    
    foreach($extra_fields as $v)
    {
      if(in_array($v['type'],array('pull_down','checkbox','radiobox')) and !in_array($this->getUser()->getAttribute('users_group_id'), explode(',',$v['view_only_access'])))
      {
        $choices = array();
        
        foreach(explode("\n",$v['default_values']) as $df)
        {
          $choices[trim($df)]= trim($df);
        }
        
        if(count($choices)==0) continue;
      
        if($v['type']=='checkbox')
        {
          $this->fields['extra_field_' . $v['id']] = array('title'=>$v['name'],'choices'=>$choices,'multiple'=>true, 'expanded'=>true);
        }
        else
        {
          $this->fields['extra_field_' . $v['id']] = array('title'=>$v['name'],'choices'=>array_merge(array(''=>''),$choices));
        }
      }
    }
    
    if($request->getParameter('fields'))
    {
      if(strlen($request->getParameter('selected_items')==0)) exit();
      
      foreach($request->getParameter('fields') as $key=>$value)
      {
        if(strlen($value)==0 and !is_array($value)) continue;
        
        if(strstr($key,'extra_field_'))
        {
          foreach(explode(',',$request->getParameter('selected_items')) as $pid)
          {
            $f = Doctrine_Core::getTable('ExtraFieldsList')
            ->createQuery()
            ->addWhere('bind_id=?',$pid)
            ->addWhere('extra_fields_id=?',str_replace('extra_field_','',$key))
            ->fetchOne();
            
            if(is_array($value)) $value = implode("\n",$value);
            
            if($f)
            {
              $f->setValue($value);
              $f->save();
            }
            else
            {
              $f = new ExtraFieldsList;
              $f->setBindId($pid);
              $f->setExtraFieldsId(str_replace('extra_field_','',$key));
              $f->setValue($value);
              $f->save();
            }
          }                            
        }
        else
        {
          if($key=='projects_status_id')
          {
            foreach(explode(',',$request->getParameter('selected_items')) as $pid)
            {
              if($p = Doctrine_Core::getTable('Projects')->find($pid))
              {
                if($p->getProjectsStatusId()!=$value)
                {
                  $p->setProjectsStatusId($value);
                                                    
                  $p->setLastCommentDate(time());
                  $p->save();
                                                                        
                  $c = new ProjectsComments;
                  $c->setProjectsStatusId($value);
                  $c->setProjectsId($pid);
                  $c->setCreatedAt(date('Y-m-d H:i:s'));
                  $c->setCreatedBy($this->getUser()->getAttribute('id'));
                  $c->save();
                  
                  if(strlen($p->getTeam())>0)
                  {
                    Projects::sendNotification($this, $p,array('status'=>explode(',',$p->getTeam())),$this->getUser());
                  }
                  
                }
              }
            }
          }
          else
          {                
            Doctrine_Query::create()
              ->update('Projects')
              ->set($key,$value)                  
              ->whereIn('id', explode(',',$request->getParameter('selected_items')))
              ->execute();
          }
        }
      }
      
      $this->redirect_to($request->getParameter('redirect_to'));
    }        
  }
}
