  <div class="page-header">
        <div class="container-fluid">
            <h1><i class="fa fa-inr"></i> Manage</h1>
            <ul class="breadcrumb">
                <li>
                    <?php echo $this->Html->link('Home',array('controller' => 'dashboard')); ?>
                </li>
                <li>
                    <?php echo $this->Html->link('Fees',array('controller' => 'fees')); ?>
                </li>
            </ul>
        </div>
  </div>

  <div class="col-sm-12">
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   <div class="col-sm-4">
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
                   <div class="col-sm-4">
                       <div class="form-group">
                           <label for="input-price" class="control-label">Division</label>
                           <select class="form-control" name="filter_division" onchange="getCategories(this.value)" id="section-dropdown">

                           </select>
                       </div>
                   </div>
                   <div class="col-sm-4">
                       <div class="form-group">
                           <label for="input-price" class="control-label">Fees Category</label>
                           <select class="form-control" name="filter_division" onchange="getStudents()" id="category-dropdown">

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
                        }
                    }
                });
            }
        }

        function getCategories(section_id){
            standard_id = $('#standard-dropdown').val();
            if(section_id) {
                $.ajax({
                    'url' : '<?php echo $this->webroot."Fees/getFeesCategory"; ?>',
                    'type' : 'post',
                    'data' : {standard_id : standard_id},
                    'dataType' : 'json',
                    'success' : function(response){
                        if(response.length > 0){
                            var html = '';
                            html += '<option value="">---Please Select---</option>';
                            for(var i=0;i<response.length;i++) {
                                html += '<option value='+ response[i].fee_id +'>' + response[i].fee_name + '</option>';
                            }

                            $('#category-dropdown').html(html);
                        }
                    }
                });
            }
        }

        function getStudents() {

            standard_id = $('#standard-dropdown').val();
            section_id = $('#section-dropdown').val();
            fee_id = $('#category-dropdown').val();
            if(standard_id && section_id && fee_id) {
                $.ajax({
                    'url' : '<?php echo $this->webroot."Fees/getStudentList"; ?>',
                    'type' : 'post',
                    'data' : {standard_id : standard_id,section_id : section_id,fee_id : fee_id},
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