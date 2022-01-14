<?php 

if(count($tickets_list)>0)
{ 

  $menu = array();
  $submenu = array();
  foreach($tickets_list as $tickets)
  {              
    $s = array();
            
    $tickets_comments = Doctrine_Core::getTable('TicketsComments')
      ->createQuery('tc')
      ->addWhere('tc.tickets_id=?',$tickets['id'])
      ->addWhere('tc.in_trash is null')
      ->orderBy('tc.created_at desc')
      ->limit(3)
      ->fetchArray();
      
     foreach ($tickets_comments as $c)
     {
       $description = trim(strip_tags($c['description']));
      
       if(strlen($description))
       {
         $s[] = array('title'=> (strlen($description)>100 ? substr($description,0,100) . '...' : $description), 'onClick'=>'use_related_comments(' . $c['id'] . ',\'' . $field_id . '\')');
         
         echo input_hidden_tag('related_ticket_comment_' . $c['id'], $c['description']);
       }
     }
    
    if(count($s))
    {
      $submenu[] = array('title'=>$tickets['name'],'submenu'=>$s);
    }                  
  } 
    
  if(count($submenu))
  {  
    $menu[] = array('title'=>__('Comments'),'submenu'=>$submenu); 
    
    //echo link_to((isset($tickets['TicketsTypes'])?$tickets['TicketsTypes']['name'] . ': ':'') . $tickets['name'] . (isset($tickets['TicketsStatus']) ? ' [' . $tickets['TicketsStatus']['name'] . ']':''), 'ticketsComments/index?tickets_id=' . $tickets['id'] . '&projects_id=' . $tickets['projects_id'],array('absolute'=>true)) 
  
    
    //print_r($menu);
    
    $time = time()+1;
    
    echo renderYuiMenu('patterns' . $time, $menu); 

?>
                          
<script type="text/javascript">
    YAHOO.util.Event.onContentReady("patterns<?php echo $time ?>", function () 
    {
        var patternsMenu = new YAHOO.widget.MenuBar("patterns<?php echo $time ?>", {
                                                autosubmenudisplay: true,
                                                hidedelay: 750,
                                                submenuhidedelay: 0,
                                                scrollincrement:10,
                                                showdelay: 150,
                                                lazyload: true });
        patternsMenu.render();
    });
</script>

<style>
 #patterns<?php echo $time ?>{
   float:right;
   margin-top: 10px;
 }
</style>


<?php
  }  
}
?> 




