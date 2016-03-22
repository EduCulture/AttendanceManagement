<div class="col-lg-7 col-md-12 col-sx-12 col-sm-12">
  <div class="panel panel-default">
      <div class="panel-heading">
          <h3 class="panel-title"><i class="fa fa-flag"></i> Events</h3>
      </div>
      <div class="panel-body">
          <div id="calendar"></div>
      </div>
      <div class="panel-footer">
         <?php if($event_types) { ?>
            <ul class="legend">
            <?php foreach($event_types as $event_type) { ?>
                <li><span style="background-color:<?php echo $event_type['EventType']['color_code']; ?>"></span> <?php echo $event_type['EventType']['name']; ?></li>
            <?php } ?>
            </ul>
         <?php } ?>
      </div>
  </div>
</div>

<link href="<?php echo $this->webroot; ?>js/calendar/fullcalendar.css" type="text/css" rel="stylesheet" media="screen" />
<script type="text/javascript" src="<?php echo $this->webroot; ?>js/calendar/moment.min.js"></script>
<script type="text/javascript" src="<?php echo $this->webroot; ?>js/calendar/fullcalendar.js"></script>

<script>
$('#calendar').fullCalendar({
     header: {
        left: 'prev,next today myCustomButton',
        center: 'title',
        right: 'month,agendaWeek,agendaDay'
     },
     //editable: true,
     dayClick: function(date, jsEvent, view) {

     },
     disableDragging: true,
     eventSources : [
        {
           url: '<?php echo $this->webroot;?>events/getEvents',
           type: 'GET',
           success: function(response) {
              var event_data = [];
              if(response.length > 0){
                 for(i=0;i<response.length;i++){
                    event_data.push({
                        event_id : response[i].event_id,
                        title: response[i].tittle,
                        start: response[i].start,
                        event_type : response[i].event_type,
                        description: response[i].description,
                        backgroundColor : response[i].backgroundColor,
                        textColor : response[i].textColor
                    });
                 }
              }
              return event_data;
           }
        }
     ],
     "eventRender": function (event, element) {
     	  var start_time = moment(event.start).format("DD-MM-YYYY, hh:mm:ss a");
     	  var end_time = moment(event.end).format("DD-MM-YYYY, hh:mm:ss a");
          element.popover({
                title: "<b class='text-green'>" + event.title + "</b>",
                placement: function (context, source) {
                   var position = $(source).position();
                   if (position.left > 320) {
                      return "auto left";
                   }
                   if (position.left < 320 && position.left > 100) {
                      return "auto right";
                   }
                   if (position.top < 110){
                      return "auto bottom";
                   }
                   return "top";
                },
                html: true,
                global_close: true,
                container: 'body',
                trigger: 'hover',
                delay: {"show": 500},
                content: "<table class='table'><tr><th>Event Detail : </th><td>" + event.description + " </td></tr><tr><th> Event Type : </th><td>" + event.event_type + "</td></tr><tr><th> Date : </t><td>" + start_time + "</td></tr></table>"
          });
     },
});
</script>