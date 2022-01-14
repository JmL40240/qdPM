<?php if(count($menu)>0 and $sf_user->hasCredential('allow_manage_patterns')): $time = time() ?>
<div id="patternsContainer">
<?php echo renderYuiMenu('patterns' . $time, $menu) ?>
</div>                        
  
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
 }
</style>

<?php
  foreach($patterns as $p)
  {
    echo input_hidden_tag('pattern_name_' . $p->getId(),$p->getName()) . input_hidden_tag('pattern_desc_' . $p->getId(),$p->getDescription()); 
  }
?>
  
<?php endif ?>