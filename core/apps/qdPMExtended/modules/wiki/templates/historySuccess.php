<?php if($sf_request->getParameter('projects_id')>0) include_component('projects','shortInfo', array('projects'=>$projects)) ?>

<?php                                                                                                    
  include_partial('wiki/wikiMenu', array('wiki'=>$wiki,'projects_id' => $sf_request->getParameter('projects_id')));   
?>

<div id="wiki_content">
  <div id="wiki_history_list">
    <table>
      <tbody>
       <?php foreach ($wiki_history_list as $wiki_history): ?>
       <tr>                  
          <td><a href="#" onClick="do_wiki_history_preview('<?php echo url_for('wiki/historyPreview?id=' . $wiki_history->getId());?>')"><?php echo app::dateTimeFormat($wiki_history->getCreatedAt()) . '&nbsp;&nbsp;&nbsp;' . $wiki_history->getUsers()->getName() . ' (' . $wiki_history->getUsers()->getEmail() . ')'; ?></a></td>      
        </tr>
        <?php endforeach; ?>
      
      </tbody>
    </table>
  </div>  
  
  <div id="wiki_history_preview">
  </div>

</div>  
  