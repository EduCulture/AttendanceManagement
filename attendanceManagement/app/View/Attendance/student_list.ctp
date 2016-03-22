<div class="panel-body">
     <div class="row">
          <div class="col-sm-12">
                <div class="panel panel-default">
                   <div class="panel-heading">
                      <b><h3 class="panel-title"><i class="fa fa-bars"></i> Manage Student Attendance </h3></b>
                      <a class="btn btn-success btn-xs pull-right" title="" data-toggle="tooltip" href="<?php echo $this->webroot; ?>attendance/add?standard_id=<?php echo $standard_id; ?>&section_id=<?php echo $section_id; ?>&attendance_date=<?php echo $attendance_date; ?>" data-original-title="Take Attendance"><i class="fa fa-check-square-o"></i> Take Attendance</a>
                   </div>
                   <div class="table-responsive">
                       <table class="table table-bordered table-hover">
                           <thead>
                               <tr>
                                   <td class="text-center">#</td>
                                   <td class="text-left">Date</td>
                                   <td class="text-left">Student</td>
                                   <td class="text-left">Staff</td>
                                   <td class="text-center">Attendance</td>
                                   <td class="text-center">Absent Remark</td>
                                   <td class="text-right">Action</td>
                               </tr>
                           </thead>
                           <tbody>
                              <?php if($students) { ?>
                                <?php $i=1;?>
                                <?php foreach($students as $student) { ?>
                                    <tr>
                                        <td class="text-center"><?php echo $i; ?></td>
                                        <td class="text-left"><?php echo date("d-M-Y",strtotime($student['attendance_date'])); ?></td>
                                        <td class="text-left" id="col-name"><?php echo $student['student_name']; ?></td>
                                        <input type="hidden" name="hidden_student_id" value="<?php echo $student['student_id']; ?>" />
                                        <input type="hidden" name="hidden_attendance_id" value="<?php echo $student['attendance_id']; ?>" />
                                        <input type="hidden" name="hidden_attendance_remark" value="<?php echo $student['remark']; ?>" />
                                        <input type="hidden" name="hidden_attendance_date" value="<?php echo date("d-M-Y",strtotime($student['attendance_date'])); ?>" />
                                        <td class="text-left"><?php echo $student['staff_name']; ?></td>
                                        <td class="text-center"><?php echo ($student['attendance_status']) ? '<span class="label label-success">P</span>' : '<span class="label label-danger">A</span>'; ?></td>
                                        <td class="text-center"><?php echo ($student['remark']) ? $student['remark'] : '-'; ?></td>
                                        <td class="text-right">
                                            <a data-toggle="tooltip" data-original-title="Edit" class="btn btn-primary" href="javascript:void(0);"><i class="fa fa-pencil"></i></a>
                                        </td>
                                        <?php $i++; ?>
                                    <tr>
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
     </div>
</div>


<!-- Modal Popup -->
<div class="modal fade" id="add-remark" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-edit"> </i> Update Attendance</h4>
      </div>
      <div class="modal-body">
          <form class="form-horizontal">
              <div class="form-group">
                  <label for="input-parent" class="col-sm-3 control-label">Student Name</label>
                  <div class="col-sm-8">
                      <span id="student-name" readonly class="form-control"></span>
                      <input type="hidden" name="student_id" value="" id="student-id" />
                      <input type="hidden" name="attendance_id" value="" id="attendance-id" />
                  </div>
              </div>
              <div class="form-group">
                    <label for="input-parent" class="col-sm-3 control-label">Date</label>
                    <div class="col-sm-8">
                        <span id="attendance-date" readonly class="form-control"></span>
                    </div>
              </div>
              <div class="form-group">
                  <label for="input-parent" class="col-sm-3 control-label">Attendance</label>
                  <div class="col-sm-8">
                        <select class="form-control" name="attendance_status">
                            <option value="1">Present</option>
                            <option value="0">Absent</option>
                        </select>
                  </div>
              </div>
              <div class="form-group">
                  <label for="input-parent" class="col-sm-3 control-label">Absent Remarks</label>
                  <div class="col-sm-8">
                        <textarea name="remarks" id="remark" class="form-control"></textarea>
                  </div>
              </div>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary"><i class="fa fa-refresh"></i> Update</button>
      </div>
    </div>
  </div>
</div>

<script>
    $('tbody').find('.btn-primary').click(function(){
         $('#student-name').html(($(this).parent().parent().find('#col-name').html()));
         $('#student-id').val(($(this).parent().parent().find('input[name="hidden_student_id"]').val()));
         $('#attendance-id').val(($(this).parent().parent().find('input[name="hidden_attendance_id"]').val()));
         $('#attendance-date').html(($(this).parent().parent().find('input[name="hidden_attendance_date"]').val()));
         $('#remark').html(($(this).parent().parent().find('input[name="hidden_attendance_remark"]').val()));
         $('#add-remark').modal('show');
    });

    $('.modal-footer').find('.btn-primary').click(function(){
        var $this = $(this);
        $('.text-danger,.alert-success').remove();
        $.ajax({
            url: '<?php echo $this->webroot;?>attendance/update',
            type: 'post',
            data: $('.modal-body input,.modal-body textarea,.modal-body select'),
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
                    $('#add-remark').modal('hide');
                    window.location = '<?php echo $this->webroot."attendance"; ?>';
                }else{
                    $('#remark').parent().after().append('<div class="text-danger">'+response.error+'</div>');
                }
            }
        });
    });
</script>

