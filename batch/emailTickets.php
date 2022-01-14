<?php

header('Content-type: text/html; charset=utf-8');
 
require_once(dirname(__FILE__).'/../core/config/ProjectConfiguration.class.php');
$configuration = ProjectConfiguration::getApplicationConfiguration('qdPMExtended', 'batch', true);
sfContext::createInstance($configuration);
 
// Remove the following lines if you don't use the database layer
$databaseManager = new sfDatabaseManager($configuration);
$databaseManager->loadConfiguration();
 
// add code here

set_time_limit(0);

$mailFetcher = new mailFetcher();
$mailFetcher->fetch();