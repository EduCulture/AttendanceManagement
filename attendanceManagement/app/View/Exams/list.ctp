<div class="col-sm-12">
     <?php if($exam_details) { ?>
         <?php foreach($exam_details as $exam_detail) { ?>
             <div class="box box-info box-solid">
                 <div class="box-header with-border">
                     <h3 class="box-title">Exam Category : <?php echo $exam_detail['exam_category']; ?></h3>
                     <?php
                        $valid = false;
                        if(CakeSession::read("Auth.User.role_id") == 2 && !$exam_detail['is_available']) {
                            $valid = true;
                        }else if(CakeSession::read("Auth.User.role_id") == 3 && $exam_detail['is_available']) {
                            $valid = true;
                        }
                     ?>

                     <?php if($valid) { ?>
                         <div class="pull-right">
                             <a class="btn btn-flat btn-success btn-xs" id="create-exam" href="#" title="Create Exam"><i class="fa fa-plus-square"></i> <span class="hidden-xs">Create Exam</span></a>
                         </div>
                     <?php } ?>
                 </div>

                 <div class="box-body no-padding table-responsive">
                     <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                               <th class="text-center">#</th>
                               <th class="text-center">Exam Name</th>
                               <?php if(CakeSession::read("Auth.User.role_id") == 3) { ?>
                                  <th class="text-center">Manage Exam</th>
                               <?php } ?>
                               <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                           <?php if($exam_detail['exams']) { ?>
                               <?php $i=0; ?>
                               <?php foreach($exam_detail['exams'] as $exam) { ?>
                                  <tr>
                                     <td class="text-center"><?php echo ++$i; ?></td>
                                     <td class="text-center"><?php echo $exam['Exam']['name']; ?></td>
                                     <?php if(CakeSession::read("Auth.User.role_id") == 3) { ?>
                                         <td class="text-center">
                                             <?php echo $this->Html->link('<i class="fa fa-cogs"></i> Add Subjects',array('controller' => 'exams','action' => 'manage','?' => array('exam_id' => $exam['Exam']['id'])),array('escape' => false ,'data-original-title' => 'Manage Exam','data-toggle' => 'tooltip')); ?>
                                         </td>
                                     <?php } ?>
                                     <td class="text-center">
                                         <a class="btn btn-primary btn-sm edit-exam" href="javascript:void(0)" ><i class="fa fa-edit"></i></a>
                                     </td>
                                     <input type="hidden" name="exam_id" value="<?php echo $exam['Exam']['id']; ?>" />
                                     <input type="hidden" name="exam_name" value="<?php echo $exam['Exam']['name']; ?>" />
                                     <input type="hidden" name="exam_type" value="<?php echo $exam['ExamType']['id']; ?>" />
                                  </tr>
                               <?php } ?>
                           <?php } else { ?>
                              <tr>
                                  <td colspan="7" class="text-center"> No Exams Available</td>
                              </tr>
                           <?php } ?>
                        </tbody>
                     </table>
                 </div>
             </div>
         <?php } ?>
     <?php } ?>
</div>



<!-- Modal Popup -->
<div class="modal fade" id="modal-exam" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
           <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"> </h4>
           </div>
           <div class="modal-body">
              <form class="form-horizontal">
                  <div class="form-group required">
                      <label for="input-parent" class="col-sm-4 control-label">Exam Name</label>
                      <div class="col-sm-8">
                          <input type="text" class="form-control" name="name" id="exam-name" />
                      </div>
                  </div>
                  <div class="form-group required">
                      <label for="input-parent" class="col-sm-4 control-label">Exam Type</label>
                      <div class="col-sm-8">
                          <select class="form-control" name="type" id="exam-type-dropdown">
                             <?php foreach($exam_types as $val) { ?>
                                <option value="<?php echo $val['ExamType']['id']; ?>"><?php echo $val['ExamType']['name']; ?></option>
                             <?php } ?>
                          </select>
                      </div>
                  </div>
                  <input type="hidden" id="exam-id" value="" />
              </form>
           </div>
           <div class="modal-footer">
              <button type="button" id="btn-exam-save" class="btn btn-primary"> Save</button>
           </div>
        </div>
    </div>
</div>

<script src="<?php echo $this->webroot; ?>js/datetimepicker/moment.js" type="text/javascript"></script>
<script src="<?php echo $this->webroot; ?>js/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<link href="<?php echo $this->webroot; ?>js/datetimepicker/bootstrap-datetimepicker.min.css" type="text/css" rel="stylesheet" media="screen" />

<script>

$('#create-exam').click(function() {
    $('.modal-title').html('<i class="fa fa-plus-square"></i> Add Exam');
    $('#modal-exam').modal('show');
});

$('.edit-exam').click(function(){

    $('.modal-title').html('<i class="fa fa-edit"></i> Edit Exam');
    //alert($(this).parent().parent().find('input[name="exam_id"]').val());return false;
    $('#exam-id').val($(this).parent().parent().find('input[name="exam_id"]').val());
    $('#exam-name').val($(this).parent().parent().find('input[name="exam_name"]').val());
    $('#exam-type-dropdown').val($(this).parent().parent().find('input[name="exam_type"]').val());

    $('#modal-exam').modal('show');
});

$('#btn-exam-save').click(function(){
    var $this = $(this);

    standard_id = '<?php echo $standard_id; ?>';
    section_id = '<?php echo $section_id; ?>';
    name = $('#exam-name').val();
    type = $('#exam-type-dropdown').val();
    exam_id = $('#exam-id').val();

    $('.text-danger,.alert-success').remove();

    $.ajax({
        url: '<?php echo $this->webroot;?>exams/save',
        type: 'post',
        //data : $('.modal-body input,.modal-body select'),
        data: {exam_id : exam_id, standard_id : standard_id, section_id : section_id, name : name, type : type},
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
                $('#modal-exam').modal('hide');
                window.location = '<?php echo $this->webroot."exams/index?standard_id=".$standard_id."&section_id=".$section_id; ?>';
            }else{
                if(response.error){
                    $.each(response.error, function(key,val) {
                        $('#exam-'+key).parent().append('<div class="text-danger">'+val+'</div>');
                    });
                }
            }
        }
    });
});
</script>