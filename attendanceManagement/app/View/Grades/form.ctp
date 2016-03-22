<div class="page-header">
   <div class="container-fluid">
       <div class="pull-right">
          <button class="btn btn-primary" title="" data-toggle="tooltip" form="form-grade" type="submit" data-original-title="Save"><i class="fa fa-save"></i></button>
          <?php echo $this->Html->link('<i class="fa fa-reply"></i>',array('controller' => 'sections','action' => 'index'),array('escape' => false,'data-original-title' => 'Cancel','data-toggle' => 'tooltip','class' => 'btn btn-default')); ?>
       </div>
       <h1><i class="glyphicon glyphicon-stats"></i> Grades</h1>
       <ul class="breadcrumb">
           <li>
               <?php echo $this->Html->link('Home',array('controller' => 'dashboard')); ?>
           </li>
           <li>
               <?php echo $this->Html->link('Grades',array('controller' => 'grades','action' => 'index')); ?>
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
          <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo (($grade_id) ? 'Edit' : 'Add'); ?> Grade</h3>
      </div>
      <div class="panel-body">
          <form id="form-grade" class="form-horizontal" method="post" action="<?php echo $this->webroot . (($grade_id) ? 'grades/edit' : 'grades/add'); ?>" enctype="multipart/form-data">
               <div class="form-group required">
                     <label for="input-parent" class="col-sm-2 control-label">Name</label>
                     <div class="col-sm-4">
                         <input type="text" name="name" class="form-control" placeholder="Name" value="<?php echo $name; ?>" />
                         <?php if($error_name){ ?>
                             <div class="text-danger"><?php echo $error_name; ?></div>
                         <?php } ?>
                     </div>
                     <input type="hidden" name="section_id" value="<?php echo $grade_id; ?>" />
               </div>
               <div class="form-group required">
                    <label for="input-parent" class="col-sm-2 control-label">Minimum Mark</label>
                    <div class="col-sm-4">
                        <input type="text" name="minimum_mark" class="form-control" placeholder="Minimum mark" value="<?php echo $minimum_mark; ?>" />
                        <?php if($error_minimum_mark){ ?>
                            <div class="text-danger"><?php echo $error_minimum_mark; ?></div>
                        <?php } ?>
                    </div>
               </div>
               <div class="form-group required">
                   <label for="input-parent" class="col-sm-2 control-label">Maximum Mark</label>
                   <div class="col-sm-4">
                       <input type="text" name="maximum_mark" class="form-control" placeholder="Maximum mark" value="<?php echo $maximum_mark; ?>" />
                       <?php if($error_maximum_mark){ ?>
                           <div class="text-danger"><?php echo $error_maximum_mark; ?></div>
                       <?php } ?>
                   </div>
               </div>
          </form>
      </div>
   </div>
</div>

