function build_page_contents()
{
  //anchors = $('#wiki_content').getElementsByClassName('contents_anchor');
  anchors = $('.contents_anchor');
  
  level = 1;
      
  if(anchors.length>1)
  {
    html = '<ul>';
       
    for(i=0;i<anchors.length;i++)
    {
      html += '<li>';
      
      html += '<a href="#'+anchors[i].name+'">'+level+' '+anchors[i].id+'</a>';
      
      sub = build_page_sub_contents(html, anchors, i,level.toString());
      
      html = sub[0];
      i = sub[1]; 
      
      html += '</li>';
      
      level++;
    }
            
    html += '</ul>';
    
    $('#page_contents').html(html);
    $('#page_contents').css('display','table');
  } 
}

function build_page_sub_contents(html, anchors, current, currentLevel)
{  
  if(anchors[current+1])
  {      
    if(anchors[current+1].rel>anchors[current].rel)
    {  
      sub_level = 0;
        
      html += '<ul>';
      
      for(i=current+1;i<anchors.length;i++)
      {
        html += '<li>';
        
        sub_level++;
        
        html += '<a href="#'+anchors[i].name+'">'+currentLevel+'.'+sub_level+' '+anchors[i].id+'</a>';
                        
        sub = build_page_sub_contents(html, anchors, i, currentLevel+'.'+sub_level);
                        
        html += '</li>';
                        
        html = sub[0];        
        i = sub[1];
                        
        currentLevelArray = currentLevel.split('.');
        levelDeep = currentLevelArray.length+1;          
                                                      
        if(anchors[i+1])
        {
          if(anchors[i+1].rel<levelDeep)
          {          
            sub_level = currentLevelArray[currentLevelArray.length-1];
            
            html +=  '</ul>';
            return [html,i];            
          }
        }                              
      }
      
      html += '</ul>';
    }
  }

  return [html,i];
}


function do_wiki_preview(url)
{
  $('#wiki_preview').html(I18NText('Loading...'));
      
  $('#wiki_preview').load(url, $('#wiki').serializeArray());  
}

function do_wiki_history_preview(url)
{
   $('#wiki_history_preview').html(I18NText('Loading...'));
      
  $('#wiki_history_preview').load(url);
}