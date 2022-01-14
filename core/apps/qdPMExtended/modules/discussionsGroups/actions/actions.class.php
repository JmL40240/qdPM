<?php

/**
 * discussionsGroups actions.
 *
 * @package    sf_sandbox
 * @subpackage discussionsGroups
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class discussionsGroupsActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    app::setPageTitle('Discussions Groups',$this->getResponse());
    
    $this->discussions_groupss = Doctrine_Core::getTable('DiscussionsGroups')
      ->createQuery('a')
      ->orderBy('sort_order, name')
      ->execute();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new DiscussionsGroupsForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new DiscussionsGroupsForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($discussions_groups = Doctrine_Core::getTable('DiscussionsGroups')->find(array($request->getParameter('id'))), sprintf('Object discussions_groups does not exist (%s).', $request->getParameter('id')));
    $this->form = new DiscussionsGroupsForm($discussions_groups);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($discussions_groups = Doctrine_Core::getTable('DiscussionsGroups')->find(array($request->getParameter('id'))), sprintf('Object discussions_groups does not exist (%s).', $request->getParameter('id')));
    $this->form = new DiscussionsGroupsForm($discussions_groups);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($discussions_groups = Doctrine_Core::getTable('DiscussionsGroups')->find(array($request->getParameter('id'))), sprintf('Object discussions_groups does not exist (%s).', $request->getParameter('id')));
    $discussions_groups->delete();

    $this->redirect('discussionsGroups/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $discussions_groups = $form->save();
      
      if($discussions_groups->getDefaultValue()==1)
      {
        app::resetCfgDefaultValue($discussions_groups->getId(),'DiscussionsGroups');
      }

      $this->redirect('discussionsGroups/index');
            
    }
  }
}
