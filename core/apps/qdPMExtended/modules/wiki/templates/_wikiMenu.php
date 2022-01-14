<?php

echo form_tag('wiki/search','method=get') . '<div id="wiki_search">' . input_hidden_tag('projects_id',$projects_id). input_tag('keywords','',array('class'=>'form-control input-medium','style'=>'display:inline'))  . '&nbsp;' . submit_tag(__('Search')). '</div></form>';


if($projects_id>0)
{
  $params = '&projects_id=' . $projects_id;
  $edit_access = Users::hasAccess('edit','projectsWiki',$sf_user,$projects_id); 
}
else
{
  $params = '';
  $edit_access = Users::hasAccess('edit','publicWiki',$sf_user);
}

if(($projects_id>0 and $sf_user->hasCredential('projects_wiki_access_full_access')) or ((int)$projects_id==0 and $sf_user->hasCredential('public_wiki_access_full_access')))
{

  echo '<div id="wiki_menu">
      			<ul>
      				 <li>' . (strlen($wiki->getName())>0 ? link_to(__('Page'),'wiki/view?name=' . htmlentities($wiki->getName()) . $params) : link_to(__('Page'),'wiki/view' . str_replace('&','?',$params))) . '</li>' .     				 
      				 ( ($edit_access and $wiki->getId()>0) ?
               '<li>' . link_to(__('Edit'),'wiki/edit?id=' . (int)$wiki->getId() . $params) . '</li>' .
               '<li>' . link_to_modalbox(__('Attachments'),'wiki/attachments?id=' . (int)$wiki->getId() . $params) . '</li>'.
      				 '<li>' . link_to(__('History'),'wiki/history?id=' . $wiki->getId(). $params) . '</li>
      				 <li style="margin-left: 15px;">' . link_to(__('Delete'),'wiki/delete?id=' . $wiki->getId() . $params, array('confirm'=>__('Are you sure?'))). '</li>':'')  . '
      			</ul>
      		</div>';
}    		