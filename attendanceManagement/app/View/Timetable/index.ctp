<div class="page-header">
    <div class="container-fluid">
        <h1><i class="glyphicon glyphicon-calendar"></i> Timetable</h1>
        <ul class="breadcrumb">
            <li>
                <?php echo $this->Html->link('Home',array('controller' => 'dashboard')); ?>
            </li>
            <li>
                <?php echo $this->Html->link('Timing',array('controller' => 'timing')); ?>
            </li>
        </ul>
    </div>
</div>

<div class="col-sm-12">
  <div class="box box-primary">
     <div class="box-body">

        <?php if(!isset($timetable)) { ?>
            <form enctype="multipart/form-data" method="get" action="<?php echo $this->webroot; ?>students/index">
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
                            <select class="form-control" name="filter_division" onchange="getStudents(this.value)" id="section-dropdown">

                            </select>
                        </div>
                    </div>
                </div>
            </form>
        <?php } else { ?>
            <table class="items table table-bordered table-striped table-hover">
                <tbody>
                    <?php foreach($days as $day) { ?>
                         <tr>
                              <th class="text-center"><?php echo $day['Day']['name']; ?></th>
                              <?php if(isset($timetable[$day['Day']['name']]) && $timetable[$day['Day']['name']]) { ?>
                                  <?php foreach($timetable[$day['Day']['name']] as $detail) { ?>
                                     <td data-title="Class" class="text-center"><?php echo $detail['start_time'] .' - '.$detail['end_time'] . '<br/>' .$detail['subject'] .'(' . $detail['standard']. ' - '.$detail['section'] .')'; ?></td>
                                  <?php } ?>
                              <?php } else { ?>
                                 <td colspan="7" class="text-red text-center"><span style="font-size: 20px;font-weight: bold;" title="" data-toggle="tooltip" data-original-title="Lecture Not Assigned"> - </span></td>
                              <?php } ?>
                         </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>
     </div>
  </div>
</div>

<div id="append-div">
</div>

<div class="panel-body"></div>

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
                            getStudents('<?php echo $section_id; ?>');
                        <?php } ?>
                    }
                }
            });
        }
    }

    function getStudents(section_id) {
        if(section_id) {
            standard_id = $('#standard-dropdown').val();
            $.ajax({
                'url' : '<?php echo $this->webroot."timetable/getList"; ?>',
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