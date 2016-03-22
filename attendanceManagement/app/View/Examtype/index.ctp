<div class="page-header">
    <div class="container-fluid">
        <h1><i class="fa fa-book"></i> Exam Type</h1>
        <ul class="breadcrumb">
            <li>
                <?php echo $this->Html->link('Home',array('controller' => 'dashboard')); ?>
            </li>
            <li>
                <?php echo $this->Html->link('Exam Type',array('controller' => 'examtype')); ?>
            </li>
        </ul>
        <div class="pull-right">
           <?php echo $this->Html->link('<i class="fa fa-plus"></i>',array('controller' => 'examtype','action' => 'add'),array('escape' => false,'data-original-title' => 'Add New','data-toggle' => 'tooltip','class' => 'btn btn-primary')); ?>
           <button onclick="confirm('Delete/Uninstall cannot be undone! Are you sure you want to do this?') ? $('#type-list').submit() : false;" class="btn btn-danger" title="" data-toggle="tooltip" type="button" data-original-title="Delete"><i class="fa fa-trash-o"></i></button>
        </div>
    </div>
</div>

<?php echo $this->Session->flash(); ?>

<div class="container-fluid">
    <div class="panel panel-default">
          <div class="panel-heading">
              <h3 class="panel-title"><i class="fa fa-list"></i> Exam type List</h3>
          </div>
          <div class="panel-body">
              <form id="subject-list" enctype="multipart/form-data" method="post" action="<?php echo $this->webroot.'examtype/delete'; ?>">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <td class="text-center" style="width: 1px;"><input type="checkbox" onclick="$('input[name*=\'type\']').prop('checked', this.checked);"></td>
                                    <td class="text-left">Name</td>
                                    <td class="text-right">Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($types) { ?>
                                    <?php foreach($types as $type) { ?>
                                        <tr>
                                            <td class="text-center"><input type="checkbox" value="<?php echo $type['ExamType']['id']; ?>" name="type_id[]"></td>
                                            <td class="text-left"><?php echo $type['ExamType']['name']; ?></td>
                                            <td class="text-right">
                                               <?php echo $this->Html->link('<i class="fa fa-pencil"></i>',array('controller' => 'examtype','action' => 'edit','?' => array('type_id' => $type['ExamType']['id'])),array('escape' => false ,'class' => 'btn btn-primary','data-original-title' => 'Edit','data-toggle' => 'tooltip')); ?>
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