<?php
/**
*qdPM
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@qdPM.net so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade qdPM to newer
* versions in the future. If you wish to customize qdPM for your
* needs please refer to http://www.qdPM.net for more information.
*
* @copyright  Copyright (c) 2009  Sergey Kharchishin and Kym Romanets (http://www.qdpm.net)
* @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
?>

<!-- BEGIN SIDEBAR -->

<?php
	// Session user id	
	if(file_exists("extensions\\qdpm\\txt\\".$_COOKIE["qdPMExtendedV3"].".txt")){
		unlink("extensions\\qdpm\\txt\\".$_COOKIE["qdPMExtendedV3"].".txt");
	}
	$f = fopen("extensions\\qdpm\\txt\\".$_COOKIE["qdPMExtendedV3"].".txt","w+");
	$id = $sf_context->getUser()->getAttribute('id');	
	fwrite($f,$id);
	fclose($f);		
?>

<div class="page-sidebar-wrapper">
	<div class="page-sidebar-wrapper">
		<div class="page-sidebar navbar-collapse collapse">
			<!-- BEGIN SIDEBAR MENU -->
			<ul class="page-sidebar-menu">
				<li class="sidebar-toggler-wrapper">
        
<?php
if(is_file(sfConfig::get('sf_upload_dir')  . '/' . sfConfig::get('app_app_logo')))
{
  echo '<div class="logo"><a  href="' .url_for("dashboard/index") . '">' . image_tag('/uploads/' . sfConfig::get('app_app_logo'), array('title'=>sfConfig::get('app_app_name'),'id'=>'navbar-brand-logo')) . '</a></div>';
}
?> 
        
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
					<div class="sidebar-toggler">
					</div>
					<div class="clearfix">
					</div>
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
				</li>
				
        <?php $m = new menuController($sf_user,$sf_request); echo renderSidebarMenu($m->buildMenu(),'',0,array('moduleName'=>$sf_context->getModuleName(),'actionName'=>$sf_context->getActionName(),'sf_request'=>$sf_request)) ?>
                      
					
		<li class>
			<a  href=""><i class="fa fa-gear"></i> <span class="title">Pilotage</span><span class="arrow "></span></a>
			<ul class="sub-menu" style="display: none;">
				<li>
					<a class="outilDSI"  target="_blank" href="http://localhost/extensions/qdpm/projets.php" ><span class="title">Liste des Projets</span></a>
				</li>				
				<li>
					<a class="outilDSI"  target="_blank" href="http://localhost/extensions/qdpm/projetstaches.php" ><span class="title">Liste des T??ches</span></a>
				</li>
				<li>
					<a class="outilDSI"  target="_blank" href="http://localhost/extensions/qdpm/meteo.php" ><span class="title">M??t??o des Projets</span></a>
				</li>
				<li>
					<a class="outilDSI"  target="_blank" href="http://localhost/extensions/qdpm/controle.php" ><span class="title">Contr??le des Projets</span></a>
				</li>
			</ul>
        </li>	
			</ul>
			<!-- END SIDEBAR MENU -->
		</div>
	</div>
</div>
<!-- END SIDEBAR -->

