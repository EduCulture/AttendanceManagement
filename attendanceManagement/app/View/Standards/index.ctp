<div class="page-header">
    <div class="container-fluid">
        <h1>Standards</h1>
        <ul class="breadcrumb">
            <li>
                <?php echo $this->Html->link('Home',array('controller' => 'dashboard')); ?>
            </li>
            <li>
                <?php echo $this->Html->link('Standards',array('controller' => 'standards')); ?>
            </li>
        </ul>
        <div class="pull-right">
           <?php echo $this->Html->link('<i class="fa fa-plus"></i>',array('controller' => 'standards','action' => 'add'),array('escape' => false,'data-original-title' => 'Add New','data-toggle' => 'tooltip','class' => 'btn btn-primary')); ?>
           <button onclick="confirm('Delete/Uninstall cannot be undone! Are you sure you want to do this?') ? $('#standards-list').submit() : false;" class="btn btn-danger" title="" data-toggle="tooltip" type="button" data-original-title="Delete"><i class="fa fa-trash-o"></i></button>
        </div>
    </div>
</div>

<?php echo $this->Session->flash(); ?>

<div class="container-fluid">
    <div class="panel panel-default">
          <div class="panel-heading">
              <h3 class="panel-title"><i class="fa fa-list"></i> Standards List</h3>
          </div>
          <div class="panel-body">
              <?php /*
              <div class="row">
                  <div class="col-sm-12">
                      <div class="panel panel-default">
                         <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-search"></i> Filter</h3>
                            <a data-toggle="collapse" href="#filter-panel" aria-expanded="false" aria-controls="collapseExample"><span class="hidden-xs hidden-sm hidden-md pull-right"><i class="fa fa-list"></i></span> </a>
                            <?php if($is_filter){ ?>
                                <?php echo $this->Html->link('<i class="fa fa-undo"></i>',array('controller' => 'students','action' => 'index'),array('escape' => false,'data-original-title' => 'Reset Filter','data-toggle' => 'tooltip','class' => 'pull-right','style' => 'margin-right: 15px;')); ?>
                            <?php } ?>
                         </div>
                         <div class="panel-body collapse <?php echo ($is_filter) ? 'in' : ''; ?>" id="filter-panel">
                            <div class="well">
                                <form enctype="multipart/form-data" method="get" action="<?php echo $this->webroot; ?>students/index">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="input-name" class="control-label">Name</label>
                                                <input type="text" class="form-control" id="input-name" placeholder="Name" value="<?php //echo $searchString; ?>" name="filter_name">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="input-price" class="control-label">Admission Number</label>
                                                <input type="text" class="form-control" id="input-emp" placeholder="Admission Number" value="<?php //echo $searchString; ?>" name="filter_admission_number">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="input-price" class="control-label">Roll Number</label>
                                                <input type="text" class="form-control" id="input-emp" placeholder="Roll Number" value="<?php //echo $searchString; ?>" name="filter_roll_number">
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
                  </div>
              </div>
              */ ?>

              <form id="standards-list" enctype="multipart/form-data" method="post" action="<?php echo $this->webroot.'standards/delete'; ?>">
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
                                <?php if($standards) { ?>
                                    <?php foreach($standards as $standard) { ?>
                                        <tr>
                                            <td class="text-center"><input type="checkbox" value="<?php echo $standard['Standard']['id']; ?>" name="standard_id[]"></td>
                                            <td class="text-left"><?php echo $standard['Standard']['name']; ?></td>
                                            <?php /*
                                            <td class="text-left">
                                                  <?php if($standard['Standard']['is_active']) { ?>
                                                    <span class="label label-success">Yes</span>
                                                  <?php } else { ?>
                                                    <span class="label label-warning">No</span>
                                                  <?php } ?>
                                            </td>
                                            */ ?>
                                            <td class="text-right">
                                               <?php echo $this->Html->link('<i class="fa fa-pencil"></i>',array('controller' => 'standards','action' => 'edit','?' => array('standard_id' => $standard['Standard']['id'])),array('escape' => false ,'class' => 'btn btn-primary','data-original-title' => 'Edit','data-toggle' => 'tooltip')); ?>
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