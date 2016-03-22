<div class="page-header">
   <div class="container-fluid">
       <div class="pull-right">
          <button class="btn btn-primary" title="" data-toggle="tooltip" form="form-allopathy" type="submit" data-original-title="Save"><i class="fa fa-save"></i></button>
          <?php echo $this->Html->link('<i class="fa fa-reply"></i>',array('controller' => 'students','action' => 'index'),array('escape' => false,'data-original-title' => 'Cancel','data-toggle' => 'tooltip','class' => 'btn btn-default')); ?>
       </div>
       <h1><i class="fa fa-users"></i> Students</h1>
       <ul class="breadcrumb">
           <li>
               <?php echo $this->Html->link('Home',array('controller' => 'dashboard')); ?>
           </li>
           <li>
               <?php echo $this->Html->link('Student List',array('controller' => 'students','action' => 'index')); ?>
           </li>
       </ul>

       <?php if($error_warning) { ?>
          <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> Please check below errors
             <button type="button" class="close" data-dismiss="alert">&times;</button>
          </div>
       <?php } ?>
   </div>
</div>

<div class="container-fluid">
   <div class="panel panel-default">
      <div class="panel-heading">
          <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo (($student_id) ? 'Edit' : 'Add'); ?> Student</h3>
      </div>
      <div class="panel-body">

          <form id="form-school" class="form-horizontal" method="post" action="<?php echo $this->webroot . (($student_id) ? 'students/edit' : 'students/add'); ?>" enctype="multipart/form-data">

              <div role="tabpanel">
                   <!-- Nav tabs -->
                   <ul class="nav nav-tabs" role="tablist">
                       <li role="presentation" class="active"><a href="#tab-basic" aria-controls="home" role="tab" data-toggle="tab">Basic Details</a></li>
                       <li role="presentation"><a href="#tab-academic" aria-controls="home" role="tab" data-toggle="tab">Academic Details</a></li>
                       <!--<li role="presentation"><a href="#tab-user" aria-controls="home" role="tab" data-toggle="tab">Login Details</a></li>-->
                       <li role="presentation"><a href="#tab-parents" aria-controls="home" role="tab" data-toggle="tab">Parents Details</a></li>
                   </ul>

                   <!-- Tab panes -->
                   <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade in active" id="tab-basic">
                            <div class="form-group required">
                                  <label for="input-parent" class="col-sm-2 control-label">First Name</label>
                                  <div class="col-sm-10">
                                      <input type="text" name="first_name" class="form-control" placeholder="First Name" value="<?php echo $first_name; ?>" />
                                      <?php if($error_first_name){ ?>
                                          <div class="text-danger"><?php echo $error_first_name; ?></div>
                                      <?php } ?>
                                  </div>

                                  <input type="hidden" name="student_id" value="<?php echo $student_id; ?>" />
                            </div>
                            <div class="form-group required">
                                  <label for="input-parent" class="col-sm-2 control-label">Last Name</label>
                                  <div class="col-sm-10">
                                      <input type="text" name="last_name" class="form-control" placeholder="Last Name" value="<?php echo $last_name; ?>" />
                                      <?php if($error_last_name){ ?>
                                          <div class="text-danger"><?php echo $error_last_name; ?></div>
                                      <?php } ?>
                                  </div>
                            </div>
                            <div class="form-group required">
                                  <label for="input-parent" class="col-sm-2 control-label">Contact Number</label>
                                  <div class="col-sm-10">
                                      <input type="text" name="contact_number" class="form-control" placeholder="Contact Number" value="<?php echo $contact_number; ?>" />
                                      <?php if($error_contact_number){ ?>
                                          <div class="text-danger"><?php echo $error_contact_number; ?></div>
                                      <?php } ?>
                                  </div>
                            </div>
                            <div class="form-group required">
                                <label for="input-parent" class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="text" name="email" class="form-control" placeholder="Email" value="<?php echo $email; ?>" />
                                    <?php if($error_email){ ?>
                                       <div class="text-danger"><?php echo $error_email; ?></div>
                                    <?php } ?>
                                </div>
                                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>" />
                            </div>
                            <div class="form-group">
                                <label for="input-parent" class="col-sm-2 control-label">Birthdate</label>
                                <div class="col-sm-3">
                                   <div class="input-group date">
                                       <input type="text" readonly class="form-control" id="input-date-available" data-format="DD-MM-YYYY" placeholder="Birthdate" name="birthdate" value="<?php echo ($birthdate)? date("m/d/Y",strtotime($birthdate)) : date('d-M-y'); ?>">
                                       <span class="input-group-btn">
                                           <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                                       </span>
                                   </div>
                                </div>
                            </div>
                            <div class="form-group">
                                  <label for="input-parent" class="col-sm-2 control-label">Address</label>
                                  <div class="col-sm-10">
                                      <textarea name="address" class="form-control" placeholder="Student Address"><?php echo $address; ?></textarea>
                                  </div>
                            </div>
                            <div class="form-group">
                                  <label for="input-parent" class="col-sm-2 control-label">Student Image</label>
                                  <div class="col-sm-10">

                                      <a class="img-thumbnail" href="#" id="thumb-image" data-toggle="image">
                                            <img src="<?php echo ($profile_pic) ? $this->webroot .$profile_pic : $this->webroot .'images/no_image.jpg' ; ?>" width="80px" height="80px">
                                      </a>

                                      <input type="hidden" name="profile_pic" id="input-image" value="<?php echo $profile_pic; ?>" />

                                      <?php if(isset($image_error)){ ?>
                                          <div class="text-danger"><?php echo $image_error; ?></div>
                                      <?php } ?>
                                  </div>
                            </div>
                            <div class="form-group">
                                <label for="input-parent" class="col-sm-2 control-label">Gender</label>
                                <div class="col-sm-10">
                                   <label class="radio-inline">
                                      <input type="radio" <?php echo ($gender==1) ? 'checked="checked"' : ''; ?> value="1" name="gender">Male
                                   </label>
                                   <label class="radio-inline">
                                      <input type="radio" <?php echo ($gender==0) ? 'checked="checked"' : ''; ?> value="0" name="gender">Female
                                   </label>
                                </div>
                            </div>
                            <div class="form-group">
                                  <label for="input-parent" class="col-sm-2 control-label">Is Active?</label>
                                  <div class="col-sm-10">
                                      <input type="checkbox" name="active" class="form-control" style="margin-top:10px;" value="1" <?php echo ($active) ? 'checked="checked"' : ''; ?> />
                                  </div>
                            </div>
                        </div>

                        <!--Academic Details-->
                        <div role="tabpanel" class="tab-pane fade in" id="tab-academic">
                            <div class="form-group required">
                                  <label for="input-parent" class="col-sm-2 control-label">Standard</label>
                                  <div class="col-sm-10">
                                      <select class="form-control" name="standard_id" onchange="getDivisions(this.value)" id="standard-dropdown">
                                         <option value="" selected="selected">---Please Select---</option>
                                         <?php foreach($standards as $standard) { ?>
                                            <option value="<?php echo $standard['Standard']['id']; ?>" <?php echo ($standard['Standard']['id'] == $standard_id) ? 'selected="selected"' : ''; ?>><?php echo $standard['Standard']['name']; ?></option>
                                         <?php } ?>
                                      </select>
                                      <?php if($error_standard_id){ ?>
                                          <div class="text-danger"><?php echo $error_standard_id; ?></div>
                                      <?php } ?>
                                  </div>
                            </div>
                            <div class="form-group required">
                                  <label for="input-price" class="col-sm-2 control-label">Division</label>
                                  <div class="col-sm-10">
                                      <select class="form-control" name="section_id" id="section-dropdown">

                                      </select>
                                      <?php if($error_section_id){ ?>
                                           <div class="text-danger"><?php echo $error_section_id; ?></div>
                                      <?php } ?>
                                  </div>
                            </div>
                            <div class="form-group required">
                                  <label for="input-parent" class="col-sm-2 control-label">Admission Number</label>
                                  <div class="col-sm-10">
                                      <input type="text" name="admission_number" class="form-control" placeholder="Admission Number" value="<?php echo $admission_number; ?>" />
                                      <?php if($error_admission_number){ ?>
                                          <div class="text-danger"><?php echo $error_admission_number; ?></div>
                                      <?php } ?>
                                  </div>
                            </div>
                            <div class="form-group required">
                                  <label for="input-parent" class="col-sm-2 control-label">Roll Number</label>
                                  <div class="col-sm-10">
                                      <input type="text" name="roll_number" class="form-control" placeholder="Roll Number" value="<?php echo $roll_number; ?>" />
                                      <?php if($error_roll_number){ ?>
                                          <div class="text-danger"><?php echo $error_roll_number; ?></div>
                                      <?php } ?>
                                  </div>
                            </div>
                        </div>

                        <!--Login Details-->
                        <?php /*
                            <div role="tabpanel" class="tab-pane fade in" id="tab-user">
                                <div class="form-group required">
                                    <label for="input-parent" class="col-sm-2 control-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="email" class="form-control" placeholder="Email" value="<?php echo $email; ?>" />
                                        <?php if($error_email){ ?>
                                           <div class="text-danger"><?php echo $error_email; ?></div>
                                        <?php } ?>
                                    </div>
                                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>" />
                                </div>
                                <div class="form-group required">
                                    <label for="input-parent" class="col-sm-2 control-label">Username</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="username" class="form-control" placeholder="Username" value="<?php echo $username; ?>" />
                                        <?php if($error_username){ ?>
                                           <div class="text-danger"><?php echo $error_username; ?></div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="form-group required">
                                    <label for="input-parent" class="col-sm-2 control-label">Password</label>
                                    <div class="col-sm-10">
                                        <input type="password" name="password" class="form-control" placeholder="Password" value="" />
                                        <?php if($error_password){ ?>
                                           <div class="text-danger"><?php echo $error_password; ?></div>
                                        <?php } ?>
                                    </div>
                                    <input type="hidden" name="role_id" value="4" />
                                </div>
                            </div>
                        */ ?>

                        <!-- Parents Info -->
                        <div role="tabpanel" class="tab-pane fade in" id="tab-parents">
                             <div class="table-responsive">
                                <table id="parent" class="table table-striped table-bordered table-hover">
                                   <thead>
                                      <tr>
                                          <td class="text-left">Relation</td>
                                          <td class="text-right">Name</td>
                                          <td class="text-right">Contact Number</td>
                                          <td class="text-right">Address</td>
                                          <td></td>
                                      </tr>
                                   </thead>
                                   <tbody>
                                        <?php $parent_row = 0; ?>
                                        <?php foreach ($student_parents as $student_parent) { ?>
                                            <tr id="parent-row<?php echo $parent_row; ?>">
                                                <td class="text-left">
                                                    <input type="text" name="student_parents[<?php echo $parent_row; ?>][relation]" class="form-control" value="<?php echo $student_parent['relation']; ?>" placeholder="Relation" />
                                                    <?php if(isset($error_parents[$parent_row]['relation'])){ ?>
                                                       <div class="text-danger"><?php echo $error_parents[$parent_row]['relation']; ?></div>
                                                    <?php } ?>
                                                </td>
                                                <td class="text-right">
                                                    <input type="text" name="student_parents[<?php echo $parent_row; ?>][name]" class="form-control" value="<?php echo $student_parent['name']; ?>" placeholder="Name" />
                                                    <?php if(isset($error_parents[$parent_row]['name'])){ ?>
                                                       <div class="text-danger"><?php echo $error_parents[$parent_row]['name']; ?></div>
                                                    <?php } ?>
                                                </td>
                                                <td class="text-right">
                                                    <input type="text" name="student_parents[<?php echo $parent_row; ?>][contact_number]" value="<?php echo $student_parent['contact_number']; ?>" placeholder="Contact Number" class="form-control" />
                                                    <?php if(isset($error_parents[$parent_row]['contact_number'])){ ?>
                                                       <div class="text-danger"><?php echo $error_parents[$parent_row]['contact_number']; ?></div>
                                                    <?php } ?>
                                                </td>
                                                <td class="text-right">
                                                    <textarea name="student_parents[<?php echo $parent_row; ?>][address]" placeholder="Address" class="form-control"><?php echo $student_parent['address']; ?></textarea>
                                                </td>
                                                <td class="text-left"><button type="button" onclick="$('#parent-row<?php echo $parent_row; ?>').remove();" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                                            </tr>
                                            <?php $parent_row++; ?>
                                        <?php } ?>
                                   </tbody>
                                   <tfoot>
                                       <tr>
                                          <td colspan="5"></td>
                                          <td class="text-left"><button type="button" onclick="addParent();" data-toggle="tooltip" title="Add More" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                                       </tr>
                                    </tfoot>
                                </table>
                             </div>
                        </div>
                   </div>
              </div>
          </form>
      </div>
   </div>
</div>

<script src="<?php echo $this->webroot; ?>js/datetimepicker/moment.js" type="text/javascript"></script>
<script src="<?php echo $this->webroot; ?>js/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<link href="<?php echo $this->webroot; ?>js/datetimepicker/bootstrap-datetimepicker.min.css" type="text/css" rel="stylesheet" media="screen" />

<script>
$('.date').datetimepicker({
    pickTime: false
});
</script>

<script type="text/javascript"><!--
    var parent_row = <?php echo $parent_row; ?>;

    function addParent() {
        html  = '<tr id="parent-row' + parent_row + '">';
            html += '  <td class="text-right"><input type="text" name="student_parents[' + parent_row + '][relation]" value="" placeholder="Relation" class="form-control" /></td>';
            html += '  <td class="text-right"><input type="text" name="student_parents[' + parent_row + '][name]" value="" placeholder="Name" class="form-control" /></td>';
            html += '  <td class="text-right"><input type="text" name="student_parents[' + parent_row + '][contact_number]" value="" placeholder="Contact Number" class="form-control" /></td>';
            html += '  <td class="text-right"><textarea name="student_parents[' + parent_row + '][address]" placeholder="Address" class="form-control"></textarea></td>';
            html += '  <td class="text-left"><button type="button" onclick="$(\'#parent-row' + parent_row + '\').remove();" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
        html += '</tr>';

        $('#parent tbody').append(html);

        parent_row++;
    }
//--></script>

<script>

getDivisions($('#standard-dropdown').val());

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
                    section_id = '<?php echo $section_id; ?>';
                    for(var i=0;i<response.length;i++) {
                        html += '<option value='+ response[i].section_id +' (section_id==response[i].section_id) ? "selected=selected" : "" >' + response[i].section_name + '</option>';
                    }

                    $('#section-dropdown').html(html);
                }
            }
        });
    }
}
</script>

