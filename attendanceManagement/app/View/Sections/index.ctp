<div class="page-header">
    <div class="container-fluid">
        <h1>Batch</h1>
        <ul class="breadcrumb">
            <li>
                <?php echo $this->Html->link('Home',array('controller' => 'dashboard')); ?>
            </li>
            <li>
                <?php echo $this->Html->link('Batchs',array('controller' => 'sections')); ?>
            </li>
        </ul>
        <div class="pull-right">
           <?php echo $this->Html->link('<i class="fa fa-plus"></i>',array('controller' => 'sections','action' => 'add'),array('escape' => false,'data-original-title' => 'Add New','data-toggle' => 'tooltip','class' => 'btn btn-primary')); ?>
           <button onclick="confirm('Delete/Uninstall cannot be undone! Are you sure you want to do this?') ? $('#sections-list').submit() : false;" class="btn btn-danger" title="" data-toggle="tooltip" type="button" data-original-title="Delete"><i class="fa fa-trash-o"></i></button>
        </div>
    </div>
</div>

<?php echo $this->Session->flash(); ?>

<div class="container-fluid">
    <div class="panel panel-default">
          <div class="panel-heading">
              <h3 class="panel-title"><i class="fa fa-list"></i> Batch List</h3>
          </div>
          <div class="panel-body">
              <form id="sections-list" enctype="multipart/form-data" method="post" action="<?php echo $this->webroot.'sections/delete'; ?>">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <td class="text-center" style="width: 1px;"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);"></td>
                                    <td class="text-left">Name</td>
                                    <td class="text-left">Active</td>
                                    <td class="text-right">Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($sections) { ?>
                                    <?php foreach($sections as $section) { ?>
                                        <tr>
                                            <td class="text-center"><input type="checkbox" value="<?php echo $section['Section']['id']; ?>" name="section_id[]"></td>
                                            <td class="text-left"><?php echo $section['Section']['name']; ?></td>
                                            <td class="text-left">
                                                  <?php if($section['Section']['is_active']) { ?>
                                                    <span class="label label-success">Yes</span>
                                                  <?php } else { ?>
                                                    <span class="label label-warning">No</span>
                                                  <?php } ?>
                                            </td>
                                            <td class="text-right">
                                               <?php echo $this->Html->link('<i class="fa fa-pencil"></i>',array('controller' => 'sections','action' => 'edit','?' => array('section_id' => $section['Section']['id'])),array('escape' => false ,'class' => 'btn btn-primary','data-original-title' => 'Edit','data-toggle' => 'tooltip')); ?>
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