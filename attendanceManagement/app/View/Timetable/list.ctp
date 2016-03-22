<div class="col-sm-12">
  <div class="box box-info">
     <div class="box-header with-border">
        <h3 class="box-title"><i class="glyphicon glyphicon-calendar"></i> Timetable</h3>
        <div class="box-tools pull-right">
        	<a class="btn btn-flat btn-info" href="<?php echo $this->webroot.'timing'; ?>" title="Add Class Timing"><i class="fa fa-plus-square"></i> <span class="hidden-xs">Add Class Timing</span></a>
        </div>
     </div>
     <div class="box-body table-responsive">
        <table class="table table-bordered table-striped table-hover">
           <thead>
               <tr>
                  <th colspan="8" class="text-center" style="font-size:16px">Time Table of &nbsp<?php echo $standard['Standard']['name']; ?> : <?php echo $section['Section']['name']; ?></th>
               </tr>
               <tr>
                   <td class="text-center">Class Timing</td>
                   <?php foreach($days as $day) { ?>
                       <td class="text-center"><?php echo $day['Day']['name']; ?></td>
                   <?php } ?>
               </tr>
           </thead>
           <tbody>
              <?php if($timetable) { ?>
                  <?php foreach($timetable as $detail) { ?>
                     <tr>
                        <td data-title="Class" class="text-center"><?php echo $detail['time']; ?></td>
                        <?php if(!$detail['is_break']) { ?>
                            <?php foreach($days as $day) { ?>
                                <td class="text-center">
                                    <?php if($detail['days'][$day['Day']['name']]['subject']) { ?>
                                        <input type="hidden" name="time_table_id" value="<?php echo $detail['days'][$day['Day']['name']]['time_table_id']; ?>" / >
                                        <input type="hidden" name="assigned_subject_id" value="<?php echo $detail['days'][$day['Day']['name']]['subject']['id']; ?>" />
                                        <input type="hidden" name="assigned_staff_id" value="<?php echo $detail['days'][$day['Day']['name']]['staff']['id']; ?>" />

                                        <?php if(CakeSession::read("Auth.User.role_id") == 2) { ?>
                                            <a class="assigned_lec assignLecture" href="#" title=""  data-toggle="tooltip" style="font-size: 15px;font-weight: bold;line-height: 20px;" data-original-title="<?php echo $detail['days'][$day['Day']['name']]['staff']['name']; ?>"><?php echo $detail['days'][$day['Day']['name']]['subject']['name']; ?></a>
                                            <a class="lec_delete " href="#" onclick="deleteLec('<?php echo $detail['days'][$day['Day']['name']]['time_table_id']; ?>')" title="" data-toggle="tooltip" style="color:red;padding-left:5px;font-size:22px" data-confirm="Are you sure you want to delete this item?" data-method="post" data-original-title="Delete Lecture"><span class="glyphicon glyphicon-remove-circle"></span></a>
                                        <?php } else { ?>
                                            <?php echo $detail['days'][$day['Day']['name']]['subject']['name']; ?> (<?php echo $detail['days'][$day['Day']['name']]['staff']['name']; ?>)
                                        <?php } ?>
                                    <?php } else { ?>
                                        <input type="hidden" name="time_table_id" value="0" / >
                                        <?php if(CakeSession::read("Auth.User.role_id") == 2) { ?>
                                            <a class="text-green assignLecture" href="#" title="" style="font-size: 15px;font-weight: bold;" data-toggle="tooltip" data-link="/timetable/timetable-details/assign?tt_section_id=1&amp;weekday=1&amp;lec_time=2" data-original-title="Assign Lecture">Assign</a>
                                        <?php } else { ?>
                                            -
                                        <?php } ?>
                                    <?php } ?>
                                    <input type="hidden" name="day_id" value="<?php echo $day['Day']['id']; ?>" />
                                    <input type="hidden" name="time_id" value="<?php echo $detail['timing_id']; ?>" />
                                </td>
                            <?php } ?>
                        <?php } else { ?>
                            <td colspan="7" class="text-red text-center" data-title="Break"><span style="font-size: 20px;font-weight: bold;" title="" data-toggle="tooltip" data-original-title="Break"><?php echo $detail['name']; ?></span></td>
                        <?php } ?>
                     </tr>
                  <?php } ?>
              <?php } else { ?>
                 <tr>
                     <td colspan="8" class="text-center"> No Data Available</td>
                 </tr>
              <?php } ?>
           </tbody>
        </table>
     </div>
  </div>
</div>

<!-- Modal Popup -->
<div class="modal fade" id="modal-timetable" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
       <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"> </h4>
       </div>
       <div class="modal-body">
          <form class="form-horizontal">
              <div class="form-group required">
                  <label for="input-parent" class="col-sm-3 control-label">Subject</label>
                  <div class="col-sm-9">
                      <select class="form-control" name="subject_id" id="subject-dropdown" onchange="getStaff('<?php echo $standard_id; ?>','<?php echo $section_id; ?>',this.value)">
                           <?php if($subjects) { ?>
                               <option value="">---Select Subject---</option>
                               <?php foreach($subjects as $subject) { ?>
                                   <option value="<?php echo $subject['subject_id']; ?>"><?php echo $subject['subject']; ?></option>
                               <?php } ?>
                           <?php } ?>
                      </select>
                  </div>
              </div>
              <div class="form-group required">
                  <label for="input-parent" class="col-sm-3 control-label">Staff</label>
                  <div class="col-sm-9">
                      <select class="form-control" name="staff_id" id="staff-dropdown">
                         <option value="">---Select Staff---</option>
                      </select>
                  </div>
              </div>
              <input type="hidden" name="modal_day_id" id="modal-day-id" value="" />
              <input type="hidden" name="modal_time_id" id="modal-time-id" value="" />
              <input type="hidden" name="timetable_id" id="modal-timetable-id" value="" />
          </form>
       </div>
       <div class="modal-footer">
          <button type="button" id="btn-time-save" class="btn btn-primary"> Save</button>
       </div>
    </div>
  </div>
</div>

<script src="<?php echo $this->webroot; ?>js/datetimepicker/moment.js" type="text/javascript"></script>
<script src="<?php echo $this->webroot; ?>js/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<link href="<?php echo $this->webroot; ?>js/datetimepicker/bootstrap-datetimepicker.min.css" type="text/css" rel="stylesheet" media="screen" />

<script>

$('.assignLecture').click(function(){
    assign_staff_id = 0;
    $('#modal-day-id').val($(this).parent().find('input[name="day_id"]').val());
    $('#modal-time-id').val($(this).parent().find('input[name="time_id"]').val());
    $('#modal-timetable-id').val($(this).parent().find('input[name="time_table_id"]').val());
    if($(this).parent().find('input[name="time_table_id"]').val()){
        $('.modal-title').html('<i class="fa fa-calendar"></i> Edit Lecture');
        $('#subject-dropdown').val($(this).parent().find('input[name="assigned_subject_id"]').val());
        assign_staff_id = $(this).parent().find('input[name="assigned_staff_id"]').val();
        getStaff('<?php echo $standard_id; ?>','<?php echo $section_id; ?>',$(this).parent().find('input[name="assigned_subject_id"]').val())
    }else{
        $('.modal-title').html('<i class="fa fa-calendar"></i> Assign Lecture');
    }

    $('#modal-timetable').modal('show');
});

function getStaff(standard_id,section_id,subject_id){
    if(subject_id) {
        $.ajax({
            url: '<?php echo $this->webroot;?>standards/getSubjectTeacher',
            type: 'post',
            data: {standard_id : standard_id,section_id : section_id,subject_id:subject_id},
            dataType: 'json',
            /*beforeSend: function() {
                $this.prop('disabled',true).before('<i class="fa fa-spinner fa-2x fa-spin" style="margin-right:5px;"></i>');
            },
            complete: function() {
                $this.prop('disabled',false);
                $('.fa-spin').remove();
            },*/
            success: function (response) {
                if(response) {
                    html = '';
                    html += '<option value='+response.id+'>'+ response.name + '</option>';
                    $('#staff-dropdown').html(html);
                    if(assign_staff_id){
                        $('#staff-dropdown').val(assign_staff_id);
                    }
                }
            }
        });
    }
}

function deleteLec(id) {

    if(confirm('Are you sure?')) {
        $.ajax({
            url: '<?php echo $this->webroot;?>timetable/delete',
            type: 'post',
            data: {timetable_id : id},
            dataType: 'json',
            /*beforeSend: function() {
                $this.prop('disabled',true).before('<i class="fa fa-spinner fa-2x fa-spin" style="margin-right:5px;"></i>');
            },
            complete: function() {
                $this.prop('disabled',false);
                $('.fa-spin').remove();
            },*/
            success: function (response) {
                console.log(response);
                if (typeof response.success != 'undefined') {
                    window.location = '<?php echo $this->webroot."timetable/index?standard_id=".$standard_id."&section_id=".$section_id; ?>';
                }
            }
        });
    }
}

$('#btn-time-save').click(function(){
    var $this = $(this);

    /*standard_id = '<?php echo $standard_id; ?>';
    section_id = '<?php echo $section_id; ?>';
    subject_id = $('#subject-dropdown').val();
    staff_id = $('#staff-dropdown').val();*/

    $('.text-danger,.alert-success').remove();

    $.ajax({
        url: '<?php echo $this->webroot;?>timetable/save',
        type: 'post',
        data : $('.modal-body input,.modal-body select'),
        //data: {standard_id : standard_id,section_id : section_id, subject_id : subject_id,staff_id : staff_id},
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
                $('#modal-timetable').modal('hide');
                window.location = '<?php echo $this->webroot."timetable/index?standard_id=".$standard_id."&section_id=".$section_id; ?>';
            }else{
                if(response.error){
                    $.each(response.error, function(key,val) {
                        $('#'+key+'-dropdown').parent().append('<div class="text-danger">'+val+'</div>');
                    });
                }
            }
        }
    });
});
</script>