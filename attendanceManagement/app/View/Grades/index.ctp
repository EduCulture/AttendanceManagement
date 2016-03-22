<div class="page-header">
    <div class="container-fluid">
        <h1><i class="glyphicon glyphicon-stats"></i> Grades</h1>
        <ul class="breadcrumb">
            <li>
                <?php echo $this->Html->link('Home',array('controller' => 'dashboard')); ?>
            </li>
            <li>
                <?php echo $this->Html->link('Grades',array('controller' => 'grades')); ?>
            </li>
        </ul>
        <div class="pull-right">
           <?php echo $this->Html->link('<i class="fa fa-plus"></i>',array('controller' => 'grades','action' => 'add'),array('escape' => false,'data-original-title' => 'Add New','data-toggle' => 'tooltip','class' => 'btn btn-primary')); ?>
           <button onclick="confirm('Delete/Uninstall cannot be undone! Are you sure you want to do this?') ? $('#grade-list').submit() : false;" class="btn btn-danger" title="" data-toggle="tooltip" type="button" data-original-title="Delete"><i class="fa fa-trash-o"></i></button>
        </div>
    </div>
</div>

<?php echo $this->Session->flash(); ?>

<div class="container-fluid">
    <div class="panel panel-default">
          <div class="panel-heading">
              <h3 class="panel-title"><i class="fa fa-list"></i> Grade List</h3>
          </div>
          <div class="panel-body">
              <form id="grade-list" enctype="multipart/form-data" method="post" action="<?php echo $this->webroot.'grades/delete'; ?>">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <td class="text-center" style="width: 1px;"><input type="checkbox" onclick="$('input[name*=\'grade\']').prop('checked', this.checked);"></td>
                                    <td class="text-left">Name</td>
                                    <td class="text-left">Minimum Marks</td>
                                    <td class="text-left">Maximum Marks</td>
                                    <td class="text-center">Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($grades) { ?>
                                    <?php foreach($grades as $grade) { ?>
                                        <tr>
                                            <td class="text-center"><input type="checkbox" value="<?php echo $grade['Grade']['id']; ?>" name="grade_id[]"></td>
                                            <td class="text-left"><?php echo $grade['Grade']['name']; ?></td>
                                            <td class="text-left"><?php echo $grade['Grade']['minimum_mark']; ?></td>
                                            <td class="text-left"><?php echo $grade['Grade']['maximum_mark']; ?></td>
                                            <td class="text-center">
                                               <?php echo $this->Html->link('<i class="fa fa-pencil"></i>',array('controller' => 'grades','action' => 'edit','?' => array('grade_id' => $grade['Grade']['id'])),array('escape' => false ,'class' => 'btn btn-primary','data-original-title' => 'Edit','data-toggle' => 'tooltip')); ?>
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