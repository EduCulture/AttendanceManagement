<div class="page-header">
    <div class="container-fluid">
        <h1><i class="fa fa-comments"></i> Remarks</h1>
        <ul class="breadcrumb">
            <li>
                <?php echo $this->Html->link('Home',array('controller' => 'dashboard')); ?>
            </li>
            <li>
                <?php echo $this->Html->link('Remarks',array('controller' => 'remarks')); ?>
            </li>
        </ul>
    </div>
</div>

<div id="success-div"></div>

<div class="col-sm-12">
    <div class="box box-primary">
       <div class="box-body">
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
                      <select class="form-control" name="filter_division" onchange="getStudents(this.value)" id="section-dropdown">

                      </select>
                  </div>
              </div>
          </div>
       </div>
    </div>
</div>

<div id="append-div">
</div>


<script>

    function getDivisions(standard_id){
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
                    }
                }
            });
        }
    }

    function getStudents(section_id) {
        if(section_id) {
            standard_id = $('#standard-dropdown').val();
            $.ajax({
                'url' : '<?php echo $this->webroot."remarks/getStudentList"; ?>',
                'type' : 'post',
                'data' : {standard_id : standard_id,section_id : section_id},
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