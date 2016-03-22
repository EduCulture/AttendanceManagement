<div class="page-header">
    <div class="container-fluid">
        <h1>Fees</h1>
        <ul class="breadcrumb">
            <li>
                <?php echo $this->Html->link('Home',array('controller' => 'dashboard')); ?>
            </li>
            <li>
                <?php echo $this->Html->link('Fees',array('controller' => 'fees')); ?>
            </li>
        </ul>
        <div class="pull-right">
           <?php echo $this->Html->link('<i class="fa fa-plus"></i>',array('controller' => 'fees','action' => 'add'),array('escape' => false,'data-original-title' => 'Add New','data-toggle' => 'tooltip','class' => 'btn btn-primary')); ?>
           <button onclick="confirm('Delete/Uninstall cannot be undone! Are you sure you want to do this?') ? $('#fee-list').submit() : false;" class="btn btn-danger" title="" data-toggle="tooltip" type="button" data-original-title="Delete"><i class="fa fa-trash-o"></i></button>
        </div>
    </div>
</div>

<?php echo $this->Session->flash(); ?>

<div class="container-fluid">
    <div class="panel panel-default">
          <div class="panel-heading">
              <h3 class="panel-title"><i class="fa fa-list"></i> Fee List</h3>
          </div>
          <div class="panel-body">


              <form id="fee-list" enctype="multipart/form-data" method="post" action="<?php echo $this->webroot.'fee/delete'; ?>">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <td class="text-center" style="width: 1px;"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);"></td>
                                    <td class="text-left">Name</td>
                                    <td class="text-right">Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($fees) { ?>
                                    <?php foreach($fees as $fee) { ?>
                                        <tr>
                                            <td class="text-center"><input type="checkbox" value="<?php echo $fee['Fee']['id']; ?>" name="fee_id[]"></td>
                                            <td class="text-left"><?php echo $fee['Fee']['name']; ?></td>
                                            <td class="text-right">
                                               <?php echo $this->Html->link('<i class="fa fa-pencil"></i>',array('controller' => 'fees','action' => 'edit','?' => array('fee_id' => $fee['Fee']['id'])),array('escape' => false ,'class' => 'btn btn-primary','data-original-title' => 'Edit','data-toggle' => 'tooltip')); ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } else { ?>
                                       <tr>
                                           <td class="text-center" colspan="4">No Records Found</td>
                                       </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
              </form>
          </div>
    </div>
</div>