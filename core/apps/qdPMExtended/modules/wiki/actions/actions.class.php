<?php

/**
 * wiki actions.
 *
 * @package    sf_sandbox
 * @subpackage wiki
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class wikiActions extends sfActions
{
  protected function checkAccess($request,$access)
  {
    $projects = null;
    
    if($request->getParameter('projects_id')>0)
    {  
      Users::checkAccess($this,$access,'projectsWiki',$this->getUser(),$request->getParameter('projects_id'));
                  
      $this->forward404Unless($projects = Doctrine_Core::getTable('Projects')->createQuery()->addWhere('id=?',$request->getParameter('projects_id'))->addWhere('in_trash is null')->fetchOne(), sprintf('Object projects does not exist (%s).', $request->getParameter('projects_id')));
    }
    else
    {
      Users::checkAccess($this,$access,'publicWiki',$this->getUser());
    }
    
    return $projects;
    
  }
  
  public function executeIndex(sfWebRequest $request)
  {        
    $this->redirect('wiki/view');
  }
  
  public function executePreview(sfWebRequest $request)
  {
    $this->projects = $this->checkAccess($request,'view');
    
    $wiki = $request->getParameter('wiki');
    $this->name = $wiki['name'];
    $this->projects_id = $wiki['projects_id'];
    $this->description = $wiki['description']; 
  }
  
  public function executeSupportedMarkup(sfWebRequest $request)
  {
  
  }
  
  public function executeHistory(sfWebRequest $request)
  {  
    $this->projects = $this->checkAccess($request,'view');
        
    $this->wiki_history_list = Doctrine_Core::getTable('WikiHistory')
        ->createQuery()
        ->addWhere('wiki_id=?',$request->getParameter('id'))
        ->orderBy('created_at desc')            
        ->execute(); 
              
    $this->wiki = Doctrine_Core::getTable('Wiki')->find($request->getParameter('id'));
  }
  
  public function executeHistoryPreview(sfWebRequest $request)
  {
    $this->projects = $this->checkAccess($request,'view');
          
    $this->wiki_history = Doctrine_Core::getTable('WikiHistory')->find($request->getParameter('id'));
  }
  
  public function executeSearch(sfWebRequest $request)
  {    
    $this->projects_id = $request->getParameter('projects_id');
    
    $q = Doctrine_Core::getTable('Wiki')->createQuery();
    
    if($this->projects_id>0)
    {
      Users::checkAccess($this,'view','projectsWiki',$this->getUser(),$request->getParameter('projects_id'));
            
      $this->forward404Unless($this->projects = Doctrine_Core::getTable('Projects')->createQuery()->addWhere('id=?',$request->getParameter('projects_id'))->addWhere('in_trash is null')->fetchOne(), sprintf('Object projects does not exist (%s).', $request->getParameter('id')));
    
      $q->addWhere('projects_id=?', $this->projects_id);
    }
    else
    {
      Users::checkAccess($this,'view','publicWiki',$this->getUser());
      
      $q->addWhere('projects_id is NULL');
    }
    
    $this->keywords = $request->getParameter('keywords');
    
    $query_sql = '(' . $this->parse_search_keywords('name', $this->keywords) . ' OR ' . $this->parse_search_keywords('description', $this->keywords) . ')';        
    
    $q->addWhere($query_sql);
    
    $q->orderBy('name');
    
    $this->wiki_list = $q->execute();
  }
  
  public function executeView(sfWebRequest $request)
  {
    app::setPageTitle('Wiki',$this->getResponse());
    
    if($request->hasParameter('projects_id'))
    {
      Users::checkAccess($this,'view','projectsWiki',$this->getUser(),$request->getParameter('projects_id'));
            
      $this->forward404Unless($this->projects = Doctrine_Core::getTable('Projects')->createQuery()->addWhere('id=?',$request->getParameter('projects_id'))->addWhere('in_trash is null')->fetchOne(), sprintf('Object projects does not exist (%s).', $request->getParameter('id')));
        
      $this->wiki = Doctrine_Core::getTable('Wiki')
        ->createQuery()
        ->addWhere('projects_id=?',$request->getParameter('projects_id'))            
        ->fetchOne();      
      if(!$this->wiki)
      {
       $this->redirect('wiki/new?projects_id=' . $request->getParameter('projects_id'));
      }
      elseif($request->hasParameter('name'))
      {
        $this->wiki = Doctrine_Core::getTable('Wiki')
          ->createQuery()
          ->addWhere('projects_id=?',$request->getParameter('projects_id'))
          ->addWhere('name=?',html_entity_decode($request->getParameter('name')))            
          ->fetchOne();
        if(!$this->wiki)
        {
          $this->redirect('wiki/new?name=' . $request->getParameter('name') . '&projects_id=' . $request->getParameter('projects_id'));
        }
      }
    }
    else
    {    
      Users::checkAccess($this,'view','publicWiki',$this->getUser());
      
      $this->wiki = Doctrine_Core::getTable('Wiki')
      ->createQuery()
      ->addWhere('projects_id is NULL')            
      ->fetchOne();
      if(!$this->wiki)
      {
       $this->redirect('wiki/new');
      }
      elseif($request->hasParameter('name'))
      {
        $this->wiki = Doctrine_Core::getTable('Wiki')
          ->createQuery()
          ->addWhere('projects_id is NULL')
          ->addWhere('name=?',html_entity_decode($request->getParameter('name')))            
          ->fetchOne();              
        if(!$this->wiki)
        {
          $this->redirect('wiki/new?name=' . $request->getParameter('name'));
        }
      }
    }
      
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->projects = $this->checkAccess($request,'insert');
    
    $this->form = new WikiForm();
    $this->form->setDefault('users_id', $this->getUser()->getAttribute('id'));
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));
    
    $this->projects = $this->checkAccess($request,'insert');

    $this->form = new WikiForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    if((int)$request->getParameter('id')==0) $this->redirect('wiki/new' . ($request->hasParameter('projects_id') ? '?projects_id=' . $request->getParameter('projects_id'):''));
  
    $this->forward404Unless($wiki = Doctrine_Core::getTable('Wiki')->find($request->getParameter('id')), sprintf('Object wiki does not exist (%s).', $request->getParameter('id')));
    
    $this->projects = $this->checkAccess($request,'edit');
    
    $this->form = new WikiForm($wiki);
  }
  
  public function executeAttachments(sfWebRequest $request)
  {      
    $this->forward404Unless($wiki = Doctrine_Core::getTable('Wiki')->find($request->getParameter('id')), sprintf('Object wiki does not exist (%s).', $request->getParameter('id')));
    
    $this->projects = $this->checkAccess($request,'edit');
    
    $this->form = new WikiForm($wiki);
       
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($wiki = Doctrine_Core::getTable('Wiki')->find($request->getParameter('id')), sprintf('Object wiki does not exist (%s).', $request->getParameter('id')));
    
    $this->projects = $this->checkAccess($request,'edit');
    
    $this->form = new WikiForm($wiki);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {    
    $this->projects = $this->checkAccess($request,'delete');
  
    $this->forward404Unless($wiki = Doctrine_Core::getTable('Wiki')->find($request->getParameter('id')), sprintf('Object wiki does not exist (%s).', $request->getParameter('id')));
    $projects_id = $wiki->getProjectsId();

    Attachments::deleteAttachmentsByBindId($wiki->getId(),'wiki');
     
    $wiki->delete();
    
    $this->redirect('wiki/view' . ($projects_id>0 ?  '?projects_id=' . $projects_id:''));
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {  
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
        $form->protectFieldsValue();
        
      $wiki = $form->save();
      
      //save wiki history
      $wikiHistory = new WikiHistory();
      $wikiHistory->setWikiId($wiki->getId());
      $wikiHistory->setProjectsId($wiki->getProjectsId());
      $wikiHistory->setName($wiki->getName());
      $wikiHistory->setDescription($wiki->getDescription());
      $wikiHistory->setUsersId($this->getUser()->getAttribute('id'));
      $wikiHistory->setCreatedAt(date('Y-m-d H:i:s'));
      $wikiHistory->save();
       
      //save attachments                  
      Attachments::insertAttachments($request->getFiles(),'wiki',$wiki->getId(),$request->getParameter('attachments_info'),$this->getUser());
                  
      if(Attachments::hasFilesInRequest($request->getFiles()))
      {        
        $this->redirect('wiki/edit?id='.$wiki->getId() . ($wiki->getProjectsId()>0 ? '&projects_id=' . $wiki->getProjectsId() :''));                
      }
      else
      {
        if(strlen($wiki->getName())>0)
        {
          $this->redirect('wiki/view?name='.htmlentities($wiki->getName()) . ($wiki->getProjectsId()>0 ? '&projects_id=' . $wiki->getProjectsId() :''));
        }
        else
        {
          $this->redirect('wiki/view' . ($wiki->getProjectsId()>0 ? '?projects_id=' . $wiki->getProjectsId() :''));
        }
      }
    }
  }
  
  protected function parse_search_keywords($field_name, $keywords)
  {
     $keywords_array = explode(' ', $keywords);
     
     if(sizeof($keywords_array)>1)
     {
       $sql = "(";
       
       for($i=0; $i<sizeof($keywords_array); $i++)
       {
         $sql .= $field_name . " LIKE '%" . $keywords_array[$i] . "%'";
         
         if(isset($keywords_array[$i+1]))
         {
           $sql .= " AND ";
         }         
       }
       
       $sql .= ")";
       
       return $sql;
       
     }
     else
     {
       return $field_name . " LIKE '%" . $keywords . "%'";
     }
     
  }
}
