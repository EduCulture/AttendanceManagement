<div class="page-header">
    <div class="container-fluid">
        <h1><i class="fa fa-th-list"></i> Manage Exam</h1>
        <ul class="breadcrumb">
            <li>
                <?php echo $this->Html->link('Home',array('controller' => 'dashboard')); ?>
            </li>
            <li>
                <?php echo $this->Html->link('Exam',array('controller' => 'exams')); ?>
            </li>
        </ul>
    </div>
</div>

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
                           <option value="<?php echo $standard['Standard']['id']; ?>"><?php echo $standard['Standard']['name']; ?></option>
                       <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="input-price" class="control-label">Division</label>
                    <select class="form-control" name="filter_division" onchange="getExams(this.value)" id="section-dropdown">

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

    <?php if($standard_id) { ?>
        $('#standard-dropdown').val('<?php echo $standard_id; ?>');
        getDivisions('<?php echo $standard_id; ?>');
    <?php } ?>

    function getDivisions(standard_id){
        if(standard_id) {
            $.ajax({
                'url' : '<?php echo $this->webroot."Standards/getAllDivisions"; ?>',
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
                            getExams('<?php echo $section_id; ?>');
                        <?php } ?>
                    }
                }
            });
        }
    }

    function getExams(section_id) {
        if(section_id) {
            standard_id = $('#standard-dropdown').val();
            $.ajax({
                'url' : '<?php echo $this->webroot."exams/getList"; ?>',
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