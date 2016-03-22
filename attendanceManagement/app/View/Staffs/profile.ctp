<div class="page-header">
    <div class="container-fluid">
        <h1><i class="fa fa-eye"></i> Staff Profile</h1>
        <ul class="breadcrumb">
            <li>
                <?php echo $this->Html->link('Home',array('controller' => 'dashboard')); ?>
            </li>
            <li>
                <?php echo $this->Html->link('Students',array('controller' => 'staffs')); ?>
            </li>
        </ul>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-xs-12">
           <div class="well panel panel-default">
               <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-3 text-center">
                            <img class="center-block img-circle img-thumbnail img-responsive profile-img" src="<?php echo $this->webroot.$staff_detail['Staff']['profile_pic']; ?>" alt="No Image">
                            <div class="clearfix">
                                <span class="pull-left">Profile Completion</span>
                                <small class="pull-right">66%</small>
                            </div>
                            <div class="progress sm" style="background-color:#dadada">
                                <div style="width: 66%;" class="progress-bar progress-bar-green"></div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-9">
                            <h2 class="text-primary">
                                <b><span class="glyphicon glyphicon-user"></span> <?php echo $staff_detail['Staff']['first_name']. ' '.$staff_detail['Staff']['last_name']; ?></b>
                            </h2>
                            <p>
                                <strong>Qualification : </strong>
                                <?php echo $staff_detail['Staff']['qualification']; ?>
                            </p>
                            <p>
                                <strong>Contact No : </strong>
                                <?php echo $staff_detail['Staff']['contact_number']; ?>
                            </p>
                        </div><!--/col-->
                    </div><!--/row-->
               </div>
           </div>
        </div>
    </div>

    <div class="row" class="user-profile">
        <div class="col-sm-12">
            <ul class="nav nav-tabs responsive hidden-xs hidden-sm" id="profileTab">
                <li class="active" id="personal-tab"><a href="#personal" data-toggle="tab" aria-expanded="false"><i class="fa fa-male"></i> Personal</a></li>
                <li id="timetable-tab"><a href="#timetable" data-toggle="tab" aria-expanded="true"><i class="fa fa-calendar"></i> Timetable</a></li>
            </ul>

            <div id="content" class="tab-content responsive hidden-xs hidden-sm">
                <div class="tab-pane active" id="personal">
                    <h3 class="page-header edusec-border-bottom-primary">
                        <i class="fa fa-info-circle"></i> Personal Details
                    </h3>

                    <div class="box box-solid">
                        <div class="box-body no-padding table-responsive">
                            <table class="table tbl-profile">
                                <colgroup>
                                    <col style="width:200px"><col>
                                    <col style="width:150px"><col>
                                </colgroup>
                                <tbody>
                                    <tr>
                                        <td class="profile-label">First Name</td>
                                        <td><?php echo $staff_detail['Staff']['first_name']; ?></td>
                                        <td class="profile-label">Last Name</td>
                                        <td><?php echo $staff_detail['Staff']['last_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="profile-label">Middle Name</td>
                                        <td> - </td>
                                        <td class="profile-label">Gender</td>
                                        <td><?php echo ($staff_detail['Staff']['gender']==1) ? 'Male' : 'Female'; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="profile-label">Address</td>
                                        <td><?php echo ($staff_detail['Staff']['address']) ? $staff_detail['Staff']['address'] : 'NA' ; ?></td>
                                        <td class="profile-label">Birth Date</td>
                                        <td><?php echo date("d-M-y",strtotime($staff_detail['Staff']['birthdate'])); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="profile-label">Bloodgroup</td>
                                        <td>Unknown</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div><!--/box-body-->
                    </div><!--/box-->
                </div>

                <div class="tab-pane" id="timetable">
                    <h4 class="edusec-border-bottom-warning page-header profile-sub-header">
                        <i class="fa fa-info-circle"></i> Timetable
                    </h4>

                    <div class="box box-solid">
                        <div class="box-body table-responsive no-padding">
                            <table class="items table table-bordered table-striped table-hover">
                               <tbody>
                                   <?php foreach($days as $day) { ?>
                                        <tr>
                                             <th class="text-center"><?php echo $day['Day']['name']; ?></th>

                                             <?php if(isset($timetable[$day['Day']['name']]) && $timetable[$day['Day']['name']]) { ?>
                                                 <?php foreach($timetable[$day['Day']['name']] as $detail) { ?>

                                                       <td data-title="Class" class="text-center"><?php echo $detail['start_time'] .' - '.$detail['end_time'] . '<br/>' .$detail['subject'] .'(' . $detail['standard']. ' - '.$detail['section'] .')'; ?></td>
                                                 <?php } ?>
                                             <?php } else { ?>
                                                <td colspan="6" class="text-red text-center"><span style="font-size: 20px;font-weight: bold;" title="" data-toggle="tooltip" data-original-title="Lecture Not Assigned"> - </span></td>
                                             <?php } ?>
                                        </tr>
                                   <?php } ?>
                               </tbody>
                            </table>
                        </div>
                    </div>
                    <?php /*
                    <div class="box">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-6">
                                     <table class="table table-bordered table-striped">
                                        <tbody>
                                            <tr>
                                                <th colspan="2" class="text-left" style="font-size:15px">Subject :</th>
                                            </tr>
                                            <?php if(isset($staff_subject_details) && $staff_subject_details) { ?>
                                                <?php foreach($staff_subject_details as $subject) { ?>
                                                    <tr>
                                                        <td><?php echo $subject['Subject']['name']; ?></td>
                                                    </tr>
                                                <?php } ?>
                                            <?php } ?>
                                        </tbody>
                                     </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    */ ?>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="<?php echo $this->webroot; ?>js/datetimepicker/moment.js" type="text/javascript"></script>
<script src="<?php echo $this->webroot; ?>js/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<link href="<?php echo $this->webroot; ?>js/datetimepicker/bootstrap-datetimepicker.min.css" type="text/css" rel="stylesheet" media="screen" />

<script>

$('.date').datetimepicker({
  pickTime: false,
  viewMode: "years",
  minViewMode: "months"
});

//loadAttendance();

function loadAttendance() {

    student_id = '<?php echo $student_id; ?>'
    date = $('#input-month').val();

    $.ajax({
        url: '<?php echo $this->webroot;?>students/getMonthlyAttendance',
        type: 'post',
        data : {student_id : student_id, date : date},
        dataType: 'html',
        success: function (response) {
            $('#attendance-div').html(response);
        }
    });
}

</script>