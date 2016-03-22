<div class="page-header">
   <div class="container-fluid">
       <h1><i class="fa fa-users"></i> Users</h1>
       <ul class="breadcrumb">
          <li>
              <?php echo $this->Html->link('Home',array('controller' => 'dashboard')); ?>
          </li>
          <li>
              <?php echo $this->Html->link('Users',array('controller' => 'users')); ?>
          </li>
       </ul>

       <div class="pull-right">
          <button class="btn btn-success" title="" data-toggle="tooltip" form="users-form" type="submit" data-original-title="Save Permission"><i class="fa fa-save"></i></button>
          <a class="btn btn-primary" title="" data-toggle="tooltip" href="users/add" data-original-title="Add New User"><i class="fa fa-plus"></i></a>
          <button onclick="confirm('Delete/Uninstall cannot be undone! Are you sure you want to do this?') ? $('#permission-form').submit() : false;" class="btn btn-danger" title="" data-toggle="tooltip" type="button" data-original-title="Delete User"><i class="fa fa-trash-o"></i></button>
       </div>
   </div>
</div>

<?php echo $this->Session->flash(); ?>

<div class="container-fluid">
  <div class="panel panel-default">
      <div class="panel-heading">
          <h3 class="panel-title"><i class="fa fa-list"></i> Users List</h3>
      </div>
      <div class="panel-body">

          <div class="panel panel-default">

              <div class="panel-heading">
                  <h3 class="panel-title"><i class="fa fa-search"></i> Filter</h3>
                  <a data-toggle="collapse" href="#filter-panel" aria-expanded="false" aria-controls="collapseExample"><span class="hidden-xs hidden-sm hidden-md pull-right"><i class="fa fa-list"></i></span> </a>
                  <?php if($is_filter){ ?>
                      <?php echo $this->Html->link('<i class="fa fa-undo"></i>',array('controller' => 'users','action' => 'index'),array('escape' => false,'data-original-title' => 'Reset Filter','data-toggle' => 'tooltip','class' => 'pull-right','style' => 'margin-right: 15px;')); ?>
                  <?php } ?>
              </div>
              <div class="panel-body collapse <?php echo ($is_filter) ? 'in' : ''; ?>" id="filter-panel">
                  <div class="well">
                      <form enctype="multipart/form-data" method="get" action="<?php echo $this->webroot; ?>users/index">
                          <div class="row">
                              <?php /*
                              <div class="col-sm-4">
                                  <div class="form-group">
                                      <label for="input-name" class="control-label">Role</label>
                                      <select name="filter_role_id" class="form-control">
                                          <option value=""></option>
                                          <?php if($roles) { ?>
                                            <?php foreach($roles as $role) { ?>
                                                  <option value="<?php echo $role['Role']['id'];?>" <?php echo ($filter_role_id==$role['Role']['role_id']) ? "selected='selected'" : '';?> ><?php echo $role['Role']['role_name'];?></option>
                                            <?php } ?>
                                          <?php } ?>
                                      </select>
                                  </div>
                              </div>
                              */ ?>
                              <div class="col-sm-4">
                                  <div class="form-group">
                                      <label class="control-label">Email</label>
                                      <input type="text" class="form-control" id="input-name" placeholder="Email" value="<?php echo $filter_email; ?>" name="filter_email">
                                  </div>
                              </div>
                              <div class="col-sm-4">
                                  <div class="form-group">
                                      <button class="btn btn-primary pull-left" style="margin-top:20px;" id="button-filter" type="submit"><i class="fa fa-search"></i> Filter</button>
                                  </div>
                              </div>
                          </div>
                      </form>
                  </div>
              </div>
          </div>

          <form id="users-form" enctype="multipart/form-data" method="post" action="<?php echo $this->webroot.'users/delete'; ?>" class="form-horizontal">
              <div role="tabpanel">
                  <ul class="nav nav-tabs" role="tablist">
                      <li role="presentation"  class="active"><a href="#tab-user" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-users"></i> Users</a></li>
                      <li role="presentation"><a href="#tab-permission" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-gear"></i> Permission</a></li>
                  </ul>
                  <div class="tab-content">
                      <div role="tabpanel" class="tab-pane fade in active" id="tab-user">

                          <div class="row" style="margin-right: 3px; margin-top: -15px;">
                              <div class="pull-right"><?php echo $this->Paginator->numbers(); ?></div>
                          </div>

                          <div class="table-responsive">
                              <table class="table table-bordered table-hover">
                                  <thead>
                                      <tr>
                                          <td class="text-center" style="width: 1px;"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);"></td>
                                          <td class="text-left">Name</td>
                                          <td class="text-left">Email</td>
                                          <td class="text-left">Role</td>
                                          <td class="text-right">Action</td>
                                      </tr>
                                  </thead>

                                  <tbody>
                                      <?php if($users) { ?>
                                          <?php foreach($users as $user) { ?>
                                              <tr>
                                                  <td class="text-center"><input type="checkbox" value="<?php echo $user['User']['id']; ?>" name="user_id[]"></td>
                                                  <td class="text-left"><?php echo ($user['User']['first_name'].' '.$user['User']['last_name']); ?></td>
                                                  <td class="text-left"><?php echo $user['User']['mail_id']; ?></td>
                                                  <td class="text-left">
                                                      <span class="label label-success"><?php echo $user['Role']['role_name']; ?></span>
                                                  </td>
                                                  <td class="text-right">
                                                      <a class="btn btn-primary" title="" data-toggle="tooltip" href="users/add?user_id=<?php echo $user['User']['id']; ?>" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                                                  </td>
                                              </tr>
                                          <?php } ?>
                                      <?php } else { ?>
                                          <tr>
                                              <td class="text-center" colspan="6">No Records Found</td>
                                          </tr>
                                      <?php } ?>
                                  </tbody>
                              </table>
                          </div>

                          <div class="row">
                              <div class="col-sm-6 text-left"><?php echo $this->Paginator->numbers(); ?></div>
                              <div class="col-sm-6 text-right">
                                <?php echo $this->Paginator->counter('Showing {:start} to {:end} of {:count} ({:pages} Pages)'); ?>
                              </div>
                          </div>
                      </div>

                      <div role="tabpanel" class="tab-pane fade" id="tab-permission">
                          <div class="form-group">
                              <label for="input-parent" class="col-sm-2 control-label">Select Role</label>
                              <input type="hidden" name="btnsubmit" value="submit" />
                              <div class="col-sm-6">
                                  <select name="role_id" id="role-dropdown" class="form-control" onchange="getRolePermission(this.value)">
                                      <?php foreach($roles as $role){ ?>
                                          <option value="<?php echo $role['Role']['id']; ?>"><?php echo $role['Role']['role_name']; ?></option>
                                      <?php } ?>
                                  </select>
                              </div>
                          </div>
                          <div id="rolediv">

                          </div>
                      </div>
                  </div>
              </div>
          </form>

      </div>
  </div>
</div>

<script src="<?php echo $this->webroot; ?>js/blockui.js" type="text/javascript"></script>
<script>

    $('document').ready(function(){
        getRolePermission($('#role-dropdown').val());
    });

    $(document).ajaxStop($.unblockUI);

    function getRolePermission(role_id){
        $.ajax({
            type : "POST",
            url: '<?php echo $this->webroot;?>users/getRolePermission',
            dataType : "html",
            data: { role_id: $("#role-dropdown").val()},
            beforeSend : function(){
                $.blockUI({message: '<h4><img src="<?php echo $this->webroot; ?>images/loader.gif" />  Just a moment...</h4>'});
            },
            success: function(data){
                //alert(data);
                $('#rolediv').html(data);
            }
        });
    }

</script>





