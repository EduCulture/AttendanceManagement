<div class="page-header">
    <div class="container-fluid">
        <h1>Roles</h1>
        <ul class="breadcrumb">
            <li>
                <?php echo $this->Html->link('Home',array('controller' => 'dashboard')); ?>
            </li>
            <li>
                <?php echo $this->Html->link('Roles',array('controller' => 'roles')); ?>
            </li>
        </ul>
        <div class="pull-right">
           <?php echo $this->Html->link('<i class="fa fa-plus"></i> Add',array('controller' => 'roles','action' => 'add'),array('escape' => false,'data-original-title' => 'Add New','data-toggle' => 'tooltip','class' => 'btn btn-primary')); ?>
           <button onclick="confirm('Delete/Uninstall cannot be undone! Are you sure you want to do this?') ? $('#role-list').submit() : false;" class="btn btn-danger" title="" data-toggle="tooltip" type="button" data-original-title="Delete"><i class="fa fa-trash-o"></i> Delete</button>
        </div>
    </div>
</div>

<?php echo $this->Session->flash(); ?>

<div class="container-fluid">
    <div class="panel panel-default">
          <div class="panel-heading">
              <h3 class="panel-title"><i class="fa fa-list"></i> Roles List</h3>
          </div>
          <div class="panel-body">

              <form id="role-list" enctype="multipart/form-data" method="post" action="<?php echo $this->webroot.'roles/delete'; ?>">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <td class="text-center" style="width: 1px;"><input type="checkbox" onclick="$('input[name*=\'group\']').prop('checked', this.checked);"></td>
                                    <td class="text-left">Name</td>
                                    <td class="text-right">Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($roles) { ?>
                                    <?php foreach($roles as $role) { ?>
                                        <tr>
                                            <td class="text-center"><input type="checkbox" value="<?php echo $role['Role']['id']; ?>" name="group_id[]"></td>
                                            <td class="text-left"><?php echo $role['Role']['name']; ?></td>
                                            <td class="text-right">
                                               <?php echo $this->Html->link('<i class="fa fa-pencil"></i>',array('controller' => 'roles','action' => 'edit','?' => array('role_id' => $role['Role']['id'])),array('escape' => false ,'class' => 'btn btn-primary','data-original-title' => 'Edit','data-toggle' => 'tooltip')); ?>
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
              </form>
          </div>
    </div>
</div>