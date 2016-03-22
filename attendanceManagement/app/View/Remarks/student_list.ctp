<div class="panel-body">
     <div class="row">
          <div class="col-sm-12">
               <div class="panel panel-default">
                   <div class="panel-heading">
                      <b><h3 class="panel-title"><i class="fa fa-users"></i> Student List</h3></b>
                   </div>
                   <div class="table-responsive">
                       <table class="table table-bordered table-hover">
                           <thead>
                               <tr>
                                   <td class="text-center">Image</td>
                                   <td class="text-left">Name</td>
                                   <td class="text-left">Standard</td>
                                   <td class="text-left">Roll Number</td>
                                   <td class="text-left">Gender</td>
                                   <td class="text-left">Contact Number</td>
                                   <td class="text-right">Action</td>
                               </tr>
                           </thead>
                           <tbody>
                               <?php if($students) { ?>
                                   <?php foreach($students as $student) { ?>
                                       <tr>
                                           <td class="text-center">
                                              <?php if($student['Student']['profile_pic']) { ?>
                                                 <a href="<?php echo $student['Student']['profile_pic']; ?>" data-lightbox="roadtrip">
                                                    <img class="img-thumbnail" width="50" height="50" alt="<?php echo $student['Student']['first_name']; ?>" src="<?php echo $this->webroot.$student['Student']['profile_pic']; ?>">
                                                 </a>
                                              <?php } else { ?>
                                                  <img class="img-thumbnail" width="40" height="40" alt="<?php echo $student['Student']['first_name']; ?>" src="<?php echo $this->webroot; ?>images/no_image.jpg">
                                              <?php } ?>
                                           </td>
                                           <input type="hidden" name="student_id" value="<?php echo $student['Student']['id']; ?>" />
                                           <td class="text-left" id="col-name"><?php echo ($student['Student']['first_name'].' '.$student['Student']['last_name']); ?></td>
                                           <td class="text-left"><?php echo $student['Standard']['name'] . ' - '.$student['Section']['name']; ?></td>
                                           <td class="text-left"><?php echo $student['Student']['roll_number']; ?></td>
                                           <td class="text-left">
                                                 <?php if($student['Student']['gender']) { ?>
                                                   <span class="label label-success">Male</span>
                                                 <?php } else { ?>
                                                   <span class="label label-warning">Female</span>
                                                 <?php } ?>
                                           </td>
                                           <td class="text-left"><?php echo $student['Student']['contact_number']; ?></td>
                                           <td class="text-right">
                                              <a data-toggle="tooltip" data-original-title="Add Remark" class="btn btn-primary" href="javascript:void(0);"><i class="fa fa-pencil"></i> Add</a>
                                              <a data-toggle="tooltip" data-original-title="View Remarks" class="btn btn-success" href="javascript:void(0);"><i class="fa fa-eye"></i> View</a>
                                           </td>
                                       </tr>
                                   <?php } ?>
                               <?php } else { ?>
                                    <tr>
                                        <td class="text-center" colspan="7">No Records Found</td>
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
            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-edit"> </i> Add Remark</h4>
          </div>
          <div class="modal-body">
              <form class="form-horizontal">
                  <div class="form-group">
                      <label for="input-parent" class="col-sm-3 control-label">Student Name</label>
                      <div class="col-sm-8">
                          <span id="student-name" class="form-control"></span>
                          <input type="hidden" name="student_id" value="" id="student-id" />
                      </div>
                  </div>
                  <div class="form-group">
                        <label for="input-parent" class="col-sm-3 control-label">Title</label>
                        <div class="col-sm-8">
                              <input type="text" name="title" id="title" class="form-control" />
                        </div>
                  </div>
                  <div class="form-group">
                      <label for="input-parent" class="col-sm-3 control-label">Remarks</label>
                      <div class="col-sm-8">
                            <textarea name="remarks" id="remark" class="form-control"></textarea>
                      </div>
                  </div>
              </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Add</button>
          </div>
      </div>
  </div>
</div>

<div class="modal fade" id="view-remark" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-comments"></i> Remarks History</h4>
          </div>
          <div class="modal-body">

          </div>
      </div>
  </div>
</div>

<script>
    $('tbody').find('.btn-primary').click(function(){
         $('#student-name').html(($(this).parent().parent().find('#col-name').html()));
         $('#student-id').val(($(this).parent().parent().find('input[type="hidden"]').val()));
         $('#title').val('');
         $('#remark').val('');
         $('#add-remark').modal('show');
    });

    $('#add-remark .modal-footer').find('.btn-primary').click(function(){
        var $this = $(this);
        $('.text-danger,.alert-success').remove();

        valid = false;
        if(($('#title').val().length > 2) && ($('#title').val().trim())){
            valid = true;
        }else{
            $('#title').parent().after().append('<div class="text-danger">Title must be grater than 2 character</div>');
        }
        if(valid) {
            if(($('#remark').val().length > 5) && ($('#remark').val().trim())){
                $.ajax({
                    url: '<?php echo $this->webroot;?>remarks/add',
                    type: 'post',
                    data: $('.modal-body input,.modal-body textarea'),
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
                            var html = '';
                            html += '<div class="alert alert-success" style="margin-left:20px;margin-right:20px;">';
                               html += '<i class="fa fa-check-circle"></i> Successfully added <button data-dismiss="alert" class="close" type="button">×</button>';
                            html += '</div>';

                            $('#success-div').html(html);
                        }else{
                            $('#remark').parent().after().append('<div class="text-danger">'+response.error+'</div>');
                        }
                    }
                });
            }else{
                $('#remark').parent().after().append('<div class="text-danger">Remarks must be between grater than 5 character</div>');
            }
        }
    });


    $('tbody').find('.btn-success').click(function(){
            var $this = $(this);
            student_id = $(this).parent().parent().find('input[type="hidden"]').val();

            $.ajax({
                url: '<?php echo $this->webroot;?>remarks/view',
                type: 'post',
                data: {student_id : student_id},
                dataType: 'html',
                success: function (response) {
                    if (response) {
                        $('#view-remark .modal-body').html(response);
                        $('#view-remark').modal('show');
                    }
                }
            });

        });
</script>
