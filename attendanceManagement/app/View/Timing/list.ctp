<div class="col-sm-12">
  <div class="box box-info">
     <div class="box-header with-border">
        <h3 class="box-title"><i class="glyphicon glyphicon-th"></i> Manage Class Timing</h3>
     </div>
     <div class="box-body table-responsive">
        <table class="table table-bordered table-striped table-hover">
           <thead>
               <tr>
                   <td class="text-center">#</td>
                   <td class="text-center">Name</td>
                   <td class="text-center">Start Time</td>
                   <td class="text-center">End Time</td>
                   <td class="text-center">Is Break</td>
                   <td class="text-center">Action</td>
               </tr>
           </thead>
           <tbody>
              <?php if($timing) { ?>
                  <?php $i=1;?>
                  <?php foreach($timing as $detail) { ?>
                     <tr>
                        <td class="text-center"><?php echo $i; ?></td>
                        <td class="text-center"><?php echo $detail['Timing']['name']; ?></td>
                        <td class="text-center"><?php echo date("h:i A",strtotime($detail['Timing']['start_time'])); ?></td>
                        <td class="text-center"><?php echo date("h:i A",strtotime($detail['Timing']['end_time'])); ?></td>
                        <td class="text-center"><?php echo ($detail['Timing']['is_break']) ? '<span class="label label-success text-success">Yes</span>' : '<span class="label label-danger text-danger">No</span>'; ?></td>
                        <td class="text-center">
                            <a class="btn btn-primary"  href="javascript:void(0)" title="" data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                            <a class="btn btn-danger"  href="javascript:void(0)" title="" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-trash"></i></a>
                        </td>
                        <input type="hidden" name="time_id" value="<?php echo $detail['Timing']['id']; ?>" />
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
<div class="modal fade" id="modal-timing-edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
       <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"> </h4>
       </div>
       <div class="modal-body">
          <form class="form-horizontal">
              <div class="form-group required">
                  <label for="input-parent" class="col-sm-3 control-label">Name</label>
                  <div class="col-sm-9">
                      <input type="text" name="name" id="edit-time-name" class="form-control" placeholder="name" value="" />
                  </div>
              </div>
              <div class="form-group required">
                    <label for="input-parent" class="col-sm-3 control-label">Start Time</label>
                    <div class="col-sm-9">
                       <div class="input-group time">
                          <input type="text" readonly class="form-control" id="edit-time-start" placeholder="Start Time" name="start_time" value="">
                          <span class="input-group-btn">
                              <button type="button" class="btn btn-default"><i class="glyphicon glyphicon-time"></i></button>
                          </span>
                       </div>
                    </div>
              </div>
              <div class="form-group required">
                   <label for="input-parent" class="col-sm-3 control-label">End Time</label>
                   <div class="col-sm-9">
                      <div class="input-group time">
                          <input type="text" readonly class="form-control" id="edit-time-end" placeholder="End Time" name="end_time" value="">
                          <span class="input-group-btn">
                              <button type="button" class="btn btn-default"><i class="glyphicon glyphicon-time"></i></button>
                          </span>
                      </div>
                   </div>
              </div>
              <div class="form-group">
                  <label for="input-parent" class="col-sm-3 control-label">Is Break?</label>
                  <div class="col-sm-9">
                      <input type="checkbox" name="is_break" id="edit-time-break" class="form-control" style="margin-top:10px;" />
                  </div>
              </div>
              <input type="hidden" name="time_id" id="edit-time-id" />
              <input type="hidden" name="standard_id" value="<?php echo $standard_id; ?>" />
          </form>
       </div>
       <div class="modal-footer">
          <button type="button" id="btn-time-edit" class="btn btn-primary"> Save</button>
       </div>
    </div>
  </div>
</div>



<script>

$('tbody').find('.btn-primary').click(function(){

    $('.modal-title').html('<i class="fa fa-edit"></i> Edit Time');
    $(this).parent().parent().each(function (i, el) {
        var $tds = $(this).find('td');
        $('#edit-time-name').val($tds.eq(1).text());
        $('#edit-time-start').val($tds.eq(2).text());
        $('#edit-time-end').val($tds.eq(3).text());

        if($tds.find('span').text()=='Yes'){
            $('#edit-time-break').prop('checked',true);
        }

        $('#edit-time-id').val($(this).find('input[name="time_id"]').val());
        $('.time').datetimepicker({
            pickDate: false,
        });
        $('#modal-timing-edit').modal('show');
    });
});

$('tbody').find('.btn-danger').click(function(){

    if(confirm('Are you sure?')) {
        $this = $(this);
        del_time_id = $(this).parent().parent().find('input[name="time_id"]').val();
        $.ajax({
            url: '<?php echo $this->webroot;?>timing/delete',
            type: 'post',
            data: {time_id : del_time_id},
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
                    window.location = '<?php echo $this->webroot."timing/index"; ?>';
                }
            }
        });
    }
});

$('#btn-time-edit').click(function(){
    var $this = $(this);

    standard_id = $('input[name="standard_id"]').val();
    //section_id = $('input[name="section_id"]').val();
    name = $('#edit-time-name').val();
    start_time = $('#edit-time-start').val();
    end_time = $('#edit-time-end').val();
    time_id = $('#edit-time-id').val();
    edit_is_break = 0;
    if($('#edit-time-break').prop('checked')){
        edit_is_break = 1;
    }
    $('.text-danger,.alert-success').remove();

    $.ajax({
        url: '<?php echo $this->webroot;?>timing/save',
        type: 'post',
        //data : $('.modal-body input'),
        data: {standard_id : standard_id, name : name,start_time : start_time,end_time:end_time,time_id:time_id,is_break:edit_is_break},
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
                $('#modal-timing').modal('hide');
                window.location = '<?php echo $this->webroot."timing/index?standard_id=".$standard_id; ?>';
            }else{
                if(response.error){
                    $.each(response.error, function(key,val) {
                       if(key == 'name'){
                          $('#edit-time-'+key).parent().append('<div class="text-danger">'+val+'</div>');
                       }else{
                          $('#edit-time-'+key).parent().parent().append('<div class="text-danger">'+val+'</div>');
                       }
                    });
                }
            }
        }
    });
});
</script>