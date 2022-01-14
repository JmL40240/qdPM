<div id="tasksTimer" <?php echo (!$display_timer ? 'style="display:none"':'' )?>>
  <table>
    <tr>
      <td><a href="#" class="btn btn-default btn-xs" id="tasks_timer_close" title="<?php echo  __('Close Timer') ?>"><i class="fa fa-times"></i></a></td>
      <td>
        <input id="tasks_timer_start" type="button" class="btn btn-default" value="<?php echo __('Start')?>">
        <input id="tasks_timer_stop"  type="button" class="btn btn-default" value="<?php echo __('Stop')?>" style="display:none">
      </td>
      <td>
        <span id="tasks_timer_time"></span>        
        <?php echo input_hidden_tag('tasks_timer_seconds',($timer?$timer->getSeconds():0)); ?>        
      </td>
      <td><?php echo __('Work Hours:')?>&nbsp;<span id="tasks_timer_hours"></span></td>      
      <td><input id="tasks_timer_save" type="button" class="btn  btn-default" value="<?php echo __('Save')?>"></td>
    </tr>
  </table>
</div>

<script type="text/javascript">

function update_timer_view(seconds)
{
  minutes = Math.floor(seconds/60);
  hours = Math.floor(seconds/3600);
            
  if(minutes>0) seconds = seconds-(minutes*60);
  if(hours>0)minutes = minutes-(hours*60);
              
  work_hours = (hours+(1/(60/minutes)));
  work_hours = work_hours.toFixed(2);
  $('#tasks_timer_hours').html(work_hours);
  
  if(seconds<10) seconds = '0'+seconds;  
  if(minutes<10) minutes = '0'+minutes;
  if(hours<10) hours = '0'+hours;
  
  $('#tasks_timer_time').html(hours+':'+minutes+':'+seconds);
}

$(document).ready(function(){
  	
   update_timer_view($("#tasks_timer_seconds").val());
    
	 $("#tasks_timer_start").click(function() {
   
        window.onbeforeunload = function () { return "<?php echo 'Timer is running!'?>" };
   
        $('#tasks_timer_start').css('display','none');
        $('#tasks_timer_stop').css('display','');
   
        
        $("#tasks_timer_seconds").everyTime(1000, 'tasks_timer', function() {
                                    
            $(this).val(parseInt($(this).val())+1);
            
            seconds = parseInt($(this).val());
                        
            if(seconds/60==Math.floor(seconds/60))
            {
              $.ajax({type: "POST",url: '<?php echo url_for("tasksComments/tasksTimer?timer_action=update&tasks_id=" . $tasks->getId()) ?>',data: {seconds:seconds}});
            }
            
            update_timer_view(seconds)
        });
    });
    
    $("#tasks_timer_stop").click(function() {
    
        window.onbeforeunload = '';
    
        $('#tasks_timer_start').css('display','');
        $('#tasks_timer_stop').css('display','none');
        
        $("#tasks_timer_seconds").stopTime('tasks_timer');
    });
                                                     
    $("#tasks_timer_save").click(function() {
     
      window.onbeforeunload = ''; 
     
      $('#tasks_timer_start').css('display','');
      $('#tasks_timer_stop').css('display','none'); 
       
      $("#tasks_timer_seconds").stopTime('tasks_timer');  
      
      openModalBox('<?php echo url_for("tasksComments/new?projects_id=" . $tasks->getProjectsId() . "&tasks_id=" . $tasks->getId() . "&set_worked_hours=timer")?>')
    });
    
    $("#tasks_timer_open").click(function() {
      $('#tasksTimer').css('display','');
      
      update_timer_view($("#tasks_timer_seconds").val());
      
      $.ajax({type: "POST",url: '<?php echo url_for("tasksComments/tasksTimer?timer_action=open&tasks_id=" . $tasks->getId()) ?>'});
    });
    
    $("#tasks_timer_close").click(function() {
      if(confirm(I18NText('Are you sure?')))
      {
        window.onbeforeunload = '';
        
        $("#tasks_timer_seconds").stopTime('tasks_timer');
        
        $('#tasks_timer_start').css('display','');
        $('#tasks_timer_stop').css('display','none');
         
        $('#tasksTimer').css('display','none');
        $("#tasks_timer_seconds").val(0);
        
        $('#tasks_timer_hours').html('');
        
        $.ajax({type: "POST",url: '<?php echo url_for("tasksComments/tasksTimer?timer_action=close&tasks_id=" . $tasks->getId()) ?>'});
      }
    });
    
	
		
	
});
</script>