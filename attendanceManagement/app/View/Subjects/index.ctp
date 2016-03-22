<div class="page-header">
    <div class="container-fluid">
        <h1><i class="fa fa-book"></i> Subjects</h1>
        <ul class="breadcrumb">
            <li>
                <?php echo $this->Html->link('Home',array('controller' => 'dashboard')); ?>
            </li>
            <li>
                <?php echo $this->Html->link('Subjects',array('controller' => 'subjects')); ?>
            </li>
        </ul>
        <div class="pull-right">
           <?php echo $this->Html->link('<i class="fa fa-plus"></i>',array('controller' => 'subjects','action' => 'add'),array('escape' => false,'data-original-title' => 'Add New','data-toggle' => 'tooltip','class' => 'btn btn-primary')); ?>
           <button onclick="confirm('Delete/Uninstall cannot be undone! Are you sure you want to do this?') ? $('#subject-list').submit() : false;" class="btn btn-danger" title="" data-toggle="tooltip" type="button" data-original-title="Delete"><i class="fa fa-trash-o"></i></button>
        </div>
    </div>
</div>

<?php echo $this->Session->flash(); ?>

<div class="container-fluid">
    <div class="panel panel-default">
          <div class="panel-heading">
              <h3 class="panel-title"><i class="fa fa-list"></i> Subject List</h3>
          </div>
          <div class="panel-body">
              <form id="subject-list" enctype="multipart/form-data" method="post" action="<?php echo $this->webroot.'subjects/delete'; ?>">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <td class="text-center" style="width: 1px;"><input type="checkbox" onclick="$('input[name*=\'subject\']').prop('checked', this.checked);"></td>
                                    <td class="text-center">Logo</td>
                                    <td class="text-left">Name</td>
                                    <td class="text-left">Active</td>
                                    <td class="text-right">Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($subjects) { ?>
                                    <?php foreach($subjects as $subject) { ?>
                                        <tr>
                                            <td class="text-center"><input type="checkbox" value="<?php echo $subject['Subject']['id']; ?>" name="subject_id[]"></td>
                                            <td class="text-center">
                                               <?php if($subject['Subject']['logo']) { ?>
                                                  <a href="<?php echo $subject['Subject']['logo']; ?>" data-lightbox="roadtrip">
                                                     <img class="img-thumbnail" width="50" height="50" alt="<?php echo $subject['Subject']['name']; ?>" src="<?php echo $this->webroot.$subject['Subject']['logo']; ?>">
                                                  </a>
                                               <?php } else { ?>
                                                   <img class="img-thumbnail" width="40" height="40" alt="<?php echo $subject['Subject']['name']; ?>" src="<?php echo $this->webroot; ?>images/no_image.jpg">
                                               <?php } ?>
                                            </td>
                                            <td class="text-left"><?php echo $subject['Subject']['name']; ?></td>
                                            <td class="text-left">
                                                  <?php if($subject['Subject']['is_active']) { ?>
                                                    <span class="label label-success">Yes</span>
                                                  <?php } else { ?>
                                                    <span class="label label-warning">No</span>
                                                  <?php } ?>
                                            </td>
                                            <td class="text-right">
                                               <?php echo $this->Html->link('<i class="fa fa-pencil"></i>',array('controller' => 'subjects','action' => 'edit','?' => array('subject_id' => $subject['Subject']['id'])),array('escape' => false ,'class' => 'btn btn-primary','data-original-title' => 'Edit','data-toggle' => 'tooltip')); ?>
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