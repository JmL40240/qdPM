<?php

/**
 * contactsGroups actions.
 *
 * @package    sf_sandbox
 * @subpackage contactsGroups
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class contactsGroupsActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    app::setPageTitle('Contacts Groups',$this->getResponse());
    
    $this->contacts_groupss = Doctrine_Core::getTable('ContactsGroups')
      ->createQuery('a')
      ->orderBy('sort_order, name')
      ->execute();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new ContactsGroupsForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new ContactsGroupsForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($contacts_groups = Doctrine_Core::getTable('ContactsGroups')->find(array($request->getParameter('id'))), sprintf('Object contacts_groups does not exist (%s).', $request->getParameter('id')));
    $this->form = new ContactsGroupsForm($contacts_groups);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($contacts_groups = Doctrine_Core::getTable('ContactsGroups')->find(array($request->getParameter('id'))), sprintf('Object contacts_groups does not exist (%s).', $request->getParameter('id')));
    $this->form = new ContactsGroupsForm($contacts_groups);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($contacts_groups = Doctrine_Core::getTable('ContactsGroups')->find(array($request->getParameter('id'))), sprintf('Object contacts_groups does not exist (%s).', $request->getParameter('id')));
    $contacts_groups->delete();

    $this->redirect('contactsGroups/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $contacts_groups = $form->save();

      $this->redirect('contactsGroups/index');
    }
  }
}
