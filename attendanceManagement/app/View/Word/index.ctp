<div class="page-header">
    <div class="container-fluid">
        <h1>All Words</h1>
        <ul class="breadcrumb">
            <li>
                <?php echo $this->Html->link('Home',array('controller' => 'dashboard')); ?>
            </li>
            <li>
                <?php echo $this->Html->link('All words',array('controller' => 'word')); ?>
            </li>
        </ul>
    </div>
</div>

<?php echo $this->Session->flash(); ?>

<div class="container-fluid">
    <div class="panel panel-default">
          <div class="panel-heading">
              <h3 class="panel-title"><i class="fa fa-list"></i> Word List</h3>
              <div class="pull-right"><?php echo $this->Paginator->numbers(); ?></div>
          </div>
          <div class="panel-body">
              <div class="row">
                  <div class="col-sm-6">
                      <div class="panel panel-default">
                          <div class="panel-heading">
                              <h3 class="panel-title"><i class="fa fa-search"></i> Filter</h3>
                              <a data-toggle="collapse" href="#filter-panel" aria-expanded="false" aria-controls="collapseExample"><span class="hidden-xs hidden-sm hidden-md pull-right"><i class="fa fa-list"></i></span> </a>
                              <?php if($is_filter){ ?>
                                  <?php echo $this->Html->link('<i class="fa fa-undo"></i>',array('controller' => 'word','action' => 'index'),array('escape' => false,'data-original-title' => 'Reset Filter','data-toggle' => 'tooltip','class' => 'pull-right','style' => 'margin-right: 15px;')); ?>
                              <?php } ?>
                          </div>
                          <div class="panel-body collapse <?php echo ($is_filter) ? 'in' : ''; ?>" id="filter-panel">
                              <div class="well">
                                  <form enctype="multipart/form-data" method="get" action="<?php echo $this->webroot; ?>word/index">
                                      <div class="row">
                                          <div class="col-sm-4">
                                              <div class="form-group">
                                                  <label for="input-name" class="control-label">Word</label>
                                                  <input type="text" class="form-control" id="input-name" placeholder="Word" value="<?php echo isset($this->request->query['filter_word']) ? $this->request->query['filter_word'] : ''; ?>" name="filter_word">
                                              </div>
                                          </div>
                                          <div class="col-sm-4">
                                              <div class="form-group">
                                                  <label for="input-price" class="control-label">Type</label>
                                                  <select name="filter_type" class="form-control">
                                                      <option value=""></option>
                                                      <option value="0">Free</option>
                                                      <option value="1">Paid</option>
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
                  <div class="col-sm-6">
                      <div class="panel panel-default">
                          <div class="panel-heading">
                              <h3 class="panel-title"><i class="fa fa-upload"></i> Upload Words</h3>
                              <a data-toggle="collapse" href="#upload-panel" aria-expanded="false" aria-controls="collapseExample"><span class="hidden-xs hidden-sm hidden-md pull-right"><i class="fa fa-list"></i></span> </a>
                          </div>
                          <div class="panel-body collapse" id="upload-panel">
                              <div class="well">
                                  <div class="row">
                                      <div class="col-lg-6">
                                            <div class="row">
                                                <span>- Export "Words" from standard excel file.</span>
                                            </div>
                                            <div class="row">
                                                <span>- Choose file and upload</span>
                                            </div>
                                            <div class="row" style="margin-top: 20px;">
                                                <span>Note : If same word found it will overrides the data.</span>
                                            </div>
                                      </div>
                                      <div class="col-lg-6">
                                          <form enctype="multipart/form-data" id="upload-form" class="form-horizontal" method="post" action="<?php echo $this->webroot . 'word/upload'; ?>">
                                              <div class="row">
                                                  <div class="form-group">
                                                      <label class="col-sm-4 control-label" for="input-parent">Upload File</label>
                                                      <div class="col-sm-5" style="margin-top: 5px;">
                                                          <input type="file" id="worduploader" name="worduploader"/><br>
                                                          <input type="hidden" name="btnsubmit" value="upload_excel" />
                                                          <span id="lblerroruploader"></span>
                                                      </div>
                                                  </div>
                                              </div>
                                              <div class="row">
                                                  <div class="form-group">
                                                      <label class="col-sm-8 control-label" for="input-parent"></label>
                                                      <div class="col-sm-2">
                                                          <button class="btn btn-primary pull-right btn-sm" id="btnsubmit" type="button" onClick="validateForm();"><i class="fa fa-upload"></i> Upload</button>
                                                      </div>
                                                  </div>
                                              </div>
                                          </form>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>

              <form id="form-product" enctype="multipart/form-data">
                  <div class="table-responsive">
                      <table class="table table-bordered table-hover">
                          <thead>
                              <tr>
                                  <td class="text-center">Image</td>
                                  <td class="text-left">Category</td>
                                  <td class="text-left">Word</td>
                                  <td class="text-left">Translation</td>
                                  <td class="text-left">Meaning</td>
                                  <td class="text-left">Type</td>
                                  <td class="text-right">Active</td>
                              </tr>
                          </thead>
                          <tbody>
                              <?php if($word_details) { ?>
                                  <?php foreach($word_details as $word) { ?>
                                      <tr>
                                          <td class="text-center">
                                              <?php if($word['Word']['image_url']) { ?>
                                                 <a href="<?php echo $word['Word']['image_url']; ?>" data-lightbox="roadtrip">
                                                    <img class="img-thumbnail" width="50" height="50" alt="<?php echo $word['Word']['word_name']; ?>" src="<?php echo $word['Word']['image_url']; ?>">
                                                 </a>
                                              <?php } else { ?>
                                                  <img class="img-thumbnail" width="40" height="40" alt="<?php echo $word['Word']['word_name']; ?>" src="<?php echo $this->webroot; ?>images/no_image.jpg">
                                              <?php } ?>
                                          </td>
                                          <td class="text-left"><?php echo $word['Category']['category_name']; ?></td>
                                          <td class="text-left"><?php echo $word['Word']['word_name']; ?></td>
                                          <td class="text-left"><?php echo $word['Translation']['transliteration']; ?></td>
                                          <td class="text-left"><?php echo $word['Translation']['meaning']; ?></td>
                                          <td class="text-left">
                                              <?php if($word['Word']['is_paid']) { ?>
                                                 <span class="label label-danger">Paid</span>
                                              <?php } else { ?>
                                                 <span class="label label-warning">Free</span>
                                              <?php } ?>
                                          </td>
                                          <td class="text-right">
                                              <?php if($word['Word']['active']) { ?>
                                                <span class="label label-success">Yes</span>
                                              <?php } else { ?>
                                                <span class="label label-warning">No</span>
                                              <?php } ?>
                                          </td>
                                      </tr>
                                  <?php } ?>
                              <?php } else { ?>
                                <tr>
                                    <td colspan="7" class="text-center">No Data Available</td>
                                </tr>
                              <?php  } ?>
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

<script>
      $("#worduploader").change(function () {
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

      function validateForm(){

          if($("#worduploader").val()==""){
              $("#lblerroruploader").addClass('text-danger');
              $("#lblerroruploader").html('Please select the file to be uploaded');
              return false;
          }
          ///validate file type
          var ext = $("#worduploader").val().match(/\.(.+)$/)[1];
          switch (ext) {
              case 'xls':

              case 'xlsx':
                  $("#lblerroruploader").removeClass('text-danger');
                  $("#lblerroruploader").html('');
                  $('#upload-form').submit();
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