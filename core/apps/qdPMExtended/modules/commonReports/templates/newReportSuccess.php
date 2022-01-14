<?php 

  switch($sf_request->getParameter('report_type'))
  {
    case 'projectsReports': include_partial('projectsReports/form', array('form' => $form));
      break;
    case 'userReports': include_partial('userReports/form', array('form' => $form));
      break;
    case 'ticketsReports': include_partial('ticketsReports/form', array('form' => $form));
      break;
    case 'discussionsReports': include_partial('discussionsReports/form', array('form' => $form));
      break;      
  }
?>