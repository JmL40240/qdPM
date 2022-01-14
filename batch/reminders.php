<?php

require_once('config.php');
 
require_once(dirname(__FILE__).'/../core/config/ProjectConfiguration.class.php');
$configuration = ProjectConfiguration::getApplicationConfiguration('qdPMExtended', 'batch', true);
sfContext::createInstance($configuration);
 
// Remove the following lines if you don't use the database layer
$databaseManager = new sfDatabaseManager($configuration);
$databaseManager->loadConfiguration();
 
// add code here

function genBatchUrl($url)
{    
  $url = HTTP_PATH_TO_QDPM . $url;
  
  return $url;
}


//send scheduler reminder
Events::sendReminder();

//send tasks reminder
UserReports::sendReminder();

