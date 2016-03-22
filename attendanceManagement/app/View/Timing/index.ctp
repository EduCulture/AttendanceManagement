<div class="page-header">
    <div class="container-fluid">
        <h1><i class="glyphicon glyphicon-time"></i> Class Timing</h1>
        <ul class="breadcrumb">
            <li>
                <?php echo $this->Html->link('Home',array('controller' => 'dashboard')); ?>
            </li>
            <li>
                <?php echo $this->Html->link('Timing',array('controller' => 'timing')); ?>
            </li>
        </ul>
        <div class="pull-right">
            <button class="btn btn-flat btn-success" title="Add Class Timing" id="add-timing"><i class="fa fa-plus-square"></i> <span class="hidden-xs">Add Class Timing</span></button>
        </div>
    </div>
</div>

<div class="col-sm-12">
  <div class="box box-primary">
     <div class="box-body">
        <form enctype="multipart/form-data" method="get" action="<?php echo $this->webroot; ?>students/index">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="input-name" class="control-label">Standard</label>
                        <select name="filter_standard" onchange="getStudents(this.value)" class="form-control" id="standard-dropdown">
                           <option value="" selected="selected">---Please Select---</option>
                           <?php foreach($standards as $standard) { ?>
                               <option value="<?php echo $standard['Standard']['id']; ?>" <?php echo ($standard['Standard']['id']==$standard_id) ? 'selected="selected"' : ''; ?>  ><?php echo $standard['Standard']['name']; ?></option>
                           <?php } ?>
                        </select>
                    </div>
                </div>
                <?php /*
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="input-price" class="control-label">Division</label>
                        <select class="form-control" name="filter_division" onchange="getStudents(this.value)" id="section-dropdown">

                        </select>
                    </div>
                </div>
                */ ?>
            </div>
        </form>
     </div>
  </div>
</div>

<div class="modal fade" id="modal-timing" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
                      <input type="text" name="name" id="time-name" class="form-control" placeholder="name" value="" />
                  </div>
              </div>
              <div class="form-group required">
                    <label for="input-parent" class="col-sm-3 control-label">Start Time</label>
                    <div class="col-sm-9">
                       <div class="input-group time">
                          <input type="text" readonly class="form-control" id="time-start" placeholder="Start Time" name="start_time" value="">
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
                          <input type="text" readonly class="form-control" id="time-end" placeholder="End Time" name="end_time" value="">
                          <span class="input-group-btn">
                              <button type="button" class="btn btn-default"><i class="glyphicon glyphicon-time"></i></button>
                          </span>
                      </div>
                   </div>
              </div>
              <div class="form-group required">
                 <label for="input-parent" class="col-sm-3 control-label">Select Standards</label>
                 <div class="col-sm-9">
                     <div class="well well-sm" style="height: 150px; overflow: auto;" id="time-standard">
                        <?php foreach($standards as $standard) { ?>
                            <div class="checkbox">
                               <label><input type="checkbox" name="standard_id[]" value="<?php echo $standard['Standard']['id']; ?>"><?php echo $standard['Standard']['name']; ?></label>
                            </div>
                        <?php } ?>
                     </div>
                 </div>
              </div>
              <div class="form-group">
                  <label for="input-parent" class="col-sm-3 control-label">Is Break?</label>
                  <div class="col-sm-9">
                      <input type="checkbox" name="is_break" id="time-break" class="form-control" style="margin-top:10px;" />
                  </div>
              </div>
              <input type="hidden" name="time_id" id="time-id" />
          </form>
       </div>
       <div class="modal-footer">
          <button type="button" id="btn-time-save" class="btn btn-primary"> Save</button>
       </div>
    </div>
  </div>
</div>

<div id="append-div">
</div>

 <script src="<?php echo $this->webroot; ?>js/datetimepicker/moment.js" type="text/javascript"></script>
 <script src="<?php echo $this->webroot; ?>js/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
 <link href="<?php echo $this->webroot; ?>js/datetimepicker/bootstrap-datetimepicker.min.css" type="text/css" rel="stylesheet" media="screen" />

 <script>

    <?php if($standard_id) { ?>
        getStudents('<?php echo $standard_id; ?>');
    <?php } ?>

    $('#add-timing').click(function(){
        $('.modal-title').html('<i class="fa fa-plus-square"></i> Add Time');
        $('.time').datetimepicker({
              pickDate: false,
        });
        $('#modal-timing').modal('show');
    });

    $('#btn-time-save').click(function(){
        var $this = $(this);
        standard_id = [];
        $('.checkbox').find('input[type="checkbox"]').each(function() {
            if($(this).prop('checked')){
                standard_id.push($(this).val());
            }
        });
        name = $('#time-name').val();
        start_time = $('#time-start').val();
        end_time = $('#time-end').val();
        time_id = $('#time-id').val();
        is_break = 0;
        if($('input[name="is_break"]').prop('checked')){
            is_break = 1;
        }
        $('.text-danger,.alert-success').remove();

        $.ajax({
            url: '<?php echo $this->webroot;?>timing/save',
            type: 'post',
            //data : $('.modal-body input'),
            data: {standard_id : JSON.stringify(standard_id), name : name,start_time : start_time,end_time:end_time,time_id:time_id,is_break:is_break},
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
                    window.location = '<?php echo $this->webroot."timing/index"; ?>';
                }else{
                    if(response.error){
                        $.each(response.error, function(key,val) {
                           if(key == 'name' || key == 'standard'){
                              $('#time-'+key).parent().append('<div class="text-danger">'+val+'</div>');
                           }else{
                              $('#time-'+key).parent().parent().append('<div class="text-danger">'+val+'</div>');
                           }
                        });
                    }
                }
            }
        });
    });

    function getStudents(standard_id) {
        if(standard_id) {
            //standard_id = $('#standard-dropdown').val();
            $.ajax({
                'url' : '<?php echo $this->webroot."timing/getList"; ?>',
                'type' : 'post',
                'data' : {standard_id : standard_id},
                'dataType' : 'html',
                'success' : function(response){
                    if(response){
                        $('#append-div').html(response);
                    }
                }
            });
        }
    }
 </script>