<div class="page-header">
      <div class="container-fluid">
          <div class="pull-right">
              <button class="btn btn-primary" title="" data-toggle="tooltip" form="form-allopathy" type="submit" data-original-title="Save"><i class="fa fa-save"></i></button>
              <a class="btn btn-default" title="" data-toggle="tooltip" href="index" data-original-title="Cancel"><i class="fa fa-reply"></i></a>
          </div>
          <h1>User</h1>
          <ul class="breadcrumb">
              <li><a href="dashboard.php">Home</a></li>
              <li><a href="users.php">Users</a></li>
          </ul>

          <?php if(isset($warning)) { ?>
              <div class="alert alert-danger">
                  <i class="fa fa-exclamation-circle"></i> <?php echo $warning; ?><button data-dismiss="alert" class="close" type="button">×</button>
              </div>
          <?php } ?>
      </div>
  </div>
  <div class="container-fluid">
      <div class="panel panel-default">
          <div class="panel-heading">
              <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo ucfirst($opr); ?> User</h3>
          </div>
          <div class="panel-body">

              <form id="form-allopathy" class="form-horizontal" method="post" enctype="multipart/form-data">

                  <div class="form-group required">
                      <label for="input-parent" class="col-sm-2 control-label">First Name</label>
                      <div class="col-sm-10">
                          <input type="text" name="first_name" class="form-control" placeholder="First" value="<?php echo isset($user['first_name']) ? $user['first_name'] : ''; ?>" />
                          <?php if(isset($name_error)){ ?>
                              <div class="text-danger"><?php echo $name_error; ?></div>
                          <?php } ?>
                      </div>
                  </div>
                  <!--<div class="form-group">
                      <label for="input-parent" class="col-sm-2 control-label">Middle Name</label>
                      <div class="col-sm-10">
                          <input type="text" name="middle_name" class="form-control" placeholder="Middle" value="" />
                      </div>
                  </div>-->
                  <div class="form-group">
                      <label for="input-parent" class="col-sm-2 control-label">Last Name</label>
                      <div class="col-sm-10">
                          <input type="text" name="last_name" class="form-control" placeholder="Last" value="<?php echo isset($user['last_name']) ? $user['last_name'] : ''; ?>" />
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
                          <input type="text" name="email" class="form-control" placeholder="Email" <?php echo ($opr=='edit') ? 'readonly' : ''; ?> value="<?php echo isset($user['email']) ? $user['email'] : ''; ?>" />
                          <?php if(isset($email_error)){ ?>
                              <div class="text-danger"><?php echo $email_error; ?></div>
                          <?php } ?>
                      </div>
                  </div>
                  <div class="form-group required">
                      <label for="input-parent" class="col-sm-2 control-label">Password</label>
                      <div class="col-sm-10">
                          <input type="password" name="password" class="form-control" placeholder="Password" <?php echo ($opr=='edit') ? 'readonly' : ''; ?> value="<?php echo isset($user['password']) ? $user['password'] : ''; ?>" />
                          <?php if(isset($password_error)){ ?>
                              <div class="text-danger"><?php echo $password_error; ?></div>
                          <?php } ?>
                      </div>
                  </div>

                  <div class="form-group required">
                      <label for="input-parent" class="col-sm-2 control-label">Role</label>
                      <div class="col-sm-10">
                          <select name="role_id" class="form-control">
                           <option value="1">Super Admin</option>
                            <option value="2">Admin</option>
                            <option value="3">Simple User</option>
                            </select>
                      </div>
                  </div>
              </form>
          </div>
      </div>
  </div>