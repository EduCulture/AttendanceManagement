<div class="page-header">
   <div class="container-fluid">
       <div class="pull-right">
          <button class="btn btn-primary" title="" data-toggle="tooltip" form="form-message" type="submit" data-original-title="Save"><i class="fa fa-save"></i></button>
          <?php echo $this->Html->link('<i class="fa fa-reply"></i>',array('controller' => 'messages','action' => 'index'),array('escape' => false,'data-original-title' => 'Cancel','data-toggle' => 'tooltip','class' => 'btn btn-default')); ?>
       </div>
       <h1>Messages</h1>
       <ul class="breadcrumb">
           <li>
               <?php echo $this->Html->link('Home',array('controller' => 'dashboard')); ?>
           </li>
           <li>
               <?php echo $this->Html->link('Subject List',array('controller' => 'messages','action' => 'index')); ?>
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
          <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo (($message_id) ? 'Edit' : 'Add'); ?> Message</h3>
      </div>
      <div class="panel-body">
          <form id="form-message" class="form-horizontal" method="post" action="<?php echo $this->webroot . (($message_id) ? 'messages/edit' : 'messages/add'); ?>" enctype="multipart/form-data">
               <div class="form-group required">
                     <label for="input-parent" class="col-sm-2 control-label">Message</label>
                     <div class="col-sm-4">
                         <textarea type="text" name="message" class="form-control" placeholder="Message"><?php echo $message; ?></textarea>
                         <?php if($error_message){ ?>
                             <div class="text-danger"><?php echo $error_message; ?></div>
                         <?php } ?>
                     </div>
                     <input type="hidden" name="message_id" value="<?php echo $message_id; ?>" />
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
                     <label for="input-parent" class="col-sm-2 control-label">Is Active?</label>
                     <div class="col-sm-10">
                         <input type="checkbox" name="active" class="form-control" style="margin-top:10px;" value="1" <?php echo ($active) ? 'checked="checked"' : ''; ?> />
                     </div>
               </div>
          </form>
      </div>
   </div>
</div>

