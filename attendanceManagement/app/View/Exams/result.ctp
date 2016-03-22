<div class="page-header">
    <div class="container-fluid">
        <h1><i class="fa fa-th-list"></i> Manage Subject Wise Result</h1>
        <ul class="breadcrumb">
            <li>
                <?php echo $this->Html->link('Home',array('controller' => 'dashboard')); ?>
            </li>
            <li>
                <?php echo $this->Html->link('Exam',array('controller' => 'exams','action' => 'index')); ?>
            </li>
        </ul>
    </div>
</div>

<div class="col-sm-12">
    <div class="well well-sm">
          <h4 class="page-header edusec-border-bottom-warning"><i class="fa fa-info-circle"></i> Subject Name : <?php echo $exam_details['subject']; ?></h4>
          <div class="table-responsive">
              <table class="table">
                  <colgroup>
                        <col class="col-xs-2">
                        <col class="col-xs-4">
                        <col class="col-xs-2">
                        <col class="col-xs-4">
                        <col class="col-xs-4">
                  </colgroup>
                  <tbody>
                      <tr>
                         <th>Exam Name</th>
                         <td><?php echo $exam_details['exam_name']; ?></td>
                         <th>Exam Type</th>
                         <td><?php echo ($exam_details['type']==1) ? 'Marks' : 'Grades'; ?></td>
                      </tr>
                      <tr>
                         <th>Standard</th>
                         <td><?php echo $exam_details['standard']; ?></td>
                         <th>Section</th>
                         <td><?php echo $exam_details['section']; ?></td>
                      </tr>
                      <tr>
                         <th>Maximum Mark</th>
                         <td><?php echo $exam_details['maximum_mark']; ?></td>
                         <th>Passing Mark</th>
                         <td><?php echo $exam_details['passing_mark']; ?></td>
                      </tr>
                      <tr>
                         <th>Date</th>
                         <td><?php echo date("d-M-Y",strtotime($exam_details['start_time'])); ?></td>
                      </tr>
                  </tbody>
              </table>
          </div>
    </div>


    <div class="box box-info">
         <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-bars"></i> Enter Student Marks</h3>
         </div>
         <div class="box-body table-responsive">
            <table class="table table-bordered table-striped table-hover">
               <thead>
                   <tr>
                      <th class="text-center">Roll Number</th>
                      <th class="text-center">Student Name</th>
                      <th class="text-center">Obtain Marks</th>
                      <th class="text-center">Remarks</th>
                   </tr>
               </thead>
               <tbody id="stu-form">
                  <?php if($students) { ?>
                      <form id="form-marks-detail" class="form-horizontal" method="post" action="<?php echo $this->webroot .  'exams/saveMarks'; ?>">
                          <input type="hidden" name="exam_detail_id" value="<?php echo $exam_detail_id; ?>" />
                          <?php foreach($students as $student) { ?>
                             <tr>
                                <td class="text-center"><?php echo $student['Student']['roll_number']; ?></td>
                                <td class="text-center"><?php echo $student['Student']['first_name']. " ".$student['Student']['last_name']; ?></td>
                                <td class="text-center"><input type="text" name="result[<?php echo $student['Student']['id']; ?>][obtain_mark]" class="form-control" /></td>
                                <td class="text-center"><input type="text" name="result[<?php echo $student['Student']['id']; ?>][remark]" class="form-control" /></td>
                             </tr>
                          <?php } ?>
                      </form>
                  <?php } else { ?>
                     <tr>
                         <td colspan="7" class="text-center"> No Students Available</td>
                     </tr>
                  <?php } ?>
               </tbody>
            </table>
         </div>
         <div class="box-footer">
            <button onclick="validateForm()" class="btn btn-primary">Save</button>
            <button type="reset" onclick="$('#stu-form').find('input').val('')" class="btn btn-default">Reset</button>
         </div>
    </div>

    <div class="box box-info">
         <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-list-ul"></i> Manage Student Marks</h3>
         </div>
         <div class="box-body table-responsive">
            <table class="table table-bordered table-striped table-hover">
               <thead>
                   <tr>
                      <th class="text-center">#</th>
                      <th class="text-center">Roll Number</th>
                      <th class="text-center">Student Name</th>
                      <th class="text-center">Total Marks</th>
                      <th class="text-center">Passing Marks</th>
                      <th class="text-center">Obtained Marks</th>
                      <th class="text-center">Grade</th>
                      <th class="text-center">Action</th>
                   </tr>
               </thead>
               <tbody class="assigned-marks">
                  <?php if($results['Result']) { ?>
                      <?php $i=0; ?>
                      <?php foreach($results['Result'] as $result) { ?>
                          <tr>
                              <td class="text-center"><?php echo ++$i; ?></td>
                              <td class="text-center"><?php echo $result['Student']['roll_number']; ?></td>
                              <td class="text-center"><?php echo $result['Student']['first_name']. ' '.$result['Student']['last_name']; ?></td>
                              <td class="text-center"><?php echo $results['ExamDetail']['maximum_mark']; ?></td>
                              <td class="text-center"><?php echo $results['ExamDetail']['passing_mark']; ?></td>
                              <td class="text-center"><?php echo $result['obtain_mark']; ?></td>
                              <td class="text-center">AA</td>
                              <td class="text-center">
                                  <a class="btn btn-primary btn-sm edit-schedule" href="javascript:void(0)" ><i class="fa fa-edit"></i></a>
                                  <a class="btn btn-danger btn-sm delete-schedule" href="javascript:void(0)" ><i class="fa fa-trash"></i></a>
                              </td>

                              <input type="hidden" name="hidden_result_id" value="<?php echo $result['id']; ?>" />
                              <input type="hidden" name="hidden_student_id" value="<?php echo $result['Student']['id']; ?>" />
                              <input type="hidden" name="hidden_student_name" value="<?php echo $result['Student']['first_name'].' '.$result['Student']['last_name']; ?>" />
                              <input type="hidden" name="hidden_obtain" value="<?php echo $result['obtain_mark']; ?>" />
                              <input type="hidden" name="hidden_remark" value="<?php echo $result['remark']; ?>" />
                          </tr>
                      <?php } ?>
                  <?php } else { ?>
                     <tr>
                          <td colspan="8" class="text-center"> No Students Marks Available</td>
                     </tr>
                  <?php } ?>
               </tbody>
            </table>
         </div>
    </div>
</div>

<div class="panel panel-body"></div>

<!-- Modal Popup -->
<div class="modal fade" id="modal-marks" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
           <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><i class="fa fa-edit"></i> Update Marks Details</h4>
           </div>
           <div class="modal-body">
              <form class="form-horizontal">
                  <div class="well well-sm">
                  		<strong id="modal-student-name"> </strong>
                  </div>

                  <div class="form-group required">
                      <label for="input-parent" class="col-sm-3 control-label">Obtained Marks</label>
                      <div class="col-sm-9">
                         <input name="obtain_mark" class="form-control" id="modal-obtain" placeholder="Obtain Mark" />
                      </div>
                  </div>

                  <div class="form-group">
                      <label for="input-parent" class="col-sm-3 control-label">Remark</label>
                      <div class="col-sm-9">
                           <input name="remark" class="form-control" id="modal-remark" placeholder="Remark" />
                      </div>
                  </div>

                  <input type="hidden" name="result_id" id="modal-result-id" value="" />
                  <?php /*
                    <input type="hidden" name="exam_detail_id" value="<?php echo $exam_detail_id; ?>" />
                    <input type="hidden" name="student_id" id="modal-student-id" value="" />
                  */ ?>
              </form>
           </div>
           <div class="modal-footer">
              <button type="button" id="btn-update-mark" class="btn btn-primary"> Save</button>
           </div>
        </div>
    </div>
</div>


<script src="<?php echo $this->webroot; ?>js/datetimepicker/moment.js" type="text/javascript"></script>
<script src="<?php echo $this->webroot; ?>js/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<link href="<?php echo $this->webroot; ?>js/datetimepicker/bootstrap-datetimepicker.min.css" type="text/css" rel="stylesheet" media="screen" />

<script>
    function validateForm() {

        /*$('#stu-form').find('input[type="text"]').each(function(index,item){
            if(((index%2) == 1)){
                alert($(this).val());
            }
        });*/
        $('#form-marks-detail').submit();
    }
</script>

<script>
    $('.assigned-marks').find('.btn-primary').click(function(){
        $('#modal-student-name').html('Student Name : ' + $(this).parent().parent().find('input[name="hidden_student_name"]').val())

        $('#modal-student-id').val($(this).parent().parent().find('input[name="hidden_student_id"]').val());
        $('#modal-obtain').val($(this).parent().parent().find('input[name="hidden_obtain"]').val());
        $('#modal-result-id').val($(this).parent().parent().find('input[name="hidden_result_id"]').val());
        $('#modal-remark').val($(this).parent().parent().find('input[name="hidden_remark"]').val());
        $('#modal-marks').modal('show');
    });

    $('.assigned-marks').find('.btn-danger').click(function(){
        if(confirm('Are you sure?')){
            result_id = $(this).parent().parent().find('input[name="hidden_result_id"]').val();
            $.ajax({
                url: '<?php echo $this->webroot;?>exams/deleteResult',
                type: 'post',
                data : {result_id : result_id},
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    if (typeof response.success != 'undefined') {
                        $('#modal-schedule').modal('hide');
                        window.location = '<?php echo $this->webroot."exams/result?exam_detail_id=".$exam_detail_id; ?>';
                    }else{
                        if(response.error){
                            $.each(response.error, function(key,val) {
                                $('#modal-'+key).parent().append('<div class="text-danger">'+val+'</div>');
                            });
                        }
                    }
                }
            });
        }
    });
</script>

<script>
$('#btn-update-mark').click(function(){
    var $this = $(this);

    $('.text-danger,.alert-success').remove();

    $.ajax({
        url: '<?php echo $this->webroot;?>exams/updateResult',
        type: 'post',
        data : $('.modal-body input'),
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
                $('#modal-schedule').modal('hide');
                window.location = '<?php echo $this->webroot."exams/result?exam_detail_id=".$exam_detail_id; ?>';
            }else{
                if(response.error){
                    $.each(response.error, function(key,val) {
                        $('#modal-'+key).parent().append('<div class="text-danger">'+val+'</div>');
                    });
                }
            }
        }
    });
});
</script>