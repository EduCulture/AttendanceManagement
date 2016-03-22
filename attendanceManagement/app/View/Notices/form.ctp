<div class="page-header">
   <div class="container-fluid">
       <div class="pull-right">
          <button class="btn btn-primary" title="" data-toggle="tooltip" form="form-notice" type="submit" data-original-title="Save"><i class="fa fa-save"></i></button>
          <?php echo $this->Html->link('<i class="fa fa-reply"></i>',array('controller' => 'notices','action' => 'index'),array('escape' => false,'data-original-title' => 'Cancel','data-toggle' => 'tooltip','class' => 'btn btn-default')); ?>
       </div>
       <h1><i class="fa fa-columns"></i> Notice</h1>
       <ul class="breadcrumb">
           <li>
               <?php echo $this->Html->link('Home',array('controller' => 'dashboard')); ?>
           </li>
           <li>
               <?php echo $this->Html->link('Notice List',array('controller' => 'notices','action' => 'index')); ?>
           </li>
       </ul>

       <?php if($error_warning) { ?>
          <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> Please check below errors
             <button type="button" class="close" data-dismiss="alert">&times;</button>
          </div>
       <?php } ?>
   </div>
</div>

<div class="container-fluid">
   <div class="panel panel-default">
      <div class="panel-heading">
          <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo (($notice_id) ? 'Edit' : 'Add'); ?> Notice</h3>
      </div>
      <div class="panel-body">
          <form id="form-notice" class="form-horizontal" method="post" action="<?php echo $this->webroot . (($notice_id) ? 'notices/edit' : 'notices/add'); ?>" enctype="multipart/form-data">
               <div class="form-group required">
                    <label for="input-parent" class="col-sm-2 control-label">Title</label>
                    <div class="col-sm-4">
                        <input type="text" name="title" class="form-control" placeholder="Title" value="<?php echo $title; ?>" />
                        <?php if($error_title){ ?>
                            <div class="text-danger"><?php echo $error_title; ?></div>
                        <?php } ?>
                    </div>
                    <input type="hidden" name="notice_id" value="<?php echo $notice_id; ?>" />
               </div>
               <div class="form-group">
                     <label for="input-parent" class="col-sm-2 control-label">Description</label>
                     <div class="col-sm-8">
                         <textarea name="description" id="notice-description" class="form-control" placeholder="Description"><?php echo $description; ?></textarea>
                     </div>
               </div>

               <div class="form-group">
                   <label for="input-parent" class="col-sm-2 control-label">User Type</label>
                   <div class="col-sm-10">
                      <label class="radio-inline">
                         <input type="radio" <?php echo ($user_type==1) ? 'checked="checked"' : ''; ?> value="1" name="user_type">Student
                      </label>
                      <label class="radio-inline">
                         <input type="radio" <?php echo ($user_type==2) ? 'checked="checked"' : ''; ?> value="2" name="user_type">Staff
                      </label>
                      <label class="radio-inline">
                         <input type="radio" <?php echo ($user_type==3) ? 'checked="checked"' : ''; ?> value="3" name="user_type">All
                      </label>
                      <?php if($error_user_type){ ?>
                           <div class="text-danger"><?php echo $error_user_type; ?></div>
                       <?php } ?>
                   </div>
               </div>

               <div class="form-group">
                   <label for="input-parent" class="col-sm-2 control-label">Notice Date</label>
                   <div class="col-sm-3">
                      <div class="input-group date">
                          <input type="text" readonly class="form-control" id="input-date-available" data-format="DD-MM-YYYY" placeholder="Date" name="notice_date" value="<?php echo ($notice_date)? date("m/d/Y",strtotime($notice_date)) : date("m/d/Y"); ?>">
                          <span class="input-group-btn">
                              <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                          </span>
                      </div>
                   </div>
               </div>
               <div class="form-group">
                    <label for="input-parent" class="col-sm-2 control-label">Attachment</label>
                    <div class="col-sm-4">
                        <?php if($uploaded_file) { ?>
                            <a id="download" class="img-thumbnail" href="#">
                                <img src="<?php echo $this->webroot.'images/file.png'; ?>" width="80px" height="80px">
                            </a>
                        <?php } ?>
                        <input type="file" name="attachment" />
                    </div>
               </div>
               <div class="form-group">
                     <label for="input-parent" class="col-sm-2 control-label">Is Active?</label>
                     <div class="col-sm-10">
                         <input type="checkbox" name="active" class="form-control" style="margin-top:10px;" value="1" <?php echo ($active) ? 'checked="checked"' : ''; ?> />
                     </div>
               </div>
          </form>
      </div>
   </div>
</div>

<?php
    echo $this->Html->script('summernote.js');
    echo $this->Html->css('summernote.css');
    echo "<script>
        $('#notice-description').summernote({
            height: 170
        });
    </script>";
?>

<script>
$('#download').click(function(e){
    e.preventDefault();

});
</script>

<script src="<?php echo $this->webroot; ?>js/datetimepicker/moment.js" type="text/javascript"></script>
<script src="<?php echo $this->webroot; ?>js/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<link href="<?php echo $this->webroot; ?>js/datetimepicker/bootstrap-datetimepicker.min.css" type="text/css" rel="stylesheet" media="screen" />

<script>
$('.date').datetimepicker({
    pickTime: false
});
</script>
