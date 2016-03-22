<div class="page-header">
    <div class="container-fluid">
        <h1><i class="fa fa-columns"></i> Notice</h1>
        <ul class="breadcrumb">
            <li>
                <?php echo $this->Html->link('Home',array('controller' => 'dashboard')); ?>
            </li>
            <li>
                <?php echo $this->Html->link('Notice',array('controller' => 'notices')); ?>
            </li>
        </ul>
        <div class="pull-right">
           <?php echo $this->Html->link('<i class="fa fa-plus"></i>',array('controller' => 'notices','action' => 'add'),array('escape' => false,'data-original-title' => 'Add New','data-toggle' => 'tooltip','class' => 'btn btn-primary')); ?>
           <button onclick="confirm('Delete/Uninstall cannot be undone! Are you sure you want to do this?') ? $('#notice-list').submit() : false;" class="btn btn-danger" title="" data-toggle="tooltip" type="button" data-original-title="Delete"><i class="fa fa-trash-o"></i></button>
        </div>
    </div>
</div>

<?php echo $this->Session->flash(); ?>

<div class="container-fluid">
    <div class="panel panel-default">
          <div class="panel-heading">
              <h3 class="panel-title"><i class="fa fa-list"></i> Notice List</h3>
          </div>
          <div class="panel-body">
              <form id="notice-list" enctype="multipart/form-data" method="post" action="<?php echo $this->webroot.'notice/delete'; ?>">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <td class="text-center" style="width: 1px;"><input type="checkbox" onclick="$('input[name*=\'notice\']').prop('checked', this.checked);"></td>
                                    <td class="text-left">Title</td>
                                    <td class="text-left">Date</td>
                                    <td class="text-left">User Type</td>
                                    <td class="text-left">Status</td>
                                    <td class="text-right">Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($notices) { ?>
                                    <?php foreach($notices as $notice) { ?>
                                        <tr>
                                            <td class="text-center"><input type="checkbox" value="<?php echo $notice['Notice']['id']; ?>" name="notice_id[]"></td>
                                            <td class="text-left">
                                               <?php echo $notice['Notice']['title']; ?>
                                            </td>
                                            <td class="text-left">
                                               <?php echo date("d-M-Y",strtotime($notice['Notice']['notice_date'])); ?>
                                            </td>
                                            <td class="text-left">
                                                <?php
                                                    if($notice['Notice']['user_type']==1) {
                                                        echo "Student";
                                                    }else if($notice['Notice']['user_type']==2) {
                                                        echo "Staff";
                                                    }else{
                                                        echo "All";
                                                    }
                                                ?>
                                            </td>
                                            <td class="text-left">
                                                  <?php if($notice['Notice']['is_active']) { ?>
                                                     <span class="label label-success">Active</span>
                                                  <?php } else { ?>
                                                     <span class="label label-warning">Inactive</span>
                                                  <?php } ?>
                                            </td>
                                            <td class="text-right">
                                               <?php echo $this->Html->link('<i class="fa fa-pencil"></i>',array('controller' => 'notices','action' => 'edit','?' => array('notice_id' => $notice['Notice']['id'])),array('escape' => false ,'class' => 'btn btn-primary','data-original-title' => 'Edit','data-toggle' => 'tooltip')); ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } else { ?>
                                       <tr>
                                           <td class="text-center" colspan="7">No Records Found</td>
                                       </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
              </form>
          </div>
    </div>
</div>