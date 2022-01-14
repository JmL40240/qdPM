<?php

/**
 * discussionsPriority actions.
 *
 * @package    sf_sandbox
 * @subpackage discussionsPriority
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class discussionsPriorityActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    app::setPageTitle('Discussions Priorities',$this->getResponse());
    
    $this->discussions_prioritys = Doctrine_Core::getTable('DiscussionsPriority')
      ->createQuery('a')
      ->orderBy('sort_order, name')
      ->execute();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new DiscussionsPriorityForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new DiscussionsPriorityForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($discussions_priority = Doctrine_Core::getTable('DiscussionsPriority')->find(array($request->getParameter('id'))), sprintf('Object discussions_priority does not exist (%s).', $request->getParameter('id')));
    $this->form = new DiscussionsPriorityForm($discussions_priority);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($discussions_priority = Doctrine_Core::getTable('DiscussionsPriority')->find(array($request->getParameter('id'))), sprintf('Object discussions_priority does not exist (%s).', $request->getParameter('id')));
    $this->form = new DiscussionsPriorityForm($discussions_priority);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($discussions_priority = Doctrine_Core::getTable('DiscussionsPriority')->find(array($request->getParameter('id'))), sprintf('Object discussions_priority does not exist (%s).', $request->getParameter('id')));
    $discussions_priority->delete();

    $this->redirect('discussionsPriority/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $discussions_priority = $form->save();
      
      if($discussions_priority->getDefaultValue()==1)
      {
        app::resetCfgDefaultValue($discussions_priority->getId(),'DiscussionsPriority');
      }

      $this->redirect('discussionsPriority/index');
    }
  }
}
