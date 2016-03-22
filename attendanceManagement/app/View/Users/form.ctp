<div class="page-header">
      <div class="container-fluid">
          <div class="pull-right">
              <button class="btn btn-primary" title="" data-toggle="tooltip" form="form-user" type="submit" data-original-title="Save"><i class="fa fa-save"></i></button>
              <a class="btn btn-default" title="" data-toggle="tooltip" href="index" data-original-title="Cancel"><i class="fa fa-reply"></i></a>
          </div>
          <h1>User</h1>
          <ul class="breadcrumb">
              <li>
                  <?php echo $this->Html->link('Home',array('controller' => 'dashboard')); ?>
              </li>
              <li>
                  <?php echo $this->Html->link('Users',array('controller' => 'users','action' => 'index')); ?>
              </li>
          </ul>
      </div>
  </div>
  <div class="container-fluid">
      <div class="panel panel-default">
          <div class="panel-heading">
              <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo (($user_id) ? 'Edit' : 'Add'); ?> User</h3>
          </div>
          <div class="panel-body">
              <form id="form-user" class="form-horizontal" method="post" action="<?php echo $this->webroot . (($user_id) ? 'users/edit' : 'users/add'); ?>" enctype="multipart/form-data">
                  <div class="form-group required">
                      <label for="input-parent" class="col-sm-2 control-label">First Name</label>
                      <div class="col-sm-10">
                          <input type="text" name="first_name" class="form-control" placeholder="First" value="<?php echo $first_name; ?>" />
                          <?php if($error_first_name){ ?>
                              <div class="text-danger"><?php echo $error_first_name; ?></div>
                          <?php } ?>

                          <input type="hidden" name="user_id" value="<?php echo $user_id; ?>" />
                      </div>
                  </div>
                  <div class="form-group">
                      <label for="input-parent" class="col-sm-2 control-label">Last Name</label>
                      <div class="col-sm-10">
                          <input type="text" name="last_name" class="form-control" placeholder="Last" value="<?php echo $last_name; ?>" />
                      </div>
                  </div>
                  <!--<div class="form-group required">
                      <label for="input-parent" class="col-sm-2 control-label">User Name</label>
                      <div class="col-sm-10">
                          <input type="text" name="user_name" class="form-control" placeholder="User Name" value="" />
                      </div>
                  </div>-->
                  <div class="form-group required">
                      <label for="input-parent" class="col-sm-2 control-label">Email</label>
                      <div class="col-sm-10">
                          <input type="text" name="email" class="form-control" placeholder="Email" value="<?php echo $email; ?>" />
                          <?php if($error_email){ ?>
                              <div class="text-danger"><?php echo $error_email; ?></div>
                          <?php } ?>
                      </div>
                  </div>
                  <div class="form-group required">
                      <label for="input-parent" class="col-sm-2 control-label">Password</label>
                      <div class="col-sm-10">
                          <input type="password" name="password" class="form-control" placeholder="Password"/>
                          <?php if($error_password){ ?>
                              <div class="text-danger"><?php echo $error_password; ?></div>
                          <?php } ?>
                      </div>
                  </div>
                  <div class="form-group required">
                      <label for="input-parent" class="col-sm-2 control-label">Role</label>
                      <div class="col-sm-10">
                          <select name="role_id" class="form-control">
                             <?php foreach($roles as $role) { ?>
                                <option value="<?php echo $role['Role']['id']; ?>" <?php echo ($role_id == $role['Role']['id']) ? 'selected="selected"' : ''; ?> ><?php echo $role['Role']['role_name']; ?></option>
                             <?php } ?>
                          </select>
                      </div>
                  </div>
              </form>
          </div>
      </div>
  </div>