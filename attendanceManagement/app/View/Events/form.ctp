<div class="page-header">
   <div class="container-fluid">
       <div class="pull-right">
          <button class="btn btn-primary" title="" data-toggle="tooltip" form="form-event" type="submit" data-original-title="Save"><i class="fa fa-save"></i></button>
          <?php echo $this->Html->link('<i class="fa fa-reply"></i>',array('controller' => 'events','action' => 'index'),array('escape' => false,'data-original-title' => 'Cancel','data-toggle' => 'tooltip','class' => 'btn btn-default')); ?>
       </div>
       <h1> <i class="fa fa-flag"></i> Events</h1>
       <ul class="breadcrumb">
           <li>
               <?php echo $this->Html->link('Home',array('controller' => 'dashboard')); ?>
           </li>
           <li>
               <?php echo $this->Html->link('Events',array('controller' => 'events','action' => 'index')); ?>
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
          <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo (($event_id) ? 'Edit' : 'Add'); ?> Events</h3>
      </div>
      <div class="panel-body">

          <form id="form-event" class="form-horizontal" method="post" action="<?php echo $this->webroot . (($event_id) ? 'events/edit' : 'events/add'); ?>" enctype="multipart/form-data">

              <div class="form-group required">
                    <label for="input-parent" class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" name="tittle" class="form-control" placeholder="Event tittle" value="<?php echo $tittle; ?>" />
                        <?php if($error_tittle){ ?>
                            <div class="text-danger"><?php echo $error_tittle; ?></div>
                        <?php } ?>
                    </div>
                    <input type="hidden" name="event_id" value="<?php echo $event_id; ?>" />
              </div>

              <div class="form-group required">
                  <label for="input-parent" class="col-sm-2 control-label">Description</label>
                  <div class="col-sm-10">
                      <textarea name="description" class="form-control" id="input-description" placeholder="Description"><?php echo $description; ?></textarea>
                      <?php if($error_description){ ?>
                          <div class="text-danger"><?php echo $error_description; ?></div>
                      <?php } ?>
                  </div>
              </div>

              <div class="form-group required">
                  <label for="input-parent" class="col-sm-2 control-label">Event Date</label>
                  <div class="col-sm-3">
                     <div class="input-group date">
                         <input type="text" readonly class="form-control" id="input-date-available" data-format="DD-MM-YYYY" placeholder="Event Date" name="event_date" value="<?php echo ($event_date) ? date("m/d/Y",strtotime($event_date)) : '' ;?>">
                         <span class="input-group-btn">
                             <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                         </span>
                     </div>
                     <div>
                        <?php if($error_event_date){ ?>
                            <div class="text-danger"><?php echo $error_event_date; ?></div>
                        <?php } ?>
                     </div>
                  </div>
              </div>
          </form>
      </div>
   </div>
</div>

<link href="<?php echo $this->webroot; ?>js/summernote//summernote.css" rel="stylesheet" />
<script src="<?php echo $this->webroot; ?>js/summernote/summernote.js" type="text/javascript"></script>
<script src="<?php echo $this->webroot; ?>js/datetimepicker/moment.js" type="text/javascript"></script>
<script src="<?php echo $this->webroot; ?>js/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<link href="<?php echo $this->webroot; ?>js/datetimepicker/bootstrap-datetimepicker.min.css" type="text/css" rel="stylesheet" media="screen" />

<script>

$('.date').datetimepicker({
    pickTime: false,
    minDate:new Date()
});
</script>

<script>
    $('#input-description').summernote({
        height: 170
    });
</script>

