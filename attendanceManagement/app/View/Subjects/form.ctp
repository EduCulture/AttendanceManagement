<div class="page-header">
   <div class="container-fluid">
       <div class="pull-right">
          <button class="btn btn-primary" title="" data-toggle="tooltip" form="form-subject" type="submit" data-original-title="Save"><i class="fa fa-save"></i></button>
          <?php echo $this->Html->link('<i class="fa fa-reply"></i>',array('controller' => 'subjects','action' => 'index'),array('escape' => false,'data-original-title' => 'Cancel','data-toggle' => 'tooltip','class' => 'btn btn-default')); ?>
       </div>
       <h1>Subjects</h1>
       <ul class="breadcrumb">
           <li>
               <?php echo $this->Html->link('Home',array('controller' => 'dashboard')); ?>
           </li>
           <li>
               <?php echo $this->Html->link('Subject List',array('controller' => 'subjects','action' => 'index')); ?>
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
          <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo (($subject_id) ? 'Edit' : 'Add'); ?> Subjects</h3>
      </div>
      <div class="panel-body">
          <form id="form-subject" class="form-horizontal" method="post" action="<?php echo $this->webroot . (($subject_id) ? 'subjects/edit' : 'subjects/add'); ?>" enctype="multipart/form-data">
               <div class="form-group required">
                     <label for="input-parent" class="col-sm-2 control-label">Name</label>
                     <div class="col-sm-4">
                         <input type="text" name="name" class="form-control" placeholder="Name" value="<?php echo $name; ?>" />
                         <?php if($error_name){ ?>
                             <div class="text-danger"><?php echo $error_name; ?></div>
                         <?php } ?>
                     </div>
                     <input type="hidden" name="section_id" value="<?php echo $subject_id; ?>" />
               </div>
               <div class="form-group">
                     <label for="input-parent" class="col-sm-2 control-label">Logo</label>
                     <div class="col-sm-10">
                         <a class="img-thumbnail" href="#" id="thumb-image" data-toggle="image">
                             <img src="<?php echo ($logo) ? $this->webroot .$logo : $this->webroot .'images/no_image.jpg' ; ?>" width="80px" height="80px">
                         </a>
                         <input type="hidden" name="logo" id="input-image" value="<?php echo $logo; ?>" />
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

