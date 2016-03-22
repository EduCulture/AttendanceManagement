<div class="page-header">
    <div class="container-fluid">
        <h1><i class="fa fa-line-chart"></i> Students Attendance</h1>
        <ul class="breadcrumb">
            <li>
                <?php echo $this->Html->link('Home',array('controller' => 'dashboard')); ?>
            </li>
            <li>
                <?php echo $this->Html->link('Students',array('controller' => 'attendance')); ?>
            </li>
        </ul>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
       <div class="col-md-12">

          <div class="box box-primary">
             <div class="box-body">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="input-name" class="control-label">To Date</label>
                            <div class="input-group date">
                               <input type="text" readonly class="form-control" id="input-to-date-available" data-format="DD-MM-YYYY" placeholder="Date" name="filter_date">
                               <span class="input-group-btn">
                                   <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                               </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="form-group col-sm-6">
                            <label for="input-name" class="control-label">From Date</label>
                            <div class="input-group date">
                               <input type="text" readonly class="form-control" id="input-from-date-available" data-format="DD-MM-YYYY" placeholder="Date" name="filter_date">
                               <span class="input-group-btn">
                                   <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                               </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                          <button onclick="getStudents();" class="btn btn-primary" title="" data-toggle="tooltip" type="button" data-original-title="Search"><i class="fa fa-search"></i> Search</button>
                    </div>
                </div>
             </div>
          </div>


          <div class="box box-warning" id="report-box" style="display:none;">
             <div class="box-header with-border">
                 <h4 class="box-title"><i class="fa fa-pie-chart"></i> Attendance Report</h4>
                 <div class="box-tools pull-right">
                     <button data-toggle="collapse" data-target="#graph-panel" class="btn btn-box-tool btn-xs"><i class="fa fa-minus"></i></button>
                 </div>
             </div>
             <div class="box-body" id="graph-panel">
                <div id="attendance-detail">
                </div>
             </div>
          </div>
       </div>
    </div>


    <?php /*
    <div class="box box-info box-solid">
        <div class="box-header with-border">
            <h4 class="box-title"><i class="fa fa-search"></i> Search Students</h4>
            <div class="box-tools pull-right">
                <button data-toggle="collapse" data-target="#serach-panel" style="background-color:#00c0ef;" class="btn btn-box-tool btn-xs"><i class="fa fa-minus"></i></button>
            </div>
        </div>

        <div id="serach-panel">
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group field-examresults-stu_id required">
                            <input type="text" id="search-student" class="form-control" name="search_student" placeholder="Enter Student Name" autocomplete="off">
                            <p class="help-block help-block-error"></p>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <strong class="text-info hint">
                            [HINT : Enter Student first name or last name]
                        </strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
    */ ?>

    <div id="append-div" style="display:none;">
        <div class="panel panel-default">
              <div class="panel-heading">
                  <h3 class="panel-title"><i class="fa fa-flag"></i> Student Attendance</h3>
              </div>
              <div class="panel-body">
                  <div id="calendar"></div>
              </div>

              <!--<div class="panel-footer">
                  <ul class="legend">
                      <li><span style="background-color:#00A65A"></span> Present</li>
                      <li><span style="background-color:#DD4B39"></span> Absent</li>
                  </ul>
              </div>-->
        </div>
    </div>

</div>


<link href="<?php echo $this->webroot; ?>js/calendar/fullcalendar.css" type="text/css" rel="stylesheet" media="screen" />
<script type="text/javascript" src="<?php echo $this->webroot; ?>js/calendar/moment.min.js"></script>
<script type="text/javascript" src="<?php echo $this->webroot; ?>js/calendar/fullcalendar.js"></script>
<script src="<?php echo $this->webroot; ?>js/datetimepicker/moment.js" type="text/javascript"></script>
<script src="<?php echo $this->webroot; ?>js/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<link href="<?php echo $this->webroot; ?>js/datetimepicker/bootstrap-datetimepicker.min.css" type="text/css" rel="stylesheet" media="screen" />

<script>

$('.date').datetimepicker({
    pickTime: false,
    maxDate:new Date()
});


$('input[name=\'search_student\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: '<?php echo $this->webroot.'students/getSuggestion'; ?>?filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
					    label: item['student_name'] + ' - ' + item['standard_name'] + ' ' + item['section_name'],
                        value: item['student_id'],
					}
				}));
			}
		});
	},
	'select': function(item) {

        //alert(item.standard_id);
	    $('input[name=\'search_student\']').val(item.label);
        $('#append-div').show();
        //$('#calendar').fullCalendar('removeEvents');
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
                   url: '<?php echo $this->webroot;?>attendance/getStudentAttendanceReport?student_id='+item.value,
                   type: 'GET',
                   success: function(response) {
                      var attendance_data = [];
                      if(response.length > 0){
                         for(i=0;i<response.length;i++){
                            if(response[i].status){
                                etitle = 'Present';
                            }else{
                                if(!response[i].remark){
                                    response[i].remark = 'N/A';
                                }
                                etitle = 'Absent \n\n' + 'Remark : ' +response[i].remark;
                            }
                            attendance_data.push({
                                event_id : response[i].attendance_id,
                                title:  etitle,
                                start: response[i].attendance_date,
                                end: response[i].attendance_date,
                                backgroundColor : response[i].backgroundColor,
                                textColor : '#ffffff'
                            });
                         }
                      }
                      return attendance_data;
                   }
                }
             ],
        });
	}
});


function getStudents() {
    to_date = $('#input-to-date-available').val();
    from_date = $('#input-from-date-available').val();
    if(to_date && from_date) {
        $.ajax({
            'url' : '<?php echo $this->webroot."Attendance/getReport"; ?>',
            'type' : 'post',
            'data' : {to_date : to_date,from_date : from_date},
            'dataType' : 'html',
            'success' : function(response){
                if(response){
                    $('#attendance-detail').html(response);
                    $('#report-box').show();
                }
            }
        });
    }
}

</script>