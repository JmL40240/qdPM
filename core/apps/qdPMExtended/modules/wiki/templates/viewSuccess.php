<?php if($sf_request->hasParameter('projects_id')) include_component('projects','shortInfo', array('projects'=>$projects)) ?>

<?php                                                                                                  
  include_partial('wiki/wikiMenu', array('wiki'=>$wiki,'projects_id' => $sf_request->getParameter('projects_id')));

  use_helper('wikiParser');
      
  echo '<div id="wiki_content">' . (strlen($wiki->getName())>0 ? '<h1>' . $wiki->getName() . '</h1>':'') . wikiParser($wiki->getDescription(), $sf_request->getParameter('projects_id')) . '</div>';
?>

<script>
  build_page_contents()
</script>  
  