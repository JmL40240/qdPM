<div class="panel panel-info filter-preview">
<div class="panel-heading"><?php include_component('usersProjectsReport','filters') ?></div>

<?php if(count($filter_by)>0): ?>
<ul class="list-group">
<?php 
$count = 0;
foreach($filter_tables as $table=>$title): 

if(!isset($filter_by[$table])) continue;

if($count>5){ echo '</tr><tr>'; $count=0;}
$count++

?>    
    <li class="list-group-item filter-preview-item">
      <div class="filterPreviewBox">
        <table>
          <tr>
            <td valign="top" style="padding-top: 2px;"><?php echo link_to(image_tag('icons/close_gray.png'),'usersProjectsReport/index?remove_filter=' . $table,array('title'=>__('Remove Filter')))?></td>
            <td valign="top"><div id="filtersPreviewMenuBox">
            <?php 
            
             if(strstr($table,'extraField'))
             {
               $m = app::getFilterExtraFields(array(),$table,'projects','usersProjectsReport/index',false,$filter_by[$table],$sf_user);
             }
             else
             {
                switch($table)
                {
                  case 'ProjectsStatus':  $m =  app::getFilterMenuStatusItemsByTable(array(),$table,'Status','usersProjectsReport/index',false,$filter_by[$table]);
                    break;
                  case 'Users':  $m =  app::getFilterMenuUsers(array(),$table, 'In Team','usersProjectsReport/index',false,$filter_by[$table]);
                    break;
                  default: $m = app::getFilterMenuItemsByTable(array(),$table,$title,'usersProjectsReport/index',false,$filter_by[$table],$sf_user);                 
                    break;
                }
              }
                
                echo renderYuiMenu('filtersMenu' . $table,$m);
                 
                
            ?></div></td>
            <td valign="middle" class="selectedFilterItems"><?php echo (strstr($table,'extraField')? $filter_by[$table] : app::getNameByTableId($table,$filter_by[$table]))?></td>
          </tr>
        </table>
      </div>
      
      <script type="text/javascript">
          YAHOO.util.Event.onContentReady("filtersMenu<?php echo $table ?>", function () {
              var oMenuBar = new YAHOO.widget.MenuBar("filtersMenu<?php echo $table ?>", {autosubmenudisplay: true,hidedelay: 350,submenuhidedelay: 0,showdelay: 150,keepopen: true,lazyload: true });
              oMenuBar.render();
          });
      </script>
      
    </li>
<?php endforeach ?>    
</ul>
<?php endif ?>
</div>