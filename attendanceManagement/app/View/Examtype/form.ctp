<div class="page-header">
   <div class="container-fluid">
       <div class="pull-right">
          <button class="btn btn-primary" title="" data-toggle="tooltip" form="form-subject" type="submit" data-original-title="Save"><i class="fa fa-save"></i></button>
          <?php echo $this->Html->link('<i class="fa fa-reply"></i>',array('controller' => 'examtype','action' => 'index'),array('escape' => false,'data-original-title' => 'Cancel','data-toggle' => 'tooltip','class' => 'btn btn-default')); ?>
       </div>
       <h1>Exam type</h1>
       <ul class="breadcrumb">
           <li>
               <?php echo $this->Html->link('Home',array('controller' => 'dashboard')); ?>
           </li>
           <li>
               <?php echo $this->Html->link('Exam Type',array('controller' => 'examtype','action' => 'index')); ?>
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
          <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo (($type_id) ? 'Edit' : 'Add'); ?> Exam Type</h3>
      </div>
      <div class="panel-body">
          <form id="form-subject" class="form-horizontal" method="post" action="<?php echo $this->webroot . (($type_id) ? 'examtype/edit' : 'examtype/add'); ?>" enctype="multipart/form-data">
               <div class="form-group required">
                     <label for="input-parent" class="col-sm-3 control-label">Name</label>
                     <div class="col-sm-4">
                         <input type="text" name="name" class="form-control" placeholder="Name" value="<?php echo $name; ?>" />
                         <?php if($error_name){ ?>
                             <div class="text-danger"><?php echo $error_name; ?></div>
                         <?php } ?>
                     </div>
                     <input type="hidden" name="type_id" value="<?php echo $type_id; ?>" />
               </div>
               <div class="form-group required">
                    <label for="input-parent" class="col-sm-3 control-label">Can staff create exam? </label>
                    <div class="col-sm-4">
                        <input type="checkbox" name="is_available" <?php echo ($is_available) ? 'checked="checked"' : ''; ?> class="form-control" style="margin-top:10px;" />
                    </div>
               </div>
          </form>
      </div>
   </div>
</div>

