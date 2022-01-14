<?php

/**
 * commonReports actions.
 *
 * @package    sf_sandbox
 * @subpackage commonReports
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class commonReportsActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->projects_reports = Doctrine_Core::getTable('ProjectsReports')
      ->createQuery()      
      ->addWhere('report_type=?','common')
      ->orderBy('name')
      ->execute();
          
    $this->user_reports = Doctrine_Core::getTable('UserReports')
      ->createQuery()      
      ->addWhere('report_type=?','common')
      ->orderBy('name')
      ->execute();
      
    $this->tickets_reports = Doctrine_Core::getTable('TicketsReports')
      ->createQuery()      
      ->addWhere('report_type=?','common')
      ->orderBy('name')
      ->execute();
      
   $this->discussions_reports = Doctrine_Core::getTable('DiscussionsReports')
      ->createQuery()      
      ->addWhere('report_type=?','common')
      ->orderBy('name')
      ->execute();
      
    app::setPageTitle('Common Reports',$this->getResponse());
  }
  
  public function executeNew(sfWebRequest $request)
  {
    $this->choices = array();
    $this->choices['projectsReports'] = t::__('Projects Reports');
    $this->choices['userReports'] = t::__('Tasks Reports');
    $this->choices['ticketsReports'] = t::__('Tickets Reports');
    $this->choices['discussionsReports'] = t::__('Discussions Reports');
  }
  
  public function executeNewReport(sfWebRequest $request)
  {
    switch($request->getParameter('report_type'))
    {
      case 'projectsReports': $this->form = new ProjectsReportsForm();
        break;
      case 'userReports': $this->form = new UserReportsForm();
        break;
      case 'ticketsReports': $this->form = new TicketsReportsForm();
        break;
      case 'discussionsReports': $this->form = new DiscussionsReportsForm();
        break;
    }
    
    $request->setParameter('redirect_to','commonReports');
  }
}
