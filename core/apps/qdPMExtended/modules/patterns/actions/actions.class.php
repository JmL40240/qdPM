<?php

/**
 * patterns actions.
 *
 * @package    sf_sandbox
 * @subpackage patterns
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class patternsActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    app::setPageTitle('Patterns',$this->getResponse());
    
    $this->patternss = Doctrine_Core::getTable('Patterns')
      ->createQuery()
      ->addWhere('users_id=?',$this->getUser()->getAttribute('id'))
      ->orderBy('type, name')
      ->execute();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new PatternsForm(null,array('sf_user'=>$this->getUser()));
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new PatternsForm(null,array('sf_user'=>$this->getUser()));

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($patterns = Doctrine_Core::getTable('Patterns')->find(array($request->getParameter('id'))), sprintf('Object patterns does not exist (%s).', $request->getParameter('id')));
    $this->form = new PatternsForm($patterns,array('sf_user'=>$this->getUser()));
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($patterns = Doctrine_Core::getTable('Patterns')->find(array($request->getParameter('id'))), sprintf('Object patterns does not exist (%s).', $request->getParameter('id')));
    $this->form = new PatternsForm($patterns,array('sf_user'=>$this->getUser()));

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($patterns = Doctrine_Core::getTable('Patterns')->find(array($request->getParameter('id'))), sprintf('Object patterns does not exist (%s).', $request->getParameter('id')));
    $patterns->delete();

    $this->redirect('patterns/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
        $form->protectFieldsValue();
        
      $patterns = $form->save();

      $this->redirect('patterns/index');
    }
  }
}
