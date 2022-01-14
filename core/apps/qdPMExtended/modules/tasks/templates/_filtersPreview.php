<div class="panel panel-info filter-preview">
<div class="panel-heading">

<?php include_component('tasks','filters') ?>

</div>

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
            <td valign="top" style="padding-top: 2px;"><?php echo link_to('<i class="fa fa-times"></i>','tasks/index?remove_filter=' . $table . ($params? '&' . $params:''),array('title'=>__('Remove Filter'),'class'=>'btn btn-default btn-xs'))?></td>
            <td valign="top"><div id="filtersPreviewMenuBox">
            <?php 
            
             if(strstr($table,'extraField'))
             {
               $m = app::getFilterExtraFields(array(),$table,'tasks','tasks/index',false,$filter_by[$table],$sf_user);
             }
             else
             {             
                switch($table)
                {
                  case 'TasksStatus':  $m =  app::getFilterMenuStatusItemsByTable(array(),$table,'Status','tasks/index',$params,$filter_by[$table]);
                    break;
                  case 'TasksAssignedTo':  $m =  app::getFilterMenuUsers(array(),$table,'Assigned To','tasks/index',$params,$filter_by[$table]);
                    break;
                  case 'TasksCreatedBy':  $m =  app::getFilterMenuUsers(array(),$table,'Created By','tasks/index',$params,$filter_by[$table]);
                    break;
                  case 'Projects':  $m =  app::getFilterProjects(array(),'tasks/index',$params,$filter_by[$table],$sf_user); 
                    break;
                  case 'ProjectsStatus':  $m =  app::getFilterMenuStatusItemsByTable(array(),$table,'Project Status','tasks/index',$params,$filter_by[$table]);
                    break;
                    
                  default: $m = app::getFilterMenuItemsByTable(array(),$table,$title,'tasks/index',$params,$filter_by[$table],$sf_user);                 
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
              var oMenuBar = new YAHOO.widget.MenuBar("filtersMenu<?php echo $table ?>", {autosubmenudisplay: true,hidedelay: 350,submenuhidedelay: 0,scrollincrement:10,showdelay: 150,keepopen: true,lazyload: true });
              oMenuBar.render();
          });
      </script>
      
    </li>
<?php endforeach ?>    
</ul>
<?php endif ?>
</div>