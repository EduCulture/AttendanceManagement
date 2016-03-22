<div class="page-header">
   <div class="container-fluid">
       <div class="pull-right">
          <button class="btn btn-primary" title="" data-toggle="tooltip" form="form-allopathy" type="submit" data-original-title="Save"><i class="fa fa-save"></i> Save</button>
          <?php echo $this->Html->link('<i class="fa fa-reply"></i> Cancel',array('controller' => 'staffs','action' => 'index'),array('escape' => false,'data-original-title' => 'Cancel','data-toggle' => 'tooltip','class' => 'btn btn-default')); ?>
       </div>
       <h1>Staffs</h1>
       <ul class="breadcrumb">
           <li>
               <?php echo $this->Html->link('Home',array('controller' => 'dashboard')); ?>
           </li>
           <li>
               <?php echo $this->Html->link('Staffs',array('controller' => 'staffs','action' => 'index')); ?>
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
          <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo (($staff_id) ? 'Edit' : 'Add'); ?> Staff</h3>
      </div>
      <div class="panel-body">

          <form id="form-school" class="form-horizontal" method="post" action="<?php echo $this->webroot . (($staff_id) ? 'staffs/edit' : 'staffs/add'); ?>" enctype="multipart/form-data">

              <div role="tabpanel">
                   <!-- Nav tabs -->
                   <ul class="nav nav-tabs" role="tablist">
                       <li role="presentation" class="active"><a href="#tab-basic" aria-controls="home" role="tab" data-toggle="tab">Basic Details</a></li>
                       <!--<li role="presentation"><a href="#tab-user" aria-controls="home" role="tab" data-toggle="tab">Login Details</a></li>-->
                       <li role="presentation"><a href="#tab-extra" aria-controls="home" role="tab" data-toggle="tab">Extra Details</a></li>
                       <li role="presentation"><a href="#tab-subject" aria-controls="home" role="tab" data-toggle="tab">Subject Details</a></li>
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
                                  <?php if($staff_id) { ?>
                                      <input type="hidden" name="staff_id" value="<?php echo $staff_id; ?>" />
                                  <?php } ?>
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
                                  <label for="input-parent" class="col-sm-2 control-label">Employee Id</label>
                                  <div class="col-sm-10">
                                      <input type="text" name="emp_id" class="form-control" placeholder="Employee Id" value="<?php echo $emp_id; ?>" />
                                      <?php if($error_emp_id){ ?>
                                          <div class="text-danger"><?php echo $error_emp_id; ?></div>
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
                                <?php if($staff_id) { ?>
                                   <input type="hidden" name="user_id" value="<?php echo $user_id; ?>" />
                                <?php } ?>
                            </div>
                            <div class="form-group">
                                  <label for="input-parent" class="col-sm-2 control-label">Address</label>
                                  <div class="col-sm-10">
                                      <textarea name="address" class="form-control" placeholder="Employee Address"><?php echo $address; ?></textarea>
                                  </div>
                            </div>
                            <div class="form-group">
                                  <label for="input-parent" class="col-sm-2 control-label">Staff Image</label>
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
                                  <label for="input-parent" class="col-sm-2 control-label">Is Active?</label>
                                  <div class="col-sm-10">
                                      <input type="checkbox" name="active" class="form-control" style="margin-top:10px;" value="1" <?php echo ($active) ? 'checked="checked"' : ''; ?> />
                                  </div>
                            </div>

                        </div>

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
                                <?php if($staff_id) { ?>
                                   <input type="hidden" name="user_id" value="<?php echo $user_id; ?>" />
                                <?php } ?>
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
                                <input type="hidden" name="role_id" value="2" />
                            </div>
                        </div>
                        */ ?>

                        <!-- Additional Info -->
                        <div role="tabpanel" class="tab-pane fade in" id="tab-extra">
                            <div class="form-group required">
                                <label for="input-parent" class="col-sm-2 control-label">Qualification</label>
                                <div class="col-sm-6">
                                    <input type="text" name="qualification" class="form-control" placeholder="Qualification" value="<?php echo $qualification; ?>" />
                                </div>
                            </div>
                            <div class="form-group required">
                                <label for="input-parent" class="col-sm-2 control-label">Select Role</label>
                                <div class="col-sm-6">
                                    <select name="role_id" class="form-control">
                                        <?php foreach($roles as $role) { ?>
                                            <option value="<?php echo $role['Role']['id']; ?>" <?php echo ($role['Role']['id'] == $role_id) ? 'selected="selected"' : ''; ?> ><?php echo $role['Role']['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input-parent" class="col-sm-2 control-label">Type</label>
                                <div class="col-sm-10">
                                   <label class="radio-inline">
                                      <input type="radio" <?php echo ($type==1) ? 'checked="checked"' : ''; ?> value="1" name="type">Teaching
                                   </label>
                                   <label class="radio-inline">
                                      <input type="radio" <?php echo ($type==0) ? 'checked="checked"' : ''; ?> value="0" name="type">Non Teaching
                                   </label>
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
                                <label for="input-parent" class="col-sm-2 control-label">Birthdate</label>
                                <div class="col-sm-3">
                                   <div class="input-group date">
                                       <input type="text" readonly class="form-control" id="input-date-available" data-format="DD-MM-YYYY" placeholder="Birthdate" name="birthdate" value="<?php echo date("m/d/Y",strtotime($birthdate)); ?>">
                                       <span class="input-group-btn">
                                           <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                                       </span>
                                   </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input-parent" class="col-sm-2 control-label">Joining Date</label>
                                <div class="col-sm-3">
                                   <div class="input-group date">
                                       <input type="text" readonly class="form-control" id="input-date-available" data-format="DD-MM-YYYY" placeholder="Joining Date" name="joining_date" value="<?php echo date("m/d/Y",strtotime($joining_date)); ?>">
                                       <span class="input-group-btn">
                                           <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                                       </span>
                                   </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input-parent" class="col-sm-2 control-label">Basic Salary</label>
                                <div class="col-sm-4">
                                    <input type="text" name="basic_salary" class="form-control" placeholder="Basic Salary" value="<?php echo $basic_salary; ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input-parent" class="col-sm-2 control-label">Experience</label>
                                <div class="col-sm-4">
                                    <input type="text" name="experience" class="form-control" placeholder="Experience" value="<?php echo $experience; ?>" />
                                </div>
                            </div>
                        </div>
                        <!-- Subject Tab -->
                        <div role="tabpanel" class="tab-pane fade in" id="tab-subject">
                            <div class="form-group required">
                                <label for="input-parent" class="col-sm-2 control-label">Select Subjects</label>
                                <div class="col-sm-10">
                                    <div class="well well-sm" style="height: 150px; overflow: auto;">
                                        <?php foreach($subjects as $subject) { ?>
                                            <?php $checked = false; ?>
                                            <?php foreach($staff_subjects as $staff_subject) { ?>
                                                <?php if($staff_subject == $subject['Subject']['id']) { ?>
                                                    <?php $checked = true;break; ?>
                                                <?php } ?>
                                            <?php } ?>
                                            <div class="checkbox">
                                                <label><input type="checkbox" name="staff_subjects[]" <?php echo ($checked) ? 'checked="checked"' : ''; ?> value="<?php echo $subject['Subject']['id']; ?>" /><?php echo  " ".$subject['Subject']['name']; ?></label>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
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
  pickTime: false,
  autoclose: true
});

function getDivisions(row,value){

    $.ajax({
        url: '<?php echo $this->webroot;?>standards/getDivisions',
        type: 'post',
        data: {standard_id : value },
        dataType: 'json',
        beforeSend : function(){
              //$.blockUI({message: '<h4><img src="<?php echo $this->webroot; ?>images/loader.gif" />  Just a moment...</h4>'});
        },
        success: function (response) {
            if (response.length>0) {
                //alert(response.length);
                var html = '';
                for(var i=0;i<response.length;i++){
                    html +=' <option value="'+response[i].section_id+'">'+response[i].section_name+'</option>'
                }
                $('#division-dropdown-'+row).html(html);
                //console.log(response);
            }
        }
    });
}
</script>