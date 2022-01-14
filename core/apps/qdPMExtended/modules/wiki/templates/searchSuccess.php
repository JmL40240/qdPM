<?php if($sf_request->getParameter('projects_id')>0) include_component('projects','shortInfo', array('projects'=>$projects)) ?>

<?php use_helper('wikiParser'); ?>

<?php echo form_tag('wiki/search','method=get') . '<div id="wiki_search">' . input_hidden_tag('projects_id',$sf_request->getParameter('projects_id')). input_tag('keywords',$sf_request->getParameter('keywords'),array('size'=>40))  . '&nbsp;' . submit_tag(__('Search')). '</div></form>'; ?>

<table>
  <tbody>
    <?php foreach ($wiki_list as $wiki): 
    
    if(strlen($wiki->getName())==0 and $wiki->getProjectsId()>0)
    {
      $wiki_name = $wiki->getProjects()->getName();
    }
    elseif(strlen($wiki->getName())==0)
    {
      $wiki_name = sfConfig::get('app_app_name');
    }
    else
    {
      $wiki_name = $wiki->getName();
    }
    
    $description = wiki_search_keywords_in_description($sf_request->getParameter('keywords'), $wiki->getDescription());
    
    if($sf_request->getParameter('projects_id')>0)
    {
      $url_for = 'wiki/view?projects_id=' . $sf_request->getParameter('projects_id') . (strlen($wiki->getName())>0 ? '&name=' . $wiki->getName():'');
    }
    else
    {
      $url_for = 'wiki/view' . (strlen($wiki->getName())>0 ? '?name=' . $wiki->getName():'');
    }
    
    ?>
    <tr>      
      <td style="padding-bottom: 10px;">
      <a href="<?php echo url_for($url_for); ?>"><?php echo $wiki_name ?></a><br>
      <?php echo $description; ?>
      </td>            
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

