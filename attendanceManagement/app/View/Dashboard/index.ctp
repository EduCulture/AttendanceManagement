<div class="page-header">
    <div class="container-fluid">
        <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
        <ul class="breadcrumb">
            <li><?php echo $this->Html->link('Home', array('controller'=>'dashboard','action'=>'index')); ?></li>
            <li><?php echo $this->Html->link('Dashboard', array('controller'=>'dashboard','action'=>'index')); ?></li>
        </ul>
    </div>
</div>

<div class="container-fluid">
   <div class="callout callout-info msg-of-day">
       <h4><i class="fa fa-bullhorn"></i> Message of day box</h4>
       <?php if($messages) { ?>
           <?php foreach($messages as $message) { ?>
               <p><marquee onmouseout="this.setAttribute('scrollamount', 2, 0);" onmouseover="this.setAttribute('scrollamount', 0, 0);" scrollamount="2" behavior="scroll" direction="left"><?php echo $message['Message']['message']; ?></marquee></p>
           <?php } ?>
       <?php } ?>
   </div>
   <?php
       echo $this->element('dashboard/school_details',array(
            'staff_count' => $staff_count,
            'student_count' => $student_count,
            'subject_count' => $subject_count
       ));
   ?>

   <div class="row">
         <?php echo $this->element('dashboard/notice_board',array('all' => $all,'students' => $students,'staffs' => $staffs)); ?>
         <?php echo $this->element('dashboard/birthday',array('event_details' => '')); ?>
   </div>
   <div class="row">
        <?php echo $this->element('dashboard/events',array('event_types' => $event_types)); ?>
        <?php echo $this->element('dashboard/chart'); ?>
   </div>



</div>