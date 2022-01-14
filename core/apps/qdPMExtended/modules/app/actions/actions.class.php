<?php

/**
 * app actions.
 *
 * @package    sf_sandbox
 * @subpackage app
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class appActions extends sfActions
{ 
  public function executeSetCollapsedTasks(sfWebRequest $request)
  {
    $o = Doctrine_Core::getTable('UsersListingsOrder')
          ->createQuery()
          ->addWhere('module=?','tasks')          
          ->addWhere('users_id=?',$this->getUser()->getAttribute('id'))          
          ->addWhere('projects_id=?',$request->getParameter('projects_id'))
          ->fetchOne();
          
    if($o)
    {
      $collapsed_tasks = explode(',',$o->getCollapsedTasks());
      
      if($request->getParameter('status')=='collapsed')
      {
        $collapsed_tasks = array_unique(array_merge($collapsed_tasks,array($request->getParameter('tasks_id'))));
      }
      else
      {
        unset($collapsed_tasks[array_search($request->getParameter('tasks_id'),$collapsed_tasks)]);
      }
      
      $o->setCollapsedTasks(implode(',',$collapsed_tasks));
      $o->save(); 
    }
    else
    {
      $o = new UsersListingsOrder;
      $o->setModule('tasks'); 
      $o->setOrderType('');
      $o->setUsersId($this->getUser()->getAttribute('id'));
      $o->setProjectsId($request->getParameter('projects_id'));
      $o->setCollapsedTasks($request->getParameter('tasks_id'));    
      $o->save(); 
    }
  
    exit();
  }
  
  public function executeCopyAttachments(sfWebRequest $request)
  {
    if(count($attachments_ids = explode(',',$request->getParameter('attachments')))>0)
    {
      
      $attachments = Doctrine_Core::getTable('Attachments')
                    ->createQuery()
                    ->whereIn('id',$attachments_ids)
                    ->execute();
      foreach($attachments as $a)
      {                                                             
        
        
        if(Doctrine_Core::getTable('Attachments')->createQuery()->addWhere('SUBSTRING(file,8)=?',substr($a->getFile(),7))->addWhere('bind_type=?', $request->getParameter('to'))->addWhere('users_id=?',$this->getUser()->getAttribute('id'))->addWhere('bind_id=0')->count()==0)        
        {
                    
          $new_filename = rand(111111,999999)  . '-' . substr($a->getFile(),7);            
          copy(sfConfig::get('sf_upload_dir') . '/attachments/'  . $a->getFile(),sfConfig::get('sf_upload_dir') . '/attachments/'  . $new_filename);
                          
          $aa = new Attachments();
          $aa->setFile($new_filename);
          $aa->setInfo($a->getInfo());
          $aa->setUsersId($this->getUser()->getAttribute('id'));
          $aa->setBindType($request->getParameter('to'));            
          $aa->setBindId(0);
          $aa->setDateAdded(time());
          $aa->save();
          
          
        }
      }
    }
    
    exit();
  } 
   
  public function executeRemoveRelatedTicketWithTask(sfWebRequest $request)
  {
    $r = Doctrine_Core::getTable('TasksToTickets')->createQuery()
          ->addWhere('tasks_id=?',$request->getParameter('tasks_id'))
          ->addWhere('tickets_id=?',$request->getParameter('tickets_id'))
          ->fetchOne();
    if($r)
    {
      $r->delete();
    }
    
    exit();    
  }
  
  public function executeRemoveRelatedTicketWithDiscussions(sfWebRequest $request)
  {
    $r = Doctrine_Core::getTable('TicketsToDiscussions')->createQuery()
          ->addWhere('tickets_id=?',$request->getParameter('tickets_id'))
          ->addWhere('discussions_id=?',$request->getParameter('discussions_id'))
          ->fetchOne();
    if($r)
    {
      $r->delete();
    }
    
    exit();    
  }
  
  public function executeRemoveRelatedTaskWithDiscussions(sfWebRequest $request)
  {
    $r = Doctrine_Core::getTable('TasksToDiscussions')->createQuery()
          ->addWhere('tasks_id=?',$request->getParameter('tasks_id'))
          ->addWhere('discussions_id=?',$request->getParameter('discussions_id'))
          ->fetchOne();
    if($r)
    {
      $r->delete();
    }
    
    exit();    
  }
  
   
  public function executeMultipleDelete(sfWebRequest $request) 
  {
  
  }
  
  public function executeDoMultipleDelete(sfWebRequest $request) 
  {
    $access = Users::getAccessSchema($request->getParameter('table'),$this->getUser());
    
    if(!$access['delete'])
    {
      $this->redirect('accessForbidden/index');
    }
  
    if($selected_items = $request->getParameter('selected_items'))
    {
      if(strlen($selected_items)>0)
      {            
        Doctrine_Query::create()
          ->update($request->getParameter('table'))
          ->set('in_trash',1)
          ->set('in_trash_date',time())      
          ->whereIn('id', explode(',',$selected_items))
          ->execute();
          
        if($request->getParameter('table')=='tasks')
        {
          foreach(explode(',',$selected_items) as $v)
          {
            if($tasks = Doctrine_Core::getTable('Tasks')->find($v))
            {
              if(count($tasks_tree = TasksTree::getTasksTree($this->getUser(),$tasks->getProjectsId(),$tasks->getId()))>0)
              {
                foreach($tasks_tree as $v)
                {
                  if($t = Doctrine_Core::getTable('Tasks')->find($v['id']))
                  {
                    $t->setParentId($tasks->getParentId());
                    $t->save();
                  }
                }
              }
            }
          }
        }
      }
    }
    
    $this->redirect($request->getParameter('table').'/index' . (($projects_id = $request->getParameter('projects_id'))>0 ? '?projects_id=' . $projects_id:''));
  }
   
  public function executeSortItems(sfWebRequest $request)
  {
    $t = $request->getParameter('t');
    
    
    switch($t)
    {
     case 'extraFields':
          $this->itmes = Doctrine_Core::getTable($t)
            ->createQuery('a')
            ->addWhere('bind_type=?',$request->getParameter('bind_type'))
            ->addWhere(($request->hasParameter('tab') ? 'extra_fields_tabs_id=' . $request->getParameter('tab') : 'extra_fields_tabs_id is null'))
            ->orderBy('sort_order, name')
            ->execute();                        
        break;
      case 'extraFieldsTabs':
          $this->itmes = Doctrine_Core::getTable($t)
            ->createQuery('a')
            ->addWhere('bind_type=?',$request->getParameter('bind_type'))            
            ->orderBy('sort_order, name')
            ->execute();                        
        break;  
      case 'projectsStatus':
      case 'tasksStatus':
      case 'ticketsStatus':
      case 'discussionsStatus':
          $this->itmes = Doctrine_Core::getTable($t)
            ->createQuery('a')
            ->orderBy('status_group desc, sort_order, name')
            ->execute();
            
            $this->setTemplate('sortGroupedItems');
        break;
      default:
          $this->itmes = Doctrine_Core::getTable($t)
            ->createQuery('a')
            ->orderBy('sort_order, name')
            ->execute();
        break;
    }        
  }
  
  public function executeSortItemsProcess(sfWebRequest $request)
  {
    $t = $request->getParameter('t');
        
    $list = $request->getParameter('list');
    $list = json_decode($list);
                
    $sort_order = 0;
    foreach($list as $ojb)
    {
      Doctrine_Query::create()
      ->update($t)
      ->set('sort_order', $sort_order)
      ->where('id = ?', $ojb->id)
      ->execute();

      $sort_order++;
    }


    exit();
  }
  
  public function executeSortGroupedItemsProcess(sfWebRequest $request)
  {
    $t = $request->getParameter('t');    
    
    foreach(app::getStatusGroupsChoices() as $k=>$name)
    {
      $list = $request->getParameter('sorted_items_' . $k);
      $list = json_decode($list);
      
      $sort_order = 0;
      foreach($list as $ojb)
      {
      
        if($t=='projectsStatus') $t='projects_status';
        if($t=='tasksStatus') $t='tasks_status';
        if($t=='ticketsStatus') $t='tickets_status';
        if($t=='discussionsStatus') $t='discussions_status';
                
        $sql = "update " . $t . " ts set ts.status_group='" . $k . "', ts.sort_order='" . $sort_order. "' where ts.id='" . $ojb->id . "'";
            
        $connection = Doctrine_Manager::connection();
        $connection->execute($sql);
          
        $sort_order++;
      }
    }  
    exit();
  }
}
