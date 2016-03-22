<div class="page-header">
    <div class="container-fluid">
        <h1><i class="fa fa-check-square-o"></i> Take Attendance</h1>
        <ul class="breadcrumb">
            <li>
                <?php echo $this->Html->link('Home',array('controller' => 'dashboard')); ?>
            </li>
            <li>
                <?php echo $this->Html->link('Attendance',array('controller' => 'attendance','action' => 'index')); ?>
            </li>
        </ul>
    </div>
</div>

<?php echo $this->Session->flash(); ?>

<div class="col-sm-12">
    <div class="box box-info box-solid">
        <div class="box-header with-border">
            <h4 class="box-title"><i class="fa fa-search"></i> Search Students</h4>
            <div class="box-tools pull-right">
                <button data-toggle="collapse" data-target="#serach-panel" style="background-color:#00c0ef;" class="btn btn-box-tool btn-xs"><i class="fa fa-minus"></i></button>
            </div>
        </div>

        <div id="serach-panel">
            <div class="box-body">
                <form enctype="multipart/form-data" method="GET" id="attendance-search" action="<?php echo $this->webroot; ?>attendance/add">
                    <input type="hidden" name="standard_id" value="<?php echo $standard_id; ?>" />
                    <input type="hidden" name="section_id" value="<?php echo $section_id; ?>" />
                    <div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="input-name" class="control-label">Standard</label>
									<select name="filter_standard" onchange="getDivisions(this.value)" class="form-control" id="standard-dropdown">
										<option value="" selected="selected">---Please Select---</option>
									<?php foreach($standards as $standard) { ?>
										<option value="<?php echo $standard['id']; ?>"><?php echo $standard['name']; ?></option>
									<?php } ?>
									</select>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="input-price" class="control-label">Division</label>
							<select class="form-control" name="filter_division" onchange="getAssignments(this.value)" id="section-dropdown">

							</select>
						</div>
					</div>
            </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="input-name" class="control-label">Date</label>
                                <div class="input-group date">
                                    <input type="text" readonly class="form-control" id="input-date-available" data-format="DD-MM-YYYY" placeholder="Date" name="filter_date" value="<?php echo date("m-d-Y",strtotime($filter_date)); ?>">
                                    <span class="input-group-btn">
                                       <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <?php /*
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="input-name" class="control-label">Staff</label>
                                <select name="filter_staff" class="form-control" id="staff-dropdown">
                                   <option value="" selected="selected">---Please Select---</option>
                                   <?php foreach($staffs as $staff) { ?>
                                       <option value="<?php echo $staff['Staff']['id']; ?>"><?php echo $staff['Staff']['first_name'].' '.$staff['Staff']['last_name']; ?></option>
                                   <?php } ?>
                                </select>
                            </div>
                        </div>
                        */ ?>
                    </div>
                </form>
            </div>

            <div class="box-footer">
                <button onclick="$('#attendance-search').submit();" class="btn btn-primary" title="" data-toggle="tooltip" type="button" data-original-title="Search"><i class="fa fa-search"></i> Search</button>
                <?php echo $this->Html->link('Cancel',array('controller' => 'attendance','action' => 'index'),array('escape' => false,'data-original-title' => 'Cancel','data-toggle' => 'tooltip','class' => 'btn btn-danger')); ?>
            </div>
        </div>
    </div>

    <?php if($attendances) { ?>
          <div class="alert alert-warning" style="margin-left:20px;margin-right:20px;">
             <i class="fa fa-exclamation-circle"></i> Attendance is already taken for date : <?php echo date("d-M-Y",strtotime($filter_date)); ?> <button data-dismiss="alert" class="close" type="button">×</button>
          </div>
    <?php } ?>

    <div class="box box-info ">
       <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-users"></i> Students List</h3>
       </div>
       <div class="box-body table-responsive">
           <form enctype="multipart/form-data" method="post" action="<?php echo $this->webroot; ?>attendance/save">
                <div class="table-responsive">
                     <table class="table table-bordered table-striped table-hover" >
                         <thead>
                             <tr>
                                 <td class="text-center" style="width: 1px;"><input type="checkbox" id="parent-checkbox" checked="checked" onclick="$('input[name*=\'student\']').prop('checked', this.checked);"> </td>
                                 <?php if($attendances) { ?>
                                      <td class="text-center">Status</td>
                                      <td class="text-left">Staff</td>
                                 <?php } ?>
                                 <td class="text-left">Student</td>
                                 <td class="text-left">Roll Number</td>
                                 <td class="text-left" style="width:30%;">Absent Remark</td>
                             </tr>
                         </thead>
                         <tbody id="attendance-body">
                             <?php if(!$attendances) { ?>
                                <?php if($students) { ?>
                                    <?php $i=0; ?>
                                    <?php foreach($students as $student) { ?>
                                        <tr>
                                            <td class="text-center"><input type="checkbox" value="" selected="" name="student[<?php echo $i; ?>][attendance]"></td>
                                            <td class="text-left"><?php echo $student['Student']['first_name'] . ' '.$student['Student']['last_name']; ?></td>
                                            <td class="text-left"><?php echo $student['Student']['roll_number']; ?></td>
                                            <td class="text-left"><input type="text" name="student[<?php echo $i; ?>][remark]" class="form-control" /></td>
                                            <input type="hidden" value="<?php echo $student['Student']['id']; ?>" name="student[<?php echo $i; ?>][id]">
                                        <tr>
                                        <?php $i++; ?>
                                    <?php } ?>
                                    <input type="hidden" name="attendance_date" value="<?php echo $filter_date; ?>" />
                                    <tr>
                                        <td colspan="4">
                                              <button type="submit" class="btn btn-primary">Save</button>
                                        </td>
                                    <tr>
                                <?php } else { ?>
                                    <tr>
                                       <td colspan="8" class="text-center"> No Data Available</td>
                                    </tr>
                                <?php } ?>
                             <?php } else { ?>
                                <?php foreach($attendances as $attendance) { ?>
                                     <tr>
                                         <td class="text-center"><input type="checkbox" value="<?php echo $attendance['Student']['id']; ?>" <?php echo ($attendance['Attendance']['attendance_status']) ? 'checked="checked"' : ''; ?> ></td>
                                         <td class="text-center"><?php echo ($attendance['Attendance']['attendance_status']) ? '<span class="label label-success">P</span>' : '<span class="label label-danger">A</span>'; ?></td>
                                         <td class="text-left"><?php echo $attendance['Staff']['first_name'] . ' '.$attendance['Staff']['last_name']; ?></td>
                                         <td class="text-left"><?php echo $attendance['Student']['first_name'] . ' '.$attendance['Student']['last_name']; ?></td>
                                         <td class="text-left"><?php echo $attendance['Student']['roll_number']; ?></td>
                                         <td class="text-left"><?php echo ($attendance['Attendance']['remark']) ? $attendance['Attendance']['remark'] : '-'; ?></td>
                                     <tr>
                                <?php } ?>
                             <?php } ?>
                         </tbody>
                     </table>
                </div>
           </form>
       </div>
    </div>
 </div>

  <div class="panel-body">

  </div>

  <script src="<?php echo $this->webroot; ?>js/datetimepicker/moment.js" type="text/javascript"></script>
  <script src="<?php echo $this->webroot; ?>js/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
  <link href="<?php echo $this->webroot; ?>js/datetimepicker/bootstrap-datetimepicker.min.css" type="text/css" rel="stylesheet" media="screen" />

  <script>
  
	<?php if($standard_id) { ?>
        $('#standard-dropdown').val('<?php echo $standard_id; ?>');
        getDivisions('<?php echo $standard_id; ?>');
    <?php } ?>

    function getDivisions(standard_id){
	var html = '';
	html += '<option value="">---Please Select---</option>';
	$('#section-dropdown').html(html);
        if(standard_id) {
            $.ajax({
                'url' : '<?php echo $this->webroot."Standards/getDivisions"; ?>',
                'type' : 'post',
                'data' : {standard_id : standard_id},
                'dataType' : 'json',
                'success' : function(response){
                    if(response.length > 0){
                        var html = '';
                        html += '<option value="">---Please Select---</option>';
                        for(var i=0;i<response.length;i++) {
                            html += '<option value='+ response[i].section_id +'>' + response[i].section_name + '</option>';
                        }

                        $('#section-dropdown').html(html);
						
						<?php if($section_id) { ?>
                            $('#section-dropdown').val('<?php echo $section_id; ?>');
                        <?php } ?>
                    }
                }
            });
        }
    }
	
      $('.date').datetimepicker({
          pickTime: false,
          maxDate:new Date()
      });

      applyAttendance();

      $('#parent-checkbox').click(function() {
          applyAttendance();
      });

      function applyAttendance(){
          if($('#parent-checkbox').is(':checked')){
              $('input[name*=\'student\']').prop('checked', 'checked');
              $('#attendance-body').find('input[type="text"]').attr("disabled", "disabled");
          }else{
              $('input[name*=\'student\']').prop('checked', false);
              $('#attendance-body').find('input[type="text"]').removeAttr("disabled", "disabled");
          }
      }

      $('#attendance-body').find('input[type="checkbox"]').click(function() {
          if($(this).is(':checked')){
              $(this).parent().parent().find('input[type="text"]').attr("disabled", "disabled");
          }else{
              $(this).parent().parent().find('input[type="text"]').removeAttr("disabled", "disabled");
          }
      });
  </script>