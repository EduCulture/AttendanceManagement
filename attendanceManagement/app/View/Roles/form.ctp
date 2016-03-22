<div class="page-header">
   <div class="container-fluid">
       <div class="pull-right">
          <button class="btn btn-primary" title="" data-toggle="tooltip" form="form-group" type="submit" data-original-title="Save"><i class="fa fa-save"></i></button>
          <?php echo $this->Html->link('<i class="fa fa-reply"></i>',array('controller' => 'roles','action' => 'index'),array('escape' => false,'data-original-title' => 'Cancel','data-toggle' => 'tooltip','class' => 'btn btn-default')); ?>
       </div>
       <h1>Roles</h1>
       <ul class="breadcrumb">
           <li>
               <?php echo $this->Html->link('Home',array('controller' => 'dashboard')); ?>
           </li>
           <li>
               <?php echo $this->Html->link('Roles',array('controller' => 'roles','action' => 'index')); ?>
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
          <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo (($role_id) ? 'Edit' : 'Add'); ?> Role</h3>
      </div>
      <div class="panel-body">
          <form id="form-group" class="form-horizontal" method="post" action="<?php echo $this->webroot . (($role_id) ? 'roles/edit' : 'roles/add'); ?>" enctype="multipart/form-data">
              <div class="form-group required">
                  <label for="input-parent" class="col-sm-2 control-label">Name</label>
                  <div class="col-sm-10">
                        <input type="text" name="name" class="form-control" placeholder="Role Name" value="<?php echo $name; ?>" />
                        <?php if($error_name){ ?>
                            <div class="text-danger"><?php echo $error_name; ?></div>
                        <?php } ?>
                  </div>
                  <input type="hidden" name="role_id" value="<?php echo $role_id; ?>" />
              </div>
              <div class="form-group required">
                   <label for="input-parent" class="col-sm-2 control-label">Access Permission</label>
                   <div class="col-sm-10">
                        <div class="well well-sm" style="height: 230px; overflow: auto;">
                            <?php foreach($permissions as $controller => $action_array) { ?>
                                <?php
                                    $checked = false;
                                    if($access_permission) {
                                        foreach($access_permission['access'] as $access) {
                                            if($access == $controller) {
                                                $checked = true;
                                                break;
                                            }
                                        }
                                    }
                                ?>
                                <div class="checkbox">
                                    <label><input type="checkbox" <?php echo ($checked) ? 'checked="checked"' : ''; ?> name="permission[access][]" value="<?php echo $controller; ?>" /><?php echo " ".$controller; ?></label>
                                </div>
                                <?php /*
                                <?php foreach($action_array as $action) { ?>
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="permission[access][]" value="<?php echo $controller.'/'.$action; ?>" /><?php echo " ".$controller.'/'.$action; ?></label>
                                    </div>
                                <?php } ?>
                                */ ?>
                            <?php } ?>
                        </div>
                        <a onclick="$(this).parent().find(':checkbox').prop('checked', true);">Select All</a> /
                        <a onclick="$(this).parent().find(':checkbox').prop('checked', false);">Unselect All</a>
                   </div>
              </div>
          </form>
      </div>
   </div>
</div>

