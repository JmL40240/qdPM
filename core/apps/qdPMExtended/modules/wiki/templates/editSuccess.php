<?php if($sf_request->hasParameter('projects_id')) include_component('projects','shortInfo', array('projects'=>$projects)) ?>
<br>
<?php include_partial('wiki/wikiMenu', array('wiki'=>$form->getObject(),'projects_id' => $sf_request->getParameter('projects_id')));?>

<div id="wiki_content">
<?php
 if(!$form->getObject()->isNew())
 {
   if(strlen($form->getObject()->getName())>0)
   echo '<h1>' . $form->getObject()->getName() . '</h1>';
 }
?>

<?php include_partial('form', array('form' => $form)) ?>
</div>
