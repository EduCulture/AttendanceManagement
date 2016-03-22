<div class="page-header">
    <div class="container-fluid">
        <h1><i class="fa fa-eye"></i> Students Profile</h1>
        <ul class="breadcrumb">
            <li>
                <?php echo $this->Html->link('Home',array('controller' => 'dashboard')); ?>
            </li>
            <li>
                <?php echo $this->Html->link('Students',array('controller' => 'students')); ?>
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
                            <img class="center-block img-circle img-thumbnail img-responsive profile-img" src="<?php echo $this->webroot.'images/no_student.png'; ?>" alt="No Image">
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
                                <b><span class="glyphicon glyphicon-user"></span> <?php echo $student_detail['Student']['first_name']. ' '.$student_detail['Student']['last_name']; ?></b>
                            </h2>
                            <p>
                                <strong>Roll Number : </strong>
                                <?php echo $student_detail['Student']['roll_number']; ?>
                            </p>
                            <p>
                                <strong>Mobile No : </strong>
                                <?php echo $student_detail['Student']['contact_number']; ?>
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
                <li id="academic-tab" class=""><a href="#academic" data-toggle="tab" aria-expanded="false"><i class="fa fa-graduation-cap"></i> Academic</a></li>
                <li id="guardians-tab" class=""><a href="#guardians" data-toggle="tab" aria-expanded="false"><i class="fa fa-user"></i> Guardians</a></li>
                <li id="fees-tab" class=""><a href="#fees" data-toggle="tab" aria-expanded="false"><i class="fa fa-money"></i> Fees</a></li>
                <li id="timetable-tab"><a href="#timetable" data-toggle="tab" aria-expanded="true"><i class="fa fa-calendar"></i> Timetable</a></li>
                <li id="attendance-tab"><a href="#attendance" data-toggle="tab"><i class="fa fa-check-square"></i> Attendance</a></li>
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
                                        <td><?php echo $student_detail['Student']['first_name']; ?></td>
                                        <td class="profile-label">Last Name</td>
                                        <td><?php echo $student_detail['Student']['last_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="profile-label">Middle Name</td>
                                        <td> - </td>
                                        <td class="profile-label">Gender</td>
                                        <td><?php echo $student_detail['Student']['gender']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="profile-label">Address</td>
                                        <td><?php echo ($student_detail['Student']['address']) ? $student_detail['Student']['address'] : 'NA' ; ?></td>
                                        <td class="profile-label">Birth Date</td>
                                        <td><?php echo date("d-M-y",strtotime($student_detail['Student']['birthdate'])); ?></td>
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

                <div class="tab-pane" id="academic">
                    <h3 class="page-header edusec-border-bottom-primary">
                        <i class="fa fa-info-circle"></i> Academic Details
                    </h3>

                    <div class="box box-solid">
                        <div class="box-body no-padding table-responsive">
                            <table class="table tbl-profile">
                                <colgroup>
                                    <col style="width:200px">
                                    <col>
                                    <col>
                                    <col>
                                </colgroup>
                                <tbody>
                                    <tr>
                                        <td class="profile-label">Standard </td>
                                        <td><?php echo $student_detail['Standard']['name']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="profile-label">Section</td>
                                        <td><?php echo $student_detail['Section']['name']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="profile-label">Admission Date</td>
                                        <td><?php echo date("d-M-y",strtotime($student_detail['Student']['date_added'])); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="profile-label">Admission Number</td>
                                        <td><?php echo $student_detail['Student']['admission_number']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="profile-label">Roll Number</td>
                                        <td><?php echo $student_detail['Student']['roll_number']; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div><!--/box-body-->
                    </div><!--/box-->
                </div>

                <div class="tab-pane" id="guardians">
                    <h3 class="page-header edusec-border-bottom-primary">
                        <i class="fa fa-info-circle"></i> Guardians Details
                    </h3>

                    <?php if($student_detail['StudentParentMap']) { ?>

                    <?php } else { ?>
                        <div class="alert alert-warning">
                            <i class="icon fa fa-warning"></i>No guardians records found.
                        </div>
                    <?php } ?>
                </div>


                <div class="tab-pane" id="fees">

                    <!-----Start current batch fees details----->
                    <h4 class="edusec-border-bottom-warning page-header profile-sub-header">
                        <i class="fa fa-money"></i> Current Fees Details
                    </h4>

                    <div class="box box-solid">
                        <div class="box-body table-responsive no-padding">
                            <div id="w0" class="grid-view">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Due Date</th>
                                            <th>Total Amount</th>
                                            <th>Total Remaining</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(isset($fee_detail) && $fee_detail) { ?>
                                            <?php foreach($fee_detail as $val) { ?>
                                                <tr>
                                                    <td><?php echo $val['fee_name']; ?> </td>
                                                    <td><?php echo date("d-M-y",strtotime($val['due_date'])); ?></td>
                                                    <td><i class="fa fa-inr"></i> <?php echo $val['total']; ?></td>
                                                    <td><i class="fa fa-inr"></i> <?php echo $val['remaining']; ?></td>
                                                </tr>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <tr>
                                                <td colspan="5" class="text-center">No Data available</td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <h4 class="edusec-border-bottom-warning page-header profile-sub-header">
                        <i class="fa fa-money"></i> Student Payment History
                    </h4>

                    <div class="box box-solid">
                        <div class="box-body table-responsive no-padding">
                            <div id="w1">
                                <div id="w2" class="grid-view">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Fee Name</th>
                                                <th>Paid Amount</th>
                                                <th>Payment Type</th>
                                                <th>Payment Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(isset($payment_history) && $payment_history) { ?>
                                                <?php foreach($payment_history as $history) { ?>
                                                    <tr>
                                                        <td><?php echo $history['Fee']['name']; ?></td>
                                                        <td><i class="fa fa-inr"></i> <?php echo " " .$history['StudentFeeMap']['amount']; ?></td>
                                                        <td><?php echo ($history['StudentFeeMap']['payment_type'] == 1) ? 'Cash' : 'Cheque'; ?></td>
                                                        <td><?php echo date("d-M-Y",strtotime($history['StudentFeeMap']['payment_date'])); ?></td>
                                                    </tr>
                                                <?php } ?>
                                            <?php } else { ?>
                                                <tr>
                                                    <td colspan="5" class="text-center">No Data available </tr>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="timetable">
                    <h4 class="edusec-border-bottom-warning page-header profile-sub-header">
                        <i class="fa fa-info-circle"></i> Timetable
                    </h4>

                    <div class="box box-solid">
                        <div class="box-body table-responsive no-padding">
                            <table class="items table table-bordered table-striped table-hover">
                                <thead>
                                   <tr>
                                       <th class="text-center">Class Timing</th>
                                       <?php foreach($days as $day) { ?>
                                           <th class="text-center"><?php echo $day['Day']['name']; ?></th>
                                       <?php } ?>
                                   </tr>
                               </thead>
                               <tbody>
                                  <?php if(isset($timetable) && $timetable) { ?>
                                      <?php foreach($timetable as $detail) { ?>
                                         <tr>
                                            <td data-title="Class" class="text-center"><?php echo $detail['time']; ?></td>
                                            <?php if(!$detail['is_break']) { ?>
                                                <?php foreach($days as $day) { ?>
                                                    <td class="text-center">
                                                        <?php if($detail['days'][$day['Day']['name']]['subject']) { ?>
                                                            <?php echo $detail['days'][$day['Day']['name']]['subject']['name']; ?> ( <?php echo $detail['days'][$day['Day']['name']]['staff']['name']; ?> )
                                                        <?php } else { ?>
                                                            -
                                                        <?php } ?>
                                                    </td>
                                                <?php } ?>
                                            <?php } else { ?>
                                                <td colspan="6" class="text-red text-center" data-title="Break"><span style="font-size: 20px;font-weight: bold;" title="" data-toggle="tooltip" data-original-title="Break"><?php echo $detail['name']; ?></span></td>
                                            <?php } ?>
                                         </tr>
                                      <?php } ?>
                                  <?php } else { ?>
                                     <tr>
                                         <td colspan="7" class="text-center"> No Data Available</td>
                                     </tr>
                                  <?php } ?>
                               </tbody>
                            </table>
                        </div>
                    </div>

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
                                <div class="col-sm-6 left-padding">
                                    <table class="table table-bordered table-striped">
                                        <tbody>
                                            <tr>
                                                <th colspan="2" class="text-left" style="font-size:15px">Faculty Name :</th>
                                            </tr>
                                            <?php if(isset($staff_subject_details) && $staff_subject_details) { ?>
                                                <?php foreach($staff_subject_details as $staff) { ?>
                                                    <tr>
                                                        <td><?php echo $staff['Staff']['first_name'].' '.$staff['Staff']['last_name']; ?></td>
                                                    </tr>
                                                <?php } ?>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="attendance">
                    <h4 class="edusec-border-bottom-warning page-header profile-sub-header">
                        <i class="fa fa-info-circle"></i> Monthly Attendance
                    </h4>

                    <div class="box box-solid flat">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-4">
                                   <div class="input-group date">
                                       <input type="text" id="input-month" readonly class="form-control" data-format="MM-YYYY" placeholder="Select Month & Year" value="<?php echo $month.'/01/'.$year; ?>">
                                       <span class="input-group-btn">
                                           <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                                       </span>
                                   </div>
                                </div>
                                <div class="col-sm-6">
                                    <button type="button" id="search-attendance" class="btn btn-info btn-create btn-flat">Search</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="box box-solid flat">
                        <div class="box-body">
                            <div class="row" id="attendance-div">

                            </div>
                        </div>
                    </div>
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

loadAttendance();

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

$('#search-attendance').click(function() {
    loadAttendance();
});

</script>