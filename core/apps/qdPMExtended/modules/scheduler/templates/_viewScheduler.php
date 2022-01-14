<?php echo javascript_include_tag('/template/plugins/fullcalendar-2.3.0/lib/moment.min.js') ?>
<?php echo javascript_include_tag('/template/plugins/fullcalendar-2.3.0/fullcalendar.min.js') ?>
<?php     
  if(is_file('template/plugins/fullcalendar-2.3.0/lang/' . $sf_user->getCulture() . '.js'))
  {
    echo javascript_include_tag('/template/plugins/fullcalendar-2.3.0/lang/' . $sf_user->getCulture() . '.js');
  } 
?>
<ul class="nav nav-tabs">
	<li class="active">
		<a href="#1" data-toggle="tab">Calendrier</a>
	</li> 
	<li>
		<a href="#2" data-toggle="tab">Tableau</a>
	</li> 
</ul>
<div class="tab-content" >
    <div class="tab-pane fade active in" id="1">
		<div id="calendar_loading" class="loading_data"></div>
		<div id="calendar"></div>
	</div>
	<div class="tab-pane fade" id="2">
	
	</div>
</div>

<script>

	$(document).ready(function() {
		
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			defaultDate: '<?php echo date("Y-m-d")?>',
      firstDay: '0',
      timezone: false,
			selectable: true,
			selectHelper: true,
      editable: true,
			eventLimit: true, // allow "more" link when too many events
			select: function(start, end, jsEvent, view) {				
        openModalBox('<?php echo url_for("scheduler/new")?>'+'?<?php if(isset($users_id))  echo "users_id=" . $users_id . "&"; ?>start='+start+'&end='+end+'&view_name='+view.name) 
			},
      eventClick: function(calEvent, jsEvent, view) {
        if(calEvent.url.length>0)
        {
          openModalBox(calEvent.url)
        }        
        return false;
      },
      eventResize: function(event, delta, revertFunc) {
        $.ajax({type: "POST",url: "<?php echo url_for('scheduler/resize')?>",data: {id:event.id,end:event.end.format()}});
      },
      eventDrop: function(event, delta, revertFunc) {
        if(event.end)
        {
          $.ajax({type: "POST",url: "<?php echo url_for('scheduler/drop')?>",data: {id:event.id,start:event.start.format(),end:event.end.format()}});
        }
        else
        {
          $.ajax({type: "POST",url: "<?php echo url_for('scheduler/drop')?>",data: {id:event.id,start:event.start.format()}});
        }
      },
      eventMouseover: function(calEvent, jsEvent, view) {        
        if(calEvent.title.length>23 || calEvent.description.length>0)
          $(this).popover({html:true,title:calEvent.title,content:calEvent.description,placement:'top',container:'body'}).popover('show');        
      },
      eventMouseout:function(calEvent, jsEvent, view) {
        $(this).popover('hide');
      },			
			events: {
				url: '<?php echo url_for("scheduler/" . (isset($users_id) ? "getPersonalEvents":"getPublicEvents"))?>',
        error: function() {
				  alert('<?php echo "Error loading data..." ?>')
				}				
			},
      loading: function(bool) {
				$('#calendar_loading').toggle(bool);

			}
      
		});
		
	});  
</script>


