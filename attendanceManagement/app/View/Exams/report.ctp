
 <div class="well well-sm">
      <h4 class="page-header edusec-border-bottom-warning"><i class="fa fa-info-circle"></i> Student Details</h4>
      <div class="table-responsive">
          <table>
                <colgroup>
                    <col style="width:180px">
                    <col style="width:60%">
                </colgroup>
                <tbody>
                    <tr>
                        <td><img class="center-block img-circle img-thumbnail img-responsive" src="" alt="" style="width:140px; height:140px"></td>
                        <td>
                            <h3 class="text-primary">
                                <b><span class="glyphicon glyphicon-user"></span> <?php echo $student['student_name']; ?></b>
                            </h3>
                            <p>
                                <strong>Roll Number : </strong> <?php echo $student['roll_number']; ?>
                            </p>
                            <p>
                                <strong>Standard : </strong>
                                <?php echo $student['standard'] . ' - '.$student['section']; ?>
                            </p>
                        </td>
                    </tr>
                </tbody>
          </table>
      </div>
 </div>


 <div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-list"></i> Exam Details</h3>
    </div>

    <div class="box-body">
        <?php if($exams) { ?>
            <?php foreach($exams as $exam) { ?>
                <div class="box box-info box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Exam Name : <?php echo $exam['exam_name']; ?></h3>
                        <div class="pull-right">
                            <strong>Exam Type : </strong><?php echo $exam['type']; ?>
                        </div>
                    </div>
                    <div class="box-body no-padding table-responsive">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>Date</th>
                                    <th>Subject Name</th>
                                    <th>Total Marks</th>
                                    <th>Passing Marks</th>
                                    <th>Obtained Marks</th>
                                    <th>Grade</th>
                                    <th>Results</th>
                                    <th>Remarks</th>
                                    <th>Percentage (%)</th>
                                </tr>

                                <?php if($exam['details']) { ?>
                                    <?php foreach($exam['details'] as $value) { ?>
                                        <tr>
                                            <td><?php echo $value['date']; ?></td>
                                            <td><?php echo $value['subject_name']; ?></td>
                                            <td><?php echo $value['maximum_mark']; ?></td>
                                            <td><?php echo $value['passing_mark']; ?></td>
                                            <td><?php echo $value['obtain_mark']; ?></td>
                                            <td>AA</td>
                                            <td><?php echo $value['result']; ?></td>
                                            <td><?php echo $value['remark']; ?></td>
                                            <td><?php echo $value['percentage'] . '%'; ?></td>
                                        </tr>
                                    <?php } ?>
                                <?php } else { ?>
                                    <tr>
                                        <td colspan="9" class="text-center"> Details Not available </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-sm-3">
                                <strong> Total Marks : </strong> <?php echo $exam['total_marks']; ?>
                            </div>
                            <div class="col-sm-3">
                                <strong> Total Obtain Marks : </strong> <?php echo $exam['total_obtain']; ?>
                            </div>
                            <div class="col-sm-3">
                                <strong> Total Percentage : </strong> <?php echo $exam['total_percentage'] . '%'; ?>
                            </div>
                            <div class="col-sm-3">
                                <?php if($exam['result_available']) { ?>
                                    <strong> Result : </strong> <?php echo ($exam['result']) ? '<span class="label label-success"> Pass </span>' : '<span class="label label-danger"> Fail </span>'; ?>
                                <?php } else { ?>
                                    <strong> Result : </strong> -
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } else  { ?>
            <div class="box-header bg-warning">
                <div style="padding:5px">No Exams Available</div>
            </div>
        <?php } ?>
    </div>
 </div>
