<div id="viewTypeBox">
<table>
  <tr>
    <td><?php echo renderYuiMenu('view_type_menu', $m) ?></td>
    <td style="font-size:11px; color: gray;"><?php echo ($projects->getTasksView()=='tree' ? __('Tree') : __('List') ) ?></td>
  </tr>
</table>
</div>  

    
<script type="text/javascript">
    YAHOO.util.Event.onContentReady("view_type_menu", function () 
    {
        var oMenuBar = new YAHOO.widget.MenuBar("view_type_menu", {
                                                autosubmenudisplay: true,
                                                hidedelay: 750,
                                                submenuhidedelay: 0,
                                                showdelay: 150,                                                                                                
                                                lazyload: true });
        oMenuBar.render();
    });
</script>