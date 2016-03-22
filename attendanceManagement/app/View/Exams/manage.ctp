<div class="page-header">
    <div class="container-fluid">
        <h1><i class="fa fa-th-list"></i> Manage Subject Wise Schedule</h1>
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
          <h4 class="page-header edusec-border-bottom-warning"><i class="fa fa-info-circle"></i> <?php echo $exam['Exam']['name']; ?></h4>
          <div class="table-responsive">
              <table class="table">
                  <colgroup>
                        <col class="col-xs-2">
                        <col class="col-xs-4">
                        <col class="col-xs-2">
                        <col class="col-xs-4">
                  </colgroup>
                  <tbody>
                      <tr>
                         <th>Exam Type</th>
                         <td><?php echo $exam['ExamType']['name']; ?></td>
                         <th>Academic Year</th>
                         <td>2015-16</td>
                      </tr>
                      <tr>
                         <th>Standard</th>
                         <td><?php echo $exam['Standard']['name']; ?></td>
                         <th>Section</th>
                         <td><?php echo $exam['Section']['name']; ?></td>
                      </tr>
                  </tbody>
              </table>
          </div>
    </div>


    <div class="box box-info">
         <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-bars"></i> Subject Wise Schedule Lists</h3>
         </div>
         <div class="box-body table-responsive">
            <table class="table table-bordered table-striped table-hover">
               <thead>
                   <tr>
                      <th class="text-center">Subject Name</th>
                      <th class="text-center">Maximum Marks</th>
                      <th class="text-center">Passing Marks</th>
                      <th class="text-center">Date</th>
                   </tr>
               </thead>
               <tbody>

                  <?php if($remainings) { ?>
                      <form id="form-detail" class="form-horizontal" method="post" action="<?php echo $this->webroot .  'exams/saveDetails'; ?>" enctype="multipart/form-data">
                          <?php $i=0; ?>
                          <input type="hidden" name="exam_id" value="<?php echo $exam_id; ?>" />
                          <?php foreach($remainings as $remaining) { ?>
                             <tr>
                                <td class="text-center"><?php echo $remaining['subject_name']; ?></td>
                                <td class="text-center">
                                    <input type="text" class="form-control" name="details[<?php echo $remaining['subject_id']; ?>][maximum_mark]" size="3" maxlength="3" onchange="checkmax_marks(this.value,this.id)">
                                </td>
                                <td class="text-center">
                                    <input type="text" class="form-control" name="details[<?php echo $remaining['subject_id']; ?>][minimum_mark]" size="3" maxlength="3" onchange="checkmax_marks(this.value,this.id)">
                                </td>
                                <td>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <div class="input-group date">
                                                <span class="input-group-addon" title="Select date &amp; time">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                                <!--<span class="input-group-addon" title="Clear field">
                                                    <span class="glyphicon glyphicon-remove"></span>
                                                </span>-->
                                                <input type="text" class="form-control" name="details[<?php echo $remaining['subject_id']; ?>][start_time]" placeholder="Select Date">
                                            </div>
                                        </div>
                                    </div>
                                </td>
                             </tr>
                          <?php } ?>
                      </form>
                  <?php } else { ?>
                     <tr>
                         <td colspan="7" class="text-center"> No Subjects Available</td>
                     </tr>
                  <?php } ?>
               </tbody>
            </table>
         </div>
         <?php if($remainings) { ?>
             <div class="box-footer">
                <button onclick="$('#form-detail').submit();" class="btn btn-primary">Save</button>
                <button type="reset" class="btn btn-default">Reset</button>
             </div>
         <?php } ?>
    </div>

    <div class="box box-info">
         <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-list-ul"></i> Manage Scheduled Subject Lists</h3>
         </div>
         <div class="box-body table-responsive">
            <table class="table table-bordered table-striped table-hover">
               <thead>
                   <tr>
                      <th class="text-center">#</th>
                      <th class="text-center">Subject Name</th>
                      <th class="text-center">Date</th>
                      <th class="text-center">Maximum Marks</th>
                      <th class="text-center">Passing Marks</th>
                      <th class="text-center">Manage Result</th>
                      <th class="text-center">Action</th>
                   </tr>
               </thead>
               <tbody class="sucheduled-subjects">
                  <?php if($exam['ExamDetail']) { ?>
                      <?php $i=0; ?>
                      <?php foreach($exam['ExamDetail'] as $exam_detail) { ?>
                          <tr>
                              <td class="text-center"><?php echo ++$i; ?></td>
                              <td class="text-center"><?php echo $exam_detail['Subject']['name']; ?></td>
                              <td class="text-center"><?php echo date("d-M-Y",strtotime($exam_detail['start_time'])); ?></td>
                              <td class="text-center"><?php echo $exam_detail['maximum_mark']; ?></td>
                              <td class="text-center"><?php echo $exam_detail['passing_mark']; ?></td>
                              <td class="text-center">
                                  <?php echo $this->Html->link('<i class="fa fa-cogs"></i>',array('controller' => 'exams','action' => 'result','?' => array('exam_detail_id' => $exam_detail['id'])),array('escape' => false ,'data-original-title' => 'Manage Result','data-toggle' => 'tooltip')); ?>
                              </td>
                              <td class="text-center">
                                  <a class="btn btn-primary btn-sm edit-schedule" href="javascript:void(0)" ><i class="fa fa-edit"></i></a>
                                  <a class="btn btn-danger btn-sm delete-schedule" href="javascript:void(0)" ><i class="fa fa-trash"></i></a>
                              </td>
                              <input type="hidden" name="hidden_subject_id" value="<?php echo $exam_detail['Subject']['id']; ?>" />
                              <input type="hidden" name="hidden_subject_name" value="<?php echo $exam_detail['Subject']['name']; ?>" />
                              <input type="hidden" name="hidden_start_time" value="<?php echo $exam_detail['start_time']; ?>" />
                              <input type="hidden" name="hidden_maximum_mark" value="<?php echo $exam_detail['maximum_mark']; ?>" />
                              <input type="hidden" name="hidden_passing_mark" value="<?php echo $exam_detail['passing_mark']; ?>" />
                              <input type="hidden" name="hidden_schedule_id" value="<?php echo $exam_detail['id']; ?>" />
                          </tr>
                      <?php } ?>
                  <?php } else { ?>
                     <tr>
                          <td colspan="8" class="text-center"> No Scheduled Subjects Available</td>
                     </tr>
                  <?php } ?>
               </tbody>
            </table>
         </div>
    </div>
</div>

<div class="panel panel-body"></div>

<!-- Modal Popup -->
<div class="modal fade" id="modal-schedule" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
           <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><i class="fa fa-edit"></i> Update Subject Schedule Details</h4>
           </div>
           <div class="modal-body">
              <form class="form-horizontal">
                  <div class="well well-sm">
                  		<strong id="modal-subject"> </strong>
                  </div>

                  <div class="row">
                     <div class="col-sm-12">
                         <div class="col-sm-5">
                             <div class="form-group">
                                 <label class="control-label" for="max-mark">Maximum Marks</label>
                                 <input type="text" id="modal-max" class="form-control" name="maximum_mark" value="" maxlength="10">
                             </div>
                         </div>
                         <div class="col-sm-5" style="margin-left:15px;">
                             <div class="form-group">
                                 <label class="control-label" for="max-mark">Passing Marks</label>
                                 <input type="text" id="modal-min" class="form-control" name="passing_mark" value="" maxlength="10">
                             </div>
                         </div>
                     </div>
                  </div>
                  <div class="row">
                       <div class="col-sm-12">
                            <div class="col-sm-5">
                                <div class="form-group">
                                  <label class="control-label" for="">Date</label>
                                  <div class="input-group date">
                                      <span class="input-group-addon" title="Select date &amp; time">
                                          <span class="glyphicon glyphicon-calendar"></span>
                                      </span>
                                      <input type="text" id="modal-start-time" class="form-control" name="start_time" placeholder="Select Date">
                                  </div>
                                  <div class="help-block"></div>
                              </div>
                          </div>
                       </div>
                  </div>

                  <input type="hidden" name="exam_id" value="<?php echo $exam_id; ?>" />
                  <input type="hidden" name="detail_id" id="schedule-id" value="" />
                  <input type="hidden" name="subject_id" id="modal-subject-id" value="" />
              </form>
           </div>
           <div class="modal-footer">
              <button type="button" id="btn-update-schedule" class="btn btn-primary"> Save</button>
           </div>
        </div>
    </div>
</div>


<script src="<?php echo $this->webroot; ?>js/datetimepicker/moment.js" type="text/javascript"></script>
<script src="<?php echo $this->webroot; ?>js/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<link href="<?php echo $this->webroot; ?>js/datetimepicker/bootstrap-datetimepicker.min.css" type="text/css" rel="stylesheet" media="screen" />



<script>
    mindate = new Date();
    $('.date').datetimepicker({
        minDate : mindate,
        pickTime: false,
    });

    $('.sucheduled-subjects').find('.btn-primary').click(function(){
        $('#modal-subject').html('Subject Name : ' + $(this).parent().parent().find('input[name="hidden_subject_name"]').val())
        $('#modal-start-time').val($(this).parent().parent().find('input[name="hidden_start_time"]').val());
        $('#modal-max').val($(this).parent().parent().find('input[name="hidden_maximum_mark"]').val());
        $('#modal-min').val($(this).parent().parent().find('input[name="hidden_passing_mark"]').val());
        $('#schedule-id').val($(this).parent().parent().find('input[name="hidden_schedule_id"]').val());
        $('#modal-subject-id').val($(this).parent().parent().find('input[name="hidden_subject_id"]').val());
        $('.date').datetimepicker({
            minDate : mindate,
            pickTime: false,
        });
        $('#modal-schedule').modal('show');
    });

    $('.sucheduled-subjects').find('.btn-danger').click(function(){
        if(confirm('Are you sure?')){
            detail_id = $(this).parent().parent().find('input[name="hidden_schedule_id"]').val();
            $.ajax({
                url: '<?php echo $this->webroot;?>exams/deleteSchedule',
                type: 'post',
                data : {detail_id : detail_id},
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    if (typeof response.success != 'undefined') {
                        $('#modal-schedule').modal('hide');
                        window.location = '<?php echo $this->webroot."exams/manage?exam_id=".$exam_id; ?>';
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
$('#btn-update-schedule').click(function(){
    var $this = $(this);

    $('.text-danger,.alert-success').remove();

    $.ajax({
        url: '<?php echo $this->webroot;?>exams/updateDetail',
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
                window.location = '<?php echo $this->webroot."exams/manage?exam_id=".$exam_id; ?>';
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