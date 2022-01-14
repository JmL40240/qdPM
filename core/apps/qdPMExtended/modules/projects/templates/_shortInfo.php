<h3 class="page-title"><?php echo $projects->getName() ?></h3>

<div class="project-short-info">
  <table>
    <tr>
      <?php if($projects->getProjectsPriorityId()>0) echo '<td><div><span>' . __('Priority') . ':</span> ' . $projects->getProjectsPriority()->getName() . '</div></td>';?>
      <?php 
        if($projects->getProjectsStatusId()>0)
        { 
          $html = '<td><div><span>' . __('Status') . ':</span> '; 
          
          if($projects->getProjectsStatus()->getStatusGroup()=='closed')
          {
            $html .= '<span class="label label-danger">' . $projects->getProjectsStatus()->getName() . '</span>';
          }
          else
          {
            $html .= $projects->getProjectsStatus()->getName();
          }
          
          $html .= '</div></td>';
          
          echo $html;
        }
      ?>
      <?php if($projects->getProjectsTypesId()>0) echo '<td><div><span>' . __('Type') . ':</span> ' . $projects->getProjectsTypes()->getName() . '</div></td>';?>
      <?php       
      if($projects->getProjectsGroupsId()>0 and count($m)<=1)
      { 
        echo '<td><div><span>' . __('Group') . ':</span> ' . $projects->getProjectsGroups()->getName() . '</div></td>'; 
      }
      elseif(count($m)>1)
      { 
        $m = array(array('title'=>__('Group') . ': ' .  $projects->getProjectsGroups()->getName(),'submenu'=>$m));
        echo '<td><div>' . renderYuiMenu('projectsGroupsMenu',$m) . '</div></td>'; 
       ?>
          <script type="text/javascript">
            YAHOO.util.Event.onContentReady("projectsGroupsMenu", function () 
            {
                var oMenuBar = new YAHOO.widget.MenuBar("projectsGroupsMenu", {
                                                        autosubmenudisplay: true,
                                                        hidedelay: 750,
                                                        submenuhidedelay: 0,
                                                        showdelay: 150,
                                                        lazyload: true });
                oMenuBar.render();
            });
        </script>
      <?php
      } 
      ?>
      <td><?php echo link_to_modalbox(__('More Info'),'projects/info?id=' . $projects->getId()) ?></td>
      <td><?php if(Users::hasAccess('edit','projects',$sf_user,$projects->getId())) echo link_to_modalbox(__('Edit Details'),'projects/edit?id=' . $projects->getId() . '&redirect_to=projectsComments') ?></td>
    </tr>        
  </table>
</div>

<div id="projectMenuContainer">
  <div id="projectMenuBox"> 
    <?php $m = new projectsMenuController($sf_user,$sf_request); echo renderYuiMenu('projectMenu',$m->buildMenu($sf_context)) ?>
  </div>
</div>

<script type="text/javascript">
    YAHOO.util.Event.onContentReady("projectMenu", function () 
    {
        var oMenuBar = new YAHOO.widget.MenuBar("projectMenu", {
                                                autosubmenudisplay: true,
                                                hidedelay: 750,
                                                submenuhidedelay: 0,
                                                showdelay: 150,
                                                lazyload: true });
        oMenuBar.render();
    });
</script>
