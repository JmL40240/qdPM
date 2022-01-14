<br>
<?php
  use_helper('wikiParser');
  echo app::dateTimeFormat($wiki_history->getCreatedAt()) . '&nbsp;&nbsp;&nbsp;' . $wiki_history->getUsers()->getName() . ' (' . $wiki_history->getUsers()->getEmail() . ')';
  echo '<div id="wiki_content">' . (strlen($wiki_history->getName())>0 ? '<h1>' . $wiki_history->getName() . '</h1>':'') . wikiParser($wiki_history->getDescription(), $wiki_history->getProjectsId()) . '</div>';