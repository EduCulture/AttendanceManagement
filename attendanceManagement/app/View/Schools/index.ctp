<div class="page-header">
    <div class="container-fluid">
        <h1>Schools</h1>
        <ul class="breadcrumb">
            <li>
                <?php echo $this->Html->link('Home',array('controller' => 'dashboard')); ?>
            </li>
            <li>
                <?php echo $this->Html->link('Schools',array('controller' => 'schools')); ?>
            </li>
        </ul>
        <div class="pull-right">
           <?php echo $this->Html->link('<i class="fa fa-plus"></i>',array('controller' => 'schools','action' => 'add'),array('escape' => false,'data-original-title' => 'Add New','data-toggle' => 'tooltip','class' => 'btn btn-primary')); ?>
           <button onclick="confirm('Delete/Uninstall cannot be undone! Are you sure you want to do this?') ? $('#school-list').submit() : false;" class="btn btn-danger" title="" data-toggle="tooltip" type="button" data-original-title="Delete"><i class="fa fa-trash-o"></i></button>
        </div>
    </div>
</div>

<?php echo $this->Session->flash(); ?>

<div class="container-fluid">
    <div class="panel panel-default">
          <div class="panel-heading">
              <h3 class="panel-title"><i class="fa fa-list"></i> Schools List</h3>
          </div>
          <div class="panel-body">
              <div class="row">
                  <div class="col-sm-12">
                      <div class="panel panel-default">
                         <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-search"></i> Filter</h3>
                            <a data-toggle="collapse" href="#filter-panel" aria-expanded="false" aria-controls="collapseExample"><span class="hidden-xs hidden-sm hidden-md pull-right"><i class="fa fa-list"></i></span> </a>
                            <?php if($is_filter){ ?>
                                <?php echo $this->Html->link('<i class="fa fa-undo"></i>',array('controller' => 'schools','action' => 'index'),array('escape' => false,'data-original-title' => 'Reset Filter','data-toggle' => 'tooltip','class' => 'pull-right','style' => 'margin-right: 15px;')); ?>
                            <?php } ?>
                         </div>
                         <div class="panel-body collapse <?php echo ($is_filter) ? 'in' : ''; ?>" id="filter-panel">
                            <div class="well">
                                <form enctype="multipart/form-data" method="get" action="<?php echo $this->webroot; ?>schools/index">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="input-name" class="control-label">Name</label>
                                                <input type="text" class="form-control" id="input-name" placeholder="Name" value="<?php //echo $searchString; ?>" name="filter_name">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="input-price" class="control-label">Type</label>
                                                <select name="filter_type" class="form-control">
                                                    <option value=""></option>
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
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

              <form id="school-list" enctype="multipart/form-data" method="post" action="<?php echo $this->webroot.'schools/delete'; ?>">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <td class="text-center" style="width: 1px;"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);"></td>
                                    <td class="text-center">School Logo</td>
                                    <td class="text-left">Name</td>
                                    <td class="text-left">Contact Number</td>
                                    <td class="text-left">Active</td>
                                    <td class="text-right">Action</td>
                                </tr>
                            </thead>

                            <tbody>
                                <?php if($schools) { ?>
                                    <?php foreach($schools as $school) { ?>
                                        <tr>
                                            <td class="text-center"><input type="checkbox" value="<?php echo $school['School']['id']; ?>" name="school_id[]"></td>
                                            <td class="text-center">
                                               <?php if($school['School']['logo']) { ?>
                                                  <a href="<?php echo $school['School']['logo']; ?>" data-lightbox="roadtrip">
                                                     <img class="img-thumbnail" width="50" height="50" alt="<?php echo $school['School']['name']; ?>" src="<?php echo $this->webroot.$school['School']['logo']; ?>">
                                                  </a>
                                               <?php } else { ?>
                                                   <img class="img-thumbnail" width="40" height="40" alt="<?php echo $school['School']['name']; ?>" src="<?php echo $this->webroot; ?>images/no_image.jpg">
                                               <?php } ?>
                                            </td>
                                            <td class="text-left"><?php echo $school['School']['name']; ?></td>
                                            <td class="text-left"><?php echo $school['School']['contact_number']; ?></td>
                                            <td class="text-left">
                                                  <?php if($school['School']['is_active']) { ?>
                                                    <span class="label label-success">Yes</span>
                                                  <?php } else { ?>
                                                    <span class="label label-warning">No</span>
                                                  <?php } ?>
                                            </td>
                                            <td class="text-right">
                                               <?php echo $this->Html->link('<i class="fa fa-pencil"></i>',array('controller' => 'schools','action' => 'edit','?' => array('school_id' => $school['School']['id'])),array('escape' => false ,'class' => 'btn btn-primary','data-original-title' => 'Edit','data-toggle' => 'tooltip')); ?>
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
              <div class="row">
                  <div class="col-sm-6 text-left"><?php echo $this->Paginator->numbers(); ?></div>
                  <div class="col-sm-6 text-right">
                      <?php echo $this->Paginator->counter('Showing {:start} to {:end} of {:count} ({:pages} Pages)'); ?>
                  </div>
              </div>
          </div>
    </div>
</div>


<script type="text/javascript" src="<?php echo $this->webroot; ?>js/lightbox/js/lightbox.min.js"></script>
<link href="<?php echo $this->webroot; ?>js/lightbox/css/lightbox.css" rel="stylesheet" />