<div class="page-header">
    <div class="container-fluid">
        <h1><i class="fa fa-users"></i> Students</h1>
        <ul class="breadcrumb">
            <li>
                <?php echo $this->Html->link('Home',array('controller' => 'dashboard')); ?>
            </li>
            <li>
                <?php echo $this->Html->link('Students',array('controller' => 'students')); ?>
            </li>
        </ul>
        <div class="pull-right">
           <button onclick="openDialogue()" class="btn btn-success" title="" data-toggle="tooltip" type="button" data-original-title="Import Excel"><i class="fa fa-upload"></i> Import Students</button>
           <?php echo $this->Html->link('<i class="fa fa-plus"></i> Add',array('controller' => 'students','action' => 'add'),array('escape' => false,'data-original-title' => 'Add New','data-toggle' => 'tooltip','class' => 'btn btn-primary')); ?>
           <button onclick="confirm('Delete/Uninstall cannot be undone! Are you sure you want to do this?') ? $('#students-list').submit() : false;" class="btn btn-danger" title="" data-toggle="tooltip" type="button" data-original-title="Delete"><i class="fa fa-trash-o"></i> Delete</button>
        </div>
    </div>
</div>

<?php echo $this->Session->flash(); ?>

<div class="container-fluid">
    <div class="panel panel-default">
          <div class="panel-heading">
              <h3 class="panel-title"><i class="fa fa-list"></i> Students List</h3>
          </div>
          <div class="panel-body">
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
                                                <label for="input-price" class="control-label">Standard</label>
                                                <select name="filter_standard" onchange="getDivisions(this.value)" class="form-control" id="standard-dropdown">
                                                   <option value="" selected="selected">---Please Select---</option>
                                                   <?php foreach($standards as $standard) { ?>
                                                       <option value="<?php echo $standard['Standard']['id']; ?>"><?php echo $standard['Standard']['name']; ?></option>
                                                   <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="input-price" class="control-label">Division</label>
                                                <select class="form-control" name="filter_division" onchange="getStudents(this.value)" id="section-dropdown">

                                                </select>
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

              <form id="students-list" enctype="multipart/form-data" method="post" action="<?php echo $this->webroot.'students/delete'; ?>">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <td class="text-center" style="width: 1px;"><input type="checkbox" onclick="$('input[name*=\'student_id\']').prop('checked', this.checked);"></td>
                                    <td class="text-center">Image</td>
                                    <td class="text-left">Name</td>
                                    <td class="text-left">Standard</td>
                                    <td class="text-left">Roll Number</td>
                                    <td class="text-left">Gender</td>
                                    <td class="text-left">Contact Number</td>
                                    <td class="text-right">Action</td>
                                </tr>
                            </thead>

                            <tbody>
                                <?php if($students) { ?>
                                    <?php foreach($students as $student) { ?>
                                        <tr>
                                            <td class="text-center"><input type="checkbox" value="<?php echo $student['Student']['id']; ?>" name="student_id[]"></td>
                                            <td class="text-center">
                                               <?php if($student['Student']['profile_pic']) { ?>
                                                  <a href="<?php echo $student['Student']['profile_pic']; ?>" data-lightbox="roadtrip">
                                                     <img class="img-thumbnail" width="50" height="50" alt="<?php echo $student['Student']['first_name']; ?>" src="<?php echo $this->webroot.$student['Student']['profile_pic']; ?>">
                                                  </a>
                                               <?php } else { ?>
                                                   <img class="img-thumbnail" width="40" height="40" alt="<?php echo $student['Student']['first_name']; ?>" src="<?php echo $this->webroot; ?>images/no_image.jpg">
                                               <?php } ?>
                                            </td>
                                            <td class="text-left"><?php echo ($student['Student']['first_name'].' '.$student['Student']['last_name']); ?></td>
                                            <td class="text-left"><?php echo $student['Standard']['name'].' - '.$student['Section']['name']; ?></td>
                                            <td class="text-left"><?php echo $student['Student']['roll_number']; ?></td>
                                            <td class="text-left">
                                                  <?php if($student['Student']['gender']) { ?>
                                                    <span class="label label-success">Male</span>
                                                  <?php } else { ?>
                                                    <span class="label label-warning">Female</span>
                                                  <?php } ?>
                                            </td>
                                            <td class="text-left"><?php echo $student['Student']['contact_number']; ?></td>
                                            <td class="text-right">
                                               <?php echo $this->Html->link('<i class="fa fa-eye"></i> View Profile ',array('controller' => 'students','action' => 'profile','?' => array('student_id' => $student['Student']['id'])),array('escape' => false ,'class' => 'btn btn-warning','data-original-title' => 'View Profile','data-toggle' => 'tooltip')); ?>
                                               <?php echo $this->Html->link('<i class="fa fa-pencil"></i> Edit',array('controller' => 'students','action' => 'edit','?' => array('student_id' => $student['Student']['id'])),array('escape' => false ,'class' => 'btn btn-primary','data-original-title' => 'Edit','data-toggle' => 'tooltip')); ?>
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
              <div class="row">
                  <div class="col-sm-6 text-left"><?php echo $this->Paginator->numbers(); ?></div>
                  <div class="col-sm-6 text-right">
                      <?php echo $this->Paginator->counter('Showing {:start} to {:end} of {:count} ({:pages} Pages)'); ?>
                  </div>
              </div>
          </div>
    </div>
</div>


<div class="modal fade" id="modal-import" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
           <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"> Import Students </h4>
           </div>
           <div class="modal-body">
              <form class="form-horizontal">
                  <div class="form-group required">
                      <label for="input-parent" class="col-sm-3 control-label">Select file</label>
                      <div class="col-sm-9">
                          <input type="file" name="file" id="excel-upload" />
                          <span id="lblerroruploader"></span>
                      </div>
                  </div>
              </form>
           </div>
           <div class="modal-footer">
              <button type="button" id="btn-submit" class="btn btn-primary"> Submit</button>
           </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="<?php echo $this->webroot; ?>js/lightbox/js/lightbox.min.js"></script>
<link href="<?php echo $this->webroot; ?>js/lightbox/css/lightbox.css" rel="stylesheet" />

<script>

  function openDialogue() {
      $('#modal-import').modal('show');
  }

  $("#excel-upload").change(function () {
      var ext = this.value.match(/\.(.+)$/)[1];
      switch (ext) {
          case 'xls':
          case 'xlsx':
              $("#lblerroruploader").removeClass('text-danger');
              $("#lblerroruploader").html('');
              break;
          default:
              $("#lblerroruploader").addClass('text-danger');
              $("#lblerroruploader").html('Only excel file allowed');
              this.value = '';
      }
  });

  $('#btn-submit').click(function() {
      validateForm();
  });

  function validateForm(){

      if($("#excel-upload").val()==""){
          $("#lblerroruploader").addClass('text-danger');
          $("#lblerroruploader").html('Please select the file to be uploaded');
          return false;
      }
      ///validate file type
      var ext = $("#excel-upload").val().match(/\.(.+)$/)[1];
      switch (ext) {
          case 'xls':

          case 'xlsx':
              $("#lblerroruploader").removeClass('text-danger');
              $("#lblerroruploader").html('');

              var file_data = $("#excel-upload").prop("files")[0];
              var form_data = new FormData();
              form_data.append("excel_file", file_data);

              $this = $(this);
              $.ajax({
                  url: '<?php echo $this->webroot;?>students/upload',
                  type: 'post',
                  data    : form_data,
                  processData : false,
                  contentType: false,
                  dataType: 'json',
                  /*beforeSend: function() {
                      $this.prop('disabled',true).before('<i class="fa fa-spinner fa-2x fa-spin" style="margin-right:5px;"></i>');
                  },
                  complete: function() {
                      $this.prop('disabled',false);
                      $('.fa-spin').remove();
                  },*/
                  success: function (response) {
                      console.log(response);
                      if (typeof response.success != 'undefined') {
                          window.location = '<?php echo $this->webroot."students/index"; ?>';
                      }
                  }
              });

              return true;

          default:
              $("#lblerroruploader").addClass('text-danger');
              $("#lblerroruploader").html('Only excel file allowed');
              return false;
      }

      $("#lblerroruploader").html('');
      return true;
  }

</script>