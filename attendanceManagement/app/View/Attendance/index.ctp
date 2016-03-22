<div class="page-header">
    <div class="container-fluid">
        <h1><i class="fa fa-th-list"></i> Manage Attendance</h1>
        <ul class="breadcrumb">
            <li>
                <?php echo $this->Html->link('Home',array('controller' => 'dashboard')); ?>
            </li>
            <li>
                <?php echo $this->Html->link('Attendance',array('controller' => 'attendance')); ?>
            </li>
        </ul>
    </div>
</div>

  <?php echo $this->Session->flash(); ?>

  <div class="col-sm-12">
        <?php if($standards) { ?>
        <div class="well well-sm">
              <div class="table-responsive">
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
							<select class="form-control" name="filter_division" id="section-dropdown">

							</select>
						</div>
					</div>
				</div>
              </div>
        </div>
        <div class="box box-primary">
           <div class="box-body">
              <div class="row">
                  <div class="col-sm-12">
                      <div class="form-group">
                          <label for="input-name" class="control-label">Date</label>
                          <div class="input-group date  col-sm-4">
                             <input type="text" readonly class="form-control" id="input-date-available" data-format="DD-MM-YYYY" placeholder="Date" name="filter_date">
                             <span class="input-group-btn">
                                 <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                             </span>
                          </div>
                      </div>
                  </div>
                  <div class="col-sm-4">
                        <button onclick="getStudents();" class="btn btn-primary" title="" data-toggle="tooltip" type="button" data-original-title="Search"><i class="fa fa-search"></i> Search</button>
                  </div>
              </div>
           </div>
        </div>
        <?php } else { ?>
            <div class="alert alert-danger">
                You don't have access to take attendance
            </div>
        <?php } ?>
  </div>

  <div id="append-div">
  </div>


 <script src="<?php echo $this->webroot; ?>js/datetimepicker/moment.js" type="text/javascript"></script>
 <script src="<?php echo $this->webroot; ?>js/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
 <link href="<?php echo $this->webroot; ?>js/datetimepicker/bootstrap-datetimepicker.min.css" type="text/css" rel="stylesheet" media="screen" />

 <script>
     $('.date').datetimepicker({
           pickTime: false,
           maxDate:new Date()
     });
 </script>

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
	
    function getStudents() {
        <?php if($standards) { ?>
            section_id = $('#section-dropdown').val();
            standard_id = $('#standard-dropdown').val();
            date = $('#input-date-available').val();
            if(standard_id && section_id && date) {
                $.ajax({
                    'url' : '<?php echo $this->webroot."Attendance/getStudentList"; ?>',
                    'type' : 'post',
                    'data' : {standard_id : standard_id,section_id : section_id, date : date},
                    'dataType' : 'html',
                    'success' : function(response){
                        if(response){
                            $('#append-div').html(response);
                        }
                    }
                });
            }
        <?php } ?>
    }
 </script>