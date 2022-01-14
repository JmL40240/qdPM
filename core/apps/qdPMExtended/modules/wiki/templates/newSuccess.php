<?php if($sf_request->hasParameter('projects_id')) $form->setDefault('projects_id', $sf_request->getParameter('projects_id')); ?>
<?php if($sf_request->hasParameter('projects_id')) include_component('projects','shortInfo', array('projects'=>$projects)) ?>

<br>

<?php include_partial('wiki/wikiMenu', array('wiki'=>$form->getObject(),'projects_id' => $sf_request->getParameter('projects_id')));?>

<div id="wiki_content">
<?php
 if($sf_request->hasParameter('name'))
 {
   echo '<h1>' . html_entity_decode($sf_request->getParameter('name')) . '</h1>';
 }
 
 $form->setDefault('name', html_entity_decode($sf_request->getParameter('name')));
?>

<?php include_partial('form', array('form' => $form)) ?>
</div>