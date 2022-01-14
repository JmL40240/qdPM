<br>
<?php
use_helper('wikiParser');

echo '<div id="wiki_content">' . (strlen($name)>0 ? '<h1>' . $name . '</h1>':'') . wikiParser($description, $projects_id) . '</div>';
  
?>

<script>
  build_page_contents()
</script>  