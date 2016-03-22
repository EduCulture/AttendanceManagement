<div class="page-header">
    <div class="container-fluid">
        <h1><i class="fa fa-inr"></i> Collect fees</h1>
        <ul class="breadcrumb">
            <li>
                <?php echo $this->Html->link('Home',array('controller' => 'dashboard')); ?>
            </li>
            <li>
                <?php echo $this->Html->link('Fees',array('controller' => 'fees')); ?>
            </li>
        </ul>
    </div>
</div>

<?php echo $this->Session->flash(); ?>

  <div class="col-sm-12">
      <div class="box box-primary">
          <div class="box-header with-border">
              <h3 class="box-title">
          		 <i class="fa fa-user"></i><sub><i class="fa fa-info-circle"></i></sub> Student Details
              </h3>
          </div>
          <div class="box-body">
               <table class="table">
                    <colgroup>
                        <col class="col-sm-2">
                        <col class="col-sm-2">
                        <col class="col-sm-8">
                    </colgroup>

                    <tbody>
                        <tr style="border:none;">
                            <td rowspan="5" class="hidden-xs" style="border:none;">
                            <img class="img-circle edusec-img-disp" src="/data/stu_images/Nash_2.jpg" alt="No Image"></td>
                            <th style="border:none;">Name</th>
                            <td style="border:none;"><?php echo $student_details['Student']['first_name'].' '.$student_details['Student']['last_name']; ?></td>
                        </tr>
                        <tr>
                            <th>Standard</th>
                            <td><?php echo $student_details['Standard']['name']; ?></td>
                        </tr>
                        <tr>
                            <th>Roll Number</th>
                            <td><?php echo $student_details['Student']['roll_number']; ?></td>
                        </tr>
                        <tr>
                            <th>Contact Number</th>
                            <td><?php echo $student_details['Student']['contact_number']; ?></td>
                        </tr>
                    </tbody>
               </table>
          </div>
      </div>

      <div class="box box-primary">
           <div class="box-header with-border">
                <h3 class="box-title">
                	<i class="fa fa-inr"></i><sub><i class="fa fa-info-circle"></i></sub> Fees Collection Category
                </h3>
           </div>
           <div class="box-body">
               <div class="row">
                   <div class="col-sm-12 table-responsive">
                       <table class="table table-bordered">
                          <colgroup>
                              <col class="col-xs-1">
                              <col class="col-xs-9">
                              <col class="col-xs-2">
                          </colgroup>
                          <tbody>
                             <tr>
                                <th> No </th>
                                <th> Fee Details </th>
                                <th> Amount </th>
                             </tr>
                             <?php if($details) { ?>
                                <?php $i = 0; ?>
                                <?php foreach($details as $fee_detail) { ?>
                                    <td><?php echo ++$i; ?></th>
                                    <td><?php echo $fee_detail['name']; ?></td>
                                    <td><?php echo $fee_detail['amount']; ?></td>
                                <?php } ?>
                                <tr>
                                    <th colspan="2" class="text-right col-md-9">Total Amount</th>
                                    <td><?php echo number_format($total,2); ?></td>
                                </tr>
                                <tr>
                                    <th colspan="2" class="text-right col-md-9">Total Paid Fees</th>
                                    <td><?php echo '<span class="label label-success"><i class="fa fa-inr"></i>' .' '. $total_paid . '</span>'; ?></td>
                                </tr>
                                <tr>
                                    <th colspan="2" class="text-right col-md-9">Total Remaining Fees</th>
                                    <td><?php echo '<span class="label label-danger"><i class="fa fa-inr"></i>' .' '.number_format($total_remaining,2) . '</span>'; ?></td>
                                </tr>
                             <?php } else { ?>
                                <tr>
                                    <td colspan="3" class="text-center"> No Details Available </td>
                                </tr>
                             <?php } ?>
                          </tbody>
                       </table>
                   </div>
               </div>
           </div>
           <div class="box-footer" style="height:48px;">
           	    <div class="pull-right" style="">
           	        <a class="btn btn-warning btn-sm" href="#" target="_blank"><i class="fa fa-print"></i> Print receipt</a>
           		</div>
           </div>
      </div>

      <div class="box box-success">
          <div class="box-header with-border">
          	 <h3 class="box-title">
          	    <i class="fa fa-inr"></i>
          	    <sup><i class="fa fa-clock-o"></i></sup> Payment History
          	 </h3>
          	 <?php if($total_remaining > 0) { ?>
                 <div class="pull-right">
                    <button class="btn btn-success btn-xs" id="collect-fee-btn"><i class="fa fa-plus"></i> Collect</button>
                 </div>
          	 <?php } ?>
          </div>
          <div class="box-body table-responsive no-padding">
             <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Payment date</th>
                        <th>Payment Type</th>
                        <th>Cheque No</th>
                        <th>Amount</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($fees_history) { ?>
                        <?php $i=0; ?>
                        <?php foreach($fees_history as $history) { ?>

                            <tr id="row-<?php echo $history['StudentFeeMap']['id']; ?>">
                                <td><?php echo ++$i; ?></td>
                                <td><?php echo date("d-M-Y",strtotime($history['StudentFeeMap']['payment_date'])); ?></td>
                                <td><?php echo ($history['StudentFeeMap']['payment_type'] == 1) ? 'Cash' : 'Cheque'; ?></td>
                                <td><?php echo ($history['StudentFeeMap']['cheque_no']) ? $history['StudentFeeMap']['cheque_no'] : '-'; ?></td>
                                <td><?php echo $history['StudentFeeMap']['amount']; ?></td>
                                <td>
                                    <button type="button" id="btn-update-history" class="btn btn-primary btn-xs" onclick="updateHistory('<?php echo $history['StudentFeeMap']['id']; ?>')"> <i class="fa fa-edit"></i></button>
                                    <button type="button" id="btn-delete-history" class="btn btn-danger btn-xs" onclick="deleteHistory('<?php echo $history['StudentFeeMap']['id']; ?>')"> <i class="fa fa-trash-o"></i></button>
                                </td>
                                <input type="hidden" name="hidden_payment_type" value="<?php echo $history['StudentFeeMap']['payment_type']; ?>" />
                                <input type="hidden" name="hidden_payment_date" value="<?php echo $history['StudentFeeMap']['payment_date']; ?>" />
                                <input type="hidden" name="hidden_cheque_no" value="<?php echo $history['StudentFeeMap']['cheque_no']; ?>" />
                                <input type="hidden" name="hidden_amount" value="<?php echo $history['StudentFeeMap']['amount']; ?>" />
                                <input type="hidden" name="hidden_payment_id" value="<?php echo $history['StudentFeeMap']['id']; ?>" />
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </tbody>
             </table>
          </div>
      </div>
  </div>

  <div class="panel-body"></div>


  <div class="modal fade" id="modal-update-fee" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
             <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-edit"></i> Update Details</h4>
             </div>
             <div class="modal-body">
                <form class="form-horizontal">

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="col-sm-5">
                               <div class="form-group">
                                   <label class="control-label" for="">Payment Type</label>
                                   <select class="form-control" name="payment_type" id="modal-payment-type">
                                       <option value="1">Cash</option>
                                       <option value="2">Cheque</option>
                                   </select>
                               </div>
                            </div>
                    		<div class="col-sm-5" style="margin-left:15px;">
                    		    <div class="form-group">
                                    <label for="input-parent" class="col-sm-2 control-label">Payment Date</label>
                                    <div class="col-sm-12">
                                       <div class="input-group date">
                                           <input type="text" readonly class="form-control" id="input-payment-date"  name="payment_date" >
                                           <span class="input-group-btn">
                                               <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                                           </span>
                                       </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                       <div class="col-sm-12">
                           <div class="col-sm-5">
                               <div class="form-group">
                                   <label class="control-label" for="max-mark">Amount</label>
                                   <input type="text" id="modal-amount" class="form-control" name="amount" value="" maxlength="10">
                               </div>
                           </div>
                           <div class="col-sm-5" style="margin-left:15px;">
                               <div class="form-group">
                                   <label class="control-label" for="">Cheque Number</label>
                                   <input type="text" id="modal-cheque-no" class="form-control" name="cheque_no" value="" maxlength="10">
                               </div>
                           </div>
                       </div>
                    </div>
                    <input type="hidden" id="student-fee-map-id" name="student_fee_map_id" value="" />
                    <input type="hidden" id="student-fee-map-id" name="fee_id" value="<?php echo $fee_id; ?>" />
                    <input type="hidden" id="student-fee-map-id" name="student_id" value="<?php echo $student_id; ?>" />
                </form>
             </div>
             <div class="modal-footer">
                <button type="button" id="btn-save-fee" class="btn btn-primary"> Save</button>
             </div>
          </div>
      </div>
  </div>

  <script src="<?php echo $this->webroot; ?>js/datetimepicker/moment.js" type="text/javascript"></script>
  <script src="<?php echo $this->webroot; ?>js/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
  <link href="<?php echo $this->webroot; ?>js/datetimepicker/bootstrap-datetimepicker.min.css" type="text/css" rel="stylesheet" media="screen" />

  <script>
      $('.date').datetimepicker({
          pickTime: false
      });

      $('#collect-fee-btn').click(function() {
          $('#modal-cheque-no').prop('disabled','disabled');
          $('#modal-update-fee').modal('show');
      });
  </script>

  <script>

      $('#modal-payment-type').change(function() {
         if(($(this).val()) == 1){
            $('#modal-cheque-no').prop('disabled','true');
         }else{
            $('#modal-cheque-no').prop('disabled',false);
         }
      });

      function updateHistory(id) {

         $('#modal-payment-type').val($('#row-'+id).find('input[name="hidden_payment_type"]').val());
         $('#input-payment-date').val($('#row-'+id).find('input[name="hidden_payment_date"]').val());
         $('#modal-amount').val($('#row-'+id).find('input[name="hidden_amount"]').val());
         $('#modal-cheque-no').val($('#row-'+id).find('input[name="hidden_cheque_no"]').val());
         $('#student-fee-map-id').val($('#row-'+id).find('input[name="hidden_payment_id"]').val());

         if($('#row-'+id).find('input[name="hidden_payment_type"]').val() == '1') {
            $('#modal-cheque-no').prop('disabled','disabled');
         }

         $('.date').datetimepicker({
            pickTime: false
         });
         $('#modal-update-fee').modal('show');
      }

      $('#btn-save-fee').click(function(){
          var $this = $(this);

          $('.text-danger,.alert-success').remove();

          $.ajax({
              url: '<?php echo $this->webroot;?>Fees/updateStudentFee',
              type: 'post',
              data : $('.modal-body input,.modal-body select'),
              dataType: 'json',
              beforeSend: function() {
                  $this.prop('disabled',true).before('<i class="fa fa-spinner fa-2x fa-spin" style="margin-right:5px;"></i>');
              },
              complete: function() {
                  $this.prop('disabled',false);
                  $('.fa-spin').remove();
              },
              success: function (response) {
                  console.log(response);
                  if (typeof response.success != 'undefined') {
                      $('#modal-update-fee').modal('hide');
                      window.location = '<?php echo $this->webroot."fees/transaction?student_id=".$student_id ."&fee_id=" .$fee_id; ?>';
                  }else{
                      if(response.error){
                          $.each(response.error, function(key,val) {
                              $('#modal-'+key).parent().append('<div class="text-danger">'+val+'</div>');
                          });
                      }
                  }
              }
          });
      });

      function deleteHistory(id) {
         $.ajax({
             'url' : '<?php echo $this->webroot."Fees/deleteStudentFee"; ?>',
             'type' : 'post',
             'data' : {student_fee_map_id : id},
             'dataType' : 'json',
             'success' : function(response){
                 if(typeof response.success != 'undefined'){
                    window.location = '<?php echo $this->webroot."fees/transaction?student_id=".$student_id ."&fee_id=" .$fee_id; ?>';
                 }
             }
         });
      }

  </script>