<div class="page-header">
    <div class="container-fluid">
        <h1><i class="fa fa-user-md"></i> Staffs</h1>
        <ul class="breadcrumb">
            <li>
                <?php echo $this->Html->link('Home',array('controller' => 'dashboard')); ?>
            </li>
            <li>
                <?php echo $this->Html->link('Staffs',array('controller' => 'staffs')); ?>
            </li>
        </ul>
        <div class="pull-right">
           <?php echo $this->Html->link('<i class="fa fa-plus"></i> Add',array('controller' => 'staffs','action' => 'add'),array('escape' => false,'data-original-title' => 'Add New','data-toggle' => 'tooltip','class' => 'btn btn-primary')); ?>
           <button onclick="confirm('Delete/Uninstall cannot be undone! Are you sure you want to do this?') ? $('#staff-list').submit() : false;" class="btn btn-danger" title="" data-toggle="tooltip" type="button" data-original-title="Delete"><i class="fa fa-trash-o"></i> Delete</button>
        </div>
    </div>
</div>

<?php echo $this->Session->flash(); ?>

<div class="container-fluid">
    <div class="panel panel-default">
          <div class="panel-heading">
              <h3 class="panel-title"><i class="fa fa-list"></i> Staff List</h3>
          </div>
          <div class="panel-body">
              <div class="row">
                  <div class="col-sm-12">
                      <div class="panel panel-default">
                         <div class="panel-heading">
                            <a data-toggle="collapse" href="#filter-panel" aria-expanded="false" aria-controls="collapseExample">
                               <h3 class="panel-title"><i class="fa fa-search"></i> Filter</h3>
                            </a>
                            <?php if($is_filter){ ?>
                                <?php echo $this->Html->link('<i class="fa fa-undo"></i>',array('controller' => 'staffs','action' => 'index'),array('escape' => false,'data-original-title' => 'Reset Filter','data-toggle' => 'tooltip','class' => 'pull-right','style' => 'margin-right: 15px;')); ?>
                            <?php } ?>
                         </div>
                         <div class="panel-body collapse in" id="filter-panel">
                            <div class="well">
                                <form enctype="multipart/form-data" method="get" action="<?php echo $this->webroot; ?>staffs/index">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="input-name" class="control-label">Name</label>
                                                <input type="text" class="form-control" id="input-name" placeholder="Name" value="<?php //echo $searchString; ?>" name="filter_name">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="input-price" class="control-label">Employee Id</label>
                                                <input type="text" class="form-control" id="input-emp" placeholder="Employee Id" value="<?php //echo $searchString; ?>" name="filter_emp_id">
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

              <form id="staff-list" enctype="multipart/form-data" method="post" action="<?php echo $this->webroot.'staffs/delete'; ?>">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <td class="text-center" style="width: 1px;"><input type="checkbox" onclick="$('input[name*=\'staff\']').prop('checked', this.checked);"></td>
                                    <td class="text-left">Name</td>
                                    <td class="text-left">Employee Id</td>
                                    <td class="text-left">Type</td>
                                    <td class="text-left">Contact Number</td>
                                    <td class="text-right">Action</td>
                                </tr>
                            </thead>

                            <tbody>
                                <?php if($staffs) { ?>
                                    <?php foreach($staffs as $staff) { ?>
                                        <tr>
                                            <td class="text-center"><input type="checkbox" value="<?php echo $staff['Staff']['id']; ?>" name="staff_id[]"></td>
                                            <td class="text-left"><?php echo ($staff['Staff']['first_name'].' '.$staff['Staff']['last_name']); ?></td>
                                            <td class="text-left"><?php echo $staff['Staff']['emp_id']; ?></td>
                                            <td class="text-left">
                                                  <?php if($staff['Staff']['type']) { ?>
                                                    <span class="label label-success">Teaching</span>
                                                  <?php } else { ?>
                                                    <span class="label label-warning">Non-Teaching</span>
                                                  <?php } ?>
                                            </td>
                                            <td class="text-left"><?php echo $staff['Staff']['contact_number']; ?></td>
                                            <td class="text-right">
                                               <?php echo $this->Html->link('<i class="fa fa-eye"></i> View Profile',array('controller' => 'staffs','action' => 'profile','?' => array('staff_id' => $staff['Staff']['id'])),array('escape' => false ,'class' => 'btn btn-warning','data-original-title' => 'View Profile','data-toggle' => 'tooltip')); ?>
                                               <?php echo $this->Html->link('<i class="fa fa-pencil"></i> Edit',array('controller' => 'staffs','action' => 'edit','?' => array('staff_id' => $staff['Staff']['id'])),array('escape' => false ,'class' => 'btn btn-primary','data-original-title' => 'Edit','data-toggle' => 'tooltip')); ?>
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