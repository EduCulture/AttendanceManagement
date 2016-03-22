<div class="table-responsive">
   <table class="table table-bordered table-hover">
       <thead>
           <tr>
               <td class="text-center">#</td>
               <td class="text-center">Student Name</td>
               <td class="text-center">Roll Number</td>
               <td class="text-center">Total Present Day</td>
               <td class="text-center">Total Absent Day</td>
               <td class="text-center">Action</td>
           </tr>
       </thead>
       <tbody>
          <?php if($report_data) { ?>
                <?php $i=1;?>
                <?php foreach($report_data as $val) { ?>
                    <tr>
                        <td class="text-center"><?php echo $i; ?></td>
                        <td class="text-center" id="col-name"><?php echo $val['student_name']; ?></td>
                        <td class="text-center" id="col-name"><?php echo $val['roll_number']; ?></td>
                        <td class="text-center" id="col-name"><span class="label label-success"><?php echo $val['present_day']; ?></span></td>
                        <td class="text-center" id="col-name"><span class="label label-danger"><?php echo $val['absent_day']; ?></span></td>
                        <?php if($val['absent_day']) { ?>
                            <td class="text-center">[ <a href="#" onclick="viewDates('<?php echo $val['student_id']; ?>')"> View Dates </a> ] </td>
                        <?php } else { ?>
                            <td class="text-center"> - </td>
                        <?php } ?>
                        <?php $i++; ?>
                    <tr>
                <?php } ?>
          <?php } else { ?>
                <tr>
                    <td colspan="8" class="text-center"> No Data Available</td>
                </tr>
          <?php } ?>
       </tbody>
   </table>
</div>


<div class="modal fade" id="modal-attendance" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
           <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><i class="fa fa-edit"></i> Absent Dates</h4>
           </div>
           <div class="modal-body">
              <div id="absent-div">

              </div>
           </div>
        </div>
    </div>
</div>

<script>

function viewDates(student_id) {

    to_date = $('#input-to-date-available').val();
    from_date = $('#input-from-date-available').val();

    $.ajax({
        url: '<?php echo $this->webroot;?>attendance/getAbsentDates',
        type: 'post',
        data: {student_id : student_id,to_date : to_date,from_date :from_date},
        dataType: 'json',
        success: function (response) {
            if (response) {
                html = '<table class="table table-bordered table-hover">';
                for(i=0;i<response.length;i++) {
                    html += '<tr>';
                       html += '<td>'+response[i]+'</td>';
                    html += '</tr>';
                }
                html += '</table>';
                $('#absent-div').html(html);
                $('#modal-attendance').modal('show');
            }
        }
    });
}

</script>