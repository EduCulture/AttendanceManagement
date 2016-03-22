<div class="page-header">
    <div class="container-fluid">
        <h1><i class="fa fa-flag"></i> Events</h1>
        <ul class="breadcrumb">
            <li>
                <?php echo $this->Html->link('Home',array('controller' => 'dashboard')); ?>
            </li>
            <li>
                <?php echo $this->Html->link('Events',array('controller' => 'events')); ?>
            </li>
        </ul>
        <?php /*
        <div class="pull-right">
           <?php echo $this->Html->link('<i class="fa fa-plus"></i>',array('controller' => 'events','action' => 'add'),array('escape' => false,'data-original-title' => 'Add New','data-toggle' => 'tooltip','class' => 'btn btn-primary')); ?>
           <button onclick="confirm('Delete/Uninstall cannot be undone! Are you sure you want to do this?') ? $('#event-list').submit() : false;" class="btn btn-danger" title="" data-toggle="tooltip" type="button" data-original-title="Delete"><i class="fa fa-trash-o"></i></button>
        </div>
        */ ?>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-plus-square"></i> Create Event Type</h3>
                </div>
                <div class="panel-body">
                    <form role="form" id="event-type-form" method="post" action="<?php echo $this->webroot . 'events/addEventType'; ?>" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="email">Event Type <span style="color:red">*</span></label>
                            <input type="text" class="form-control" id="event-type" name="name">
                        </div>
                        <div class="form-group">
                            <label for="email">Color Code <span style="color:red">*</span></label>
                            <div class="input-group">
                               <span class="input-group-sp input-group-addon">
                                    <input type="color" id="select-color" style="height:20px;width:34px;">
                               </span>
                               <input type="text" name="color_code" id="color-code" readonly class="form-control" />
                             </div>
                        </div>
                        <div class="form-group">
                            <button id="add-event-type" class="btn btn-primary"><i class="fa fa-plus"></i> Create</button>
                        	<button type="reset" class="btn btn-default btn-create" id="reset"><i class="fa fa-undo"></i> Reset</button>
                        </div>
                    </form>
                </div>
            </div>


            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-th-list"></i> Manage Event Type</h3>
                </div>
                <div class="panel-body" id="manage-event-body">
                    <?php if($event_types) { ?>
                        <?php foreach($event_types as $event_type) { ?>
                            <div class="external-event" style="background-color:<?php echo $event_type['EventType']['color_code']; ?>;  cursor: auto;">
                                <a href="#" title="Click name to Edit" onclick="js:UpdateEventType(<?php echo $event_type['EventType']['id']; ?>);" style="color:#FFF;"><?php echo $event_type['EventType']['name']; ?></a>
                                <a class="label label-danger pull-right" href="#" onclick="deleteEventType(<?php echo $event_type['EventType']['id']; ?>)" title="Remove/Delete Event type" style="font-size: 13px;"><i class="fa fa-trash-o"></i></a>
                            </div>
                        <?php } ?>
                    <?php } else { ?>
                        <div class="text-center">
                            <span>No Event Type Available</span>
                        </div>
                    <?php } ?>
                </div>
            </div>

        </div>
        <div class="col-sm-9">
            <div class="panel-body">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Popup - Delete Event Type-->
<div class="modal fade" id="deleteEventType" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel"> Are You Sure?</h4>
          </div>
          <input type="hidden" name="event_category_type" value="" />
          <div class="modal-footer">
              <button type="button" id="confirm-btn" class="btn btn-primary"> Yes</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
          </div>
        </div>
    </div>
</div>

<!-- Modal Popup - Add Event-->
<div class="modal fade bs-example-modal-lg" id="add-event" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus-square"> </i> Add Event</h4>
      </div>
      <div class="modal-body">
          <form class="form-horizontal">
              <div class="form-group required">
                  <label for="input-parent" class="col-sm-3 control-label">Name</label>
                  <div class="col-sm-9">
                      <input type="text" name="tittle" id="input-tittle" class="form-control" placeholder="Event tittle" value="" />
                  </div>
              </div>

              <div class="form-group required">
                    <label for="input-parent" class="col-sm-3 control-label">Description</label>
                    <div class="col-sm-9">
                        <textarea name="description"  class="form-control" id="input-description" placeholder="Description"></textarea>
                    </div>
              </div>

              <div class="form-group required">
                    <label for="input-parent" class="col-sm-3 control-label">Event Date</label>
                    <div class="col-sm-9">
                       <div class="input-group date">
                           <input type="text" readonly class="form-control" id="input-event-date" data-format="DD-MM-YYYY" placeholder="Event Date" name="event_date" value="">
                           <span class="input-group-btn">
                               <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                           </span>
                       </div>
                    </div>
              </div>

              <div class="form-group required">
                   <label for="input-parent" class="col-sm-3 control-label">Event Type</label>
                   <div class="col-sm-9">
                       <select class="form-control" name="event_type" id="input-type-id">
                           <?php foreach($event_types as $event_type) { ?>
                              <option value="<?php echo $event_type['EventType']['id']; ?>"><?php echo $event_type['EventType']['name']; ?></option>
                           <?php } ?>
                       </select>
                   </div>
              </div>
          </form>
      </div>
      <div class="modal-footer" id="add-footer">
        <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Add</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Popup - Update Event-->
<div class="modal fade bs-example-modal-lg" id="update-event" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-edit"> </i> Update Event</h4>
      </div>
      <div class="modal-body">
          <form class="form-horizontal">
              <div class="form-group" style="margin-right:10px;">
                 <button type="button" id="btn-event-delete" class="btn btn-danger pull-right"><i class="fa fa-trash-o"></i> Delete</button>
              </div>
              <div class="form-group required">
                  <label for="input-parent" class="col-sm-3 control-label">Name</label>
                  <div class="col-sm-9">
                      <input type="text" name="tittle" id="update-tittle" class="form-control" placeholder="Event tittle" value="" />
                  </div>
              </div>

              <div class="form-group required">
                    <label for="input-parent" class="col-sm-3 control-label">Description</label>
                    <div class="col-sm-9">
                        <textarea name="description"  class="form-control" id="update-description" placeholder="Description"></textarea>
                    </div>
              </div>

              <input type="hidden" name="event_id" id="update-event-id" />

              <div class="form-group required">
                    <label for="input-parent" class="col-sm-3 control-label">Event Date</label>
                    <div class="col-sm-9">
                       <div class="input-group date">
                           <input type="text" readonly class="form-control" id="update-event-date" data-format="DD-MM-YYYY" placeholder="Event Date" name="event_date" value="">
                           <span class="input-group-btn">
                               <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                           </span>
                       </div>
                    </div>
              </div>

              <div class="form-group required">
                   <label for="input-parent" class="col-sm-3 control-label">Event Type</label>
                   <div class="col-sm-9">
                       <select class="form-control" name="event_type" id="update-event-type">
                           <?php foreach($event_types as $event_type) { ?>
                              <option value="<?php echo $event_type['EventType']['id']; ?>"><?php echo $event_type['EventType']['name']; ?></option>
                           <?php } ?>
                       </select>
                   </div>
              </div>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="btn-event-update" class="btn btn-primary"><i class="fa fa-reload"></i> Edit</button>
      </div>
    </div>
  </div>
</div>


<link href="<?php echo $this->webroot; ?>js/summernote/summernote.css" rel="stylesheet" />
<script src="<?php echo $this->webroot; ?>js/summernote/summernote.js" type="text/javascript"></script>
<script src="<?php echo $this->webroot; ?>js/datetimepicker/moment.js" type="text/javascript"></script>
<script src="<?php echo $this->webroot; ?>js/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<link href="<?php echo $this->webroot; ?>js/datetimepicker/bootstrap-datetimepicker.min.css" type="text/css" rel="stylesheet" media="screen" />

<link href="<?php echo $this->webroot; ?>js/calendar/fullcalendar.css" type="text/css" rel="stylesheet" media="screen" />
<script type="text/javascript" src="<?php echo $this->webroot; ?>js/calendar/moment.min.js"></script>
<script type="text/javascript" src="<?php echo $this->webroot; ?>js/calendar/fullcalendar.js"></script>

<script>
$('#select-color').on('input', function() {
    $('#color-code').val(this.value);
});

$('#reset').click(function(){
    $('#event-type').val('');
    $('#color-code').val('');
});

$('#add-event-type').click(function(e) {
    e.preventDefault();
    event_type_name = $('#event-type').val();
    color_code = $('#color-code').val();
    error = 0;

    if(event_type_name.trim().length <= 0) {
        $('#event-type').parent().append('<div class="text-danger">Event Type Required</div>')
        error++;
    }
    if(color_code.trim().length <= 0) {
        $('#color-code').parent().parent().append('<div class="text-danger">Color Required</div>')
        error++;
    }

    if(error==0){
        $('#event-type-form').submit();
    }
});


$('#calendar').fullCalendar({
     header: {
        left: 'prev,next today myCustomButton',
        center: 'title',
        right: 'month,agendaWeek,agendaDay'
     },
     //editable: true,
     dayClick: function(date, jsEvent, view) {
          $('.date').datetimepicker({
              pickTime: false,
          });

          $('#input-description').summernote({
                height: 170
          });
          $('#input-event-date').val(date.format());
          $('#add-event').modal('show');

          //$(this).css('background-color', '#e1fdff');
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
     eventClick: function(event, element) {

         $('#update-description').val(event.description);
         $('#update-description').summernote({
             height: 170
         });
         $('.date').datetimepicker({
             pickTime: false,
             minDate:new Date()
         });

         $('#update-tittle').val(event.title);

         $('#update-event-date').val(event.start.format());
         $('#update-event-id').val(event.event_id);
         $('#update-event').modal('show');

         //event.title = "CLICKED!";

         //$('#calendar').fullCalendar('updateEvent', event);
     }
});



//update event
$('#btn-event-update').click(function(){
    var $this = $(this);

    description = $("#update-description").code();
    tittle = $('#update-tittle').val();
    event_date = $('#update-event-date').val();
    event_type_id = $('#update-event-type').val();
    event_id = $('#update-event-id').val();
    $('.text-danger,.alert-success').remove();

    $.ajax({
        url: '<?php echo $this->webroot;?>events/edit',
        type: 'post',
        data: {event_id : event_id,tittle : tittle,event_date:event_date,event_type_id:event_type_id,description:description},
        dataType: 'json',
        beforeSend: function() {
            $this.prop('disabled',true).before('<i class="fa fa-spinner fa-2x fa-spin" style="margin-right:5px;"></i>');
        },
        complete: function() {
            $this.prop('disabled',false);
            $('.fa-spin').remove();
        },
        success: function (response) {
            console.log(response);
            if (typeof response.success != 'undefined') {
                $('#update-event').modal('hide');
                window.location = '<?php echo $this->webroot."events/index"; ?>';
            }else{
                if(response.error){
                    $.each(response.error, function(key,val) {
                       $('#update-'+key).parent().append('<div class="text-danger">'+val+'</div>');
                    });
                }
            }
        }
    });
});

$('#btn-event-delete').click(function(){
    if(confirm('Delete/Uninstall cannot be undone! Are you sure you want to do this?')){
        event_id = $('#update-event-id').val();
        var $this = $(this);
        $.ajax({
            url: '<?php echo $this->webroot;?>events/delete',
            type: 'post',
            data: {event_id : event_id},
            dataType: 'json',
            beforeSend: function() {
                $this.prop('disabled',true).before('<i class="fa fa-spinner fa-2x fa-spin" style="margin-right:5px;"></i>');
            },
            complete: function() {
                $this.prop('disabled',false);
                $('.fa-spin').remove();
            },
            success: function (response) {
                console.log(response);
                if (typeof response.success != 'undefined') {
                    $('#update-event').modal('hide');
                    window.location = '<?php echo $this->webroot."events/index"; ?>';
                }else{
                    if(response.error){
                        alert(response.error);
                    }
                }
            }
        });
    }
});

//add event
$('#add-footer').find('.btn-primary').click(function(){
    var $this = $(this);
    $('.text-danger,.alert-success').remove();
    description = $("#input-description").code();
    tittle = $('#input-tittle').val();
    event_date = $('#input-event-date').val();
    event_type_id = $('#input-type-id').val();

    $.ajax({
        url: '<?php echo $this->webroot;?>events/add',
        type: 'post',
        data: {tittle : tittle,event_date:event_date,event_type_id:event_type_id,description:description},
        dataType: 'json',
        beforeSend: function() {
            $this.prop('disabled',true).before('<i class="fa fa-spinner fa-2x fa-spin" style="margin-right:5px;"></i>');
        },
        complete: function() {
            $this.prop('disabled',false);
            $('.fa-spin').remove();
        },
        success: function (response) {
            console.log(response);
            if (typeof response.success != 'undefined') {
                $('#add-event').modal('hide');
                window.location = '<?php echo $this->webroot."events/index"; ?>';
            }else{
                if(response.error){
                    $.each(response.error, function(key,val) {
                       if(key=='event-date'){
                          $('#input-'+key).parent().parent().append('<div class="text-danger">'+val+'</div>');
                       }else{
                          $('#input-'+key).parent().append('<div class="text-danger">'+val+'</div>');
                       }
                    });
                }
            }
        }
    });
});

function deleteEventType(id){
    $('#deleteEventType').modal('show');
    $('#deleteEventType').find('input[name="event_category_type"]').val(id);
}

$('#confirm-btn').click(function(){
    $this = $('#confirm-btn');
    $.ajax({
        url: '<?php echo $this->webroot;?>events/deleteEventType',
        type: 'post',
        data: $('#deleteEventType input'),
        dataType: 'json',
        beforeSend: function() {
            $this.prop('disabled',true).before('<i class="fa fa-spinner fa-2x fa-spin" style="margin-right:5px;"></i>');
        },
        complete: function() {
            $this.prop('disabled',false);
            $('.fa-spin').remove();
        },
        success: function (response) {
            $('#deleteEventType').modal('hide');
            window.location = '<?php echo $this->webroot."events/index"; ?>';
        }
    });
});

function UpdateEventType(id){


}

</script>