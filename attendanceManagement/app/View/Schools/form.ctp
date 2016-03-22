<div class="page-header">
   <div class="container-fluid">
       <div class="pull-right">
          <button class="btn btn-primary" title="" data-toggle="tooltip" form="form-allopathy" type="submit" data-original-title="Save"><i class="fa fa-save"></i></button>
          <?php echo $this->Html->link('<i class="fa fa-reply"></i>',array('controller' => 'schools','action' => 'index'),array('escape' => false,'data-original-title' => 'Cancel','data-toggle' => 'tooltip','class' => 'btn btn-default')); ?>
       </div>
       <h1>Schools</h1>
       <ul class="breadcrumb">
           <li>
               <?php echo $this->Html->link('Home',array('controller' => 'dashboard')); ?>
           </li>
           <li>
               <?php echo $this->Html->link('Schools',array('controller' => 'schools','action' => 'index')); ?>
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
          <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo (($school_id) ? 'Edit' : 'Add'); ?> School</h3>
      </div>
      <div class="panel-body">

          <form id="form-school" class="form-horizontal" method="post" action="<?php echo $this->webroot . (($school_id) ? 'schools/edit' : 'schools/add'); ?>" enctype="multipart/form-data">

              <div role="tabpanel">
                   <!-- Nav tabs -->
                   <ul class="nav nav-tabs" role="tablist">
                       <li role="presentation" class="active"><a href="#tab-school" aria-controls="home" role="tab" data-toggle="tab">School Details</a></li>
                       <li role="presentation"><a href="#tab-user" aria-controls="home" role="tab" data-toggle="tab">Login Details</a></li>
                   </ul>

                   <!-- Tab panes -->
                   <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade in active" id="tab-school">
                            <div class="form-group required">
                                  <label for="input-parent" class="col-sm-2 control-label">Name</label>
                                  <div class="col-sm-10">
                                      <input type="text" name="name" class="form-control" placeholder="School Name" value="<?php echo $name; ?>" />
                                      <?php if($error_name){ ?>
                                          <div class="text-danger"><?php echo $error_name; ?></div>
                                      <?php } ?>
                                  </div>
                                  <?php if($school_id) { ?>
                                      <input type="hidden" name="school_id" value="<?php echo $school_id; ?>" />
                                  <?php } ?>
                            </div>
                            <div class="form-group required">
                                  <label for="input-parent" class="col-sm-2 control-label">Address</label>
                                  <div class="col-sm-10">
                                      <textarea name="address" class="form-control" placeholder="School Address"><?php echo $address; ?></textarea>
                                      <?php if($error_address){ ?>
                                          <div class="text-danger"><?php echo $error_address; ?></div>
                                      <?php } ?>
                                  </div>
                            </div>
                            <div class="form-group">
                                  <label for="input-parent" class="col-sm-2 control-label">Image</label>
                                  <div class="col-sm-10">

                                        <a class="img-thumbnail" href="#" id="thumb-image" data-toggle="image">
                                            <img src="<?php echo ($logo) ? $this->webroot .$logo : $this->webroot .'images/no_image.jpg' ; ?>" width="80px" height="80px">
                                        </a>

                                      <input type="hidden" name="logo" id="input-image" value="<?php echo $logo; ?>" />

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
                            <div class="form-group">
                                  <label for="input-parent" class="col-sm-2 control-label">Description</label>
                                  <div class="col-sm-10">
                                        <textarea name="description" id="input-description" class="form-control" placeholder="Description"><?php echo $description; ?></textarea>
                                  </div>
                            </div>
                            <div class="form-group required">
                                  <label for="input-parent" class="col-sm-2 control-label">Contact Number</label>
                                  <div class="col-sm-8">
                                     <input type="text" name="contact_number" class="form-control" placeholder="Contact" value="<?php echo $contact_number; ?>" />
                                     <?php if($error_contact_number){ ?>
                                        <div class="text-danger"><?php echo $error_contact_number; ?></div>
                                     <?php } ?>
                                  </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade in" id="tab-user">
                            <div class="form-group required">
                                <label for="input-parent" class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="text" name="email" class="form-control" placeholder="Email" value="<?php echo $email; ?>" />
                                    <?php if($error_email){ ?>
                                       <div class="text-danger"><?php echo $error_email; ?></div>
                                    <?php } ?>
                                </div>
                                <?php if($school_id) { ?>
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
                   </div>
              </div>
          </form>
      </div>
   </div>
</div>

<link href="<?php echo $this->webroot; ?>js/summernote//summernote.css" rel="stylesheet" />
<script src="<?php echo $this->webroot; ?>js/summernote/summernote.js" type="text/javascript"></script>

<script>
    $('#input-description').summernote({
        height: 170
    });
</script>

