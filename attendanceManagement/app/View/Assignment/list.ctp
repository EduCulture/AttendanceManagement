<div class="col-sm-12">
  <div class="box box-info">
     <div class="box-header with-border">
        <h3 class="box-title"><i class="glyphicon glyphicon-th"></i> Manage Assignment</h3>
        <div class="box-tools pull-right">
        	<a class="btn btn-flat btn-success btn-sm" style="margin-top:-5px;" href="#" title="Add Assignment" id="add-assignment"><i class="fa fa-plus-square"></i> <span class="hidden-xs">Add Assignment</span></a>
        </div>
     </div>
     <div class="box-body table-responsive">
        <table class="table table-bordered table-striped table-hover">
           <thead>
               <tr>
                   <td class="text-center">#</td>
                   <td class="text-center">Name</td>
                   <td class="text-center">Subject</td>
                   <td class="text-center">Staff</td>
                   <td class="text-center">Start Date</td>
                   <td class="text-center">End Date</td>
                   <td class="text-center">Action</td>
               </tr>
           </thead>
           <tbody>
              <?php if($assignments) { ?>
                  <?php $i=1;?>
                  <?php foreach($assignments as $assignment) { ?>
                     <tr>
                        <td class="text-center"><?php echo $i; ?></td>
                        <td class="text-center"><?php echo $assignment['Assignment']['title']; ?></td>
                        <td class="text-center"><?php echo $assignment['Subject']['name']; ?></td>
                        <td class="text-center"><?php echo $assignment['Staff']['first_name'].' '.$assignment['Staff']['last_name']; ?></td>
                        <td class="text-center"><?php echo date("d-M-Y",strtotime($assignment['Assignment']['start_date'])); ?></td>
                        <td class="text-center"><?php echo date("d-M-Y",strtotime($assignment['Assignment']['end_date'])); ?></td>
                        <td class="text-center">
                            <a class="btn btn-primary"  href="javascript:void(0)" title="" data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                            <a class="btn btn-danger"  href="javascript:void(0)" title="" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-trash"></i></a>
                        </td>
                        <input type="hidden" name="title" value="<?php echo $assignment['Assignment']['title']; ?>" />
                        <input type="hidden" name="desc" value="<?php echo $assignment['Assignment']['description']; ?>" />
                        <input type="hidden" name="assignment_id" value="<?php echo $assignment['Assignment']['id']; ?>" />
                        <input type="hidden" name="subject_id" value="<?php echo $assignment['Subject']['id']; ?>" />
                        <input type="hidden" name="start_date" value="<?php echo date("m/d/Y",strtotime($assignment['Assignment']['start_date'])); ?>" />
                        <input type="hidden" name="end_date" value="<?php echo date("m/d/Y",strtotime($assignment['Assignment']['end_date'])); ?>" />
                     </tr>
                    <?php $i++; ?>
                  <?php } ?>
              <?php } else { ?>
                 <tr>
                     <td colspan="7" class="text-center"> No Data Available</td>
                 </tr>
              <?php } ?>
           </tbody>
        </table>
     </div>
  </div>
</div>

<!-- Modal Popup -->
<div class="modal fade" id="modal-assignment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
       <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"> </h4>
       </div>
       <div class="modal-body">
          <form class="form-horizontal">
              <div class="form-group required">
                  <label for="input-parent" class="col-sm-3 control-label">Title</label>
                  <div class="col-sm-9">
                      <input type="text" name="title" id="modal-title" class="form-control" placeholder="Title" value="" />
                  </div>
              </div>
              <div class="form-group">
                  <label for="input-parent" class="col-sm-3 control-label">Description</label>
                  <div class="col-sm-9">
                        <textarea name="description" id="modal-description" class="form-control" placeholder="Description"></textarea>
                  </div>
              </div>
              <div class="form-group required">
                    <label for="input-parent" class="col-sm-3 control-label">Start Date</label>
                    <div class="col-sm-9">
                       <div class="input-group time">
                          <input type="text" readonly class="form-control" id="modal-start-date" placeholder="Start Date" name="start_date" value="">
                          <span class="input-group-btn">
                              <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                          </span>
                       </div>
                    </div>
              </div>
              <div class="form-group required">
                   <label for="input-parent" class="col-sm-3 control-label">End Date</label>
                   <div class="col-sm-9">
                      <div class="input-group time">
                          <input type="text" readonly class="form-control" id="modal-end-date" placeholder="End Date" name="end_date" value="">
                          <span class="input-group-btn">
                              <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                          </span>
                      </div>
                   </div>
              </div>

              <div class="form-group required">
                 <label for="input-parent" class="col-sm-3 control-label">Subjects</label>
                 <div class="col-sm-9">
                     <select class="form-control" name="subject_id" id="modal-subject">
                        <?php foreach($subjects as $subject) { ?>
                            <option value="<?php echo $subject['subject_id']; ?>"><?php echo $subject['subject']; ?></option>
                        <?php } ?>
                     </select>
                 </div>
              </div>

              <input type="hidden" name="assignment_id" id="assignment-id" />
              <input type="hidden" name="standard_id" value="<?php echo $standard_id; ?>" />
              <input type="hidden" name="section_id" value="<?php echo $section_id; ?>" />
          </form>
       </div>
       <div class="modal-footer">
          <button type="button" id="btn-assignment-save" class="btn btn-primary"> Save</button>
       </div>
    </div>
  </div>
</div>

<div class="panel-body">

</div>

<script src="<?php echo $this->webroot; ?>js/datetimepicker/moment.js" type="text/javascript"></script>
<script src="<?php echo $this->webroot; ?>js/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<link href="<?php echo $this->webroot; ?>js/datetimepicker/bootstrap-datetimepicker.min.css" type="text/css" rel="stylesheet" media="screen" />
<link href="<?php echo $this->webroot; ?>js/summernote//summernote.css" rel="stylesheet" />
<script src="<?php echo $this->webroot; ?>js/summernote/summernote.js" type="text/javascript"></script>

<script>


$('#add-assignment').click(function(){
    $('.modal-title').html('<i class="fa fa-plus-square"></i> Add Assignment');
    $('.time').datetimepicker({
          pickTime: false,
          minDate : new Date()
    });
    $('#modal-assignment').modal('show');
});

$('#modal-description').summernote({
    height: 170
});

$('tbody').find('.btn-primary').click(function(){

    $('.modal-title').html('<i class="fa fa-edit"></i> Edit Assignment');
    $('#modal-title').val($(this).parent().parent().find('input[name="title"]').val());
    $('#modal-description').code($(this).parent().parent().find('input[name="desc"]').val());
    $('#assignment-id').val($(this).parent().parent().find('input[name="assignment_id"]').val());
    $('#modal-subject').val($(this).parent().parent().find('input[name="subject_id"]').val());
    $('#modal-start-date').val($(this).parent().parent().find('input[name="start_date"]').val());
    $('#modal-end-date').val($(this).parent().parent().find('input[name="end_date"]').val());

    $('.time').datetimepicker({
        pickTime: false,
        //minDate : new Date()
    });

    $('#modal-assignment').modal('show');
});

$('tbody').find('.btn-danger').click(function(){

    if(confirm('Are you sure?')) {
        $this = $(this);
        assignment_id = $(this).parent().parent().find('input[name="assignment_id"]').val();
        $.ajax({
            url: '<?php echo $this->webroot;?>assignment/delete',
            type: 'post',
            data: {assignment_id : assignment_id},
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
                    window.location = '<?php echo $this->webroot."assignment/index?standard_id=".$standard_id."&section_id=".$section_id; ?>';
                }
            }
        });
    }
});

$('#btn-assignment-save').click(function(){
    var $this = $(this);

    title = $('#modal-title').val();
    description = $("#modal-description").code();
    standard_id = '<?php echo $standard_id; ?>';
    section_id = '<?php echo $section_id; ?>';
    subject_id = $('#modal-subject').val();
    assignment_id = $('#assignment-id').val();
    start_date = $('#modal-start-date').val();
    end_date = $('#modal-end-date').val();

    $('.text-danger,.alert-success').remove();

    $.ajax({
        url: '<?php echo $this->webroot;?>assignment/save',
        type: 'post',
        //data : $('.modal-body input,.modal-body select'),
        data: {standard_id : standard_id,section_id : section_id, title : title,start_date : start_date,end_date : end_date,assignment_id : assignment_id,description : description, subject_id : subject_id},
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
                $('#modal-assignment').modal('hide');
                window.location = '<?php echo $this->webroot."assignment/index?standard_id=".$standard_id."&section_id=".$section_id; ?>';
            }else{
                if(response.error){
                    $.each(response.error, function(key,val) {
                       if(key == 'start-date' || key == 'end-date'){
                          $('#modal-'+key).parent().parent().append('<div class="text-danger">'+val+'</div>');
                       }else{
                          $('#modal-'+key).parent().append('<div class="text-danger">'+val+'</div>');
                       }
                    });
                }
            }
        }
    });
});
</script>