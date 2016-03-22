<div class="panel-body">
     <div class="row">
          <div class="col-sm-12">
                <div class="panel panel-default">
                   <div class="panel-heading">
                      <b><h3 class="panel-title"><i class="fa fa-money"></i> Fees Details</h3></b>
                   </div>
                   <div class="table-responsive">
                       <table class="table table-bordered table-hover">
                           <thead>
                               <tr>
                                   <td class="text-center">#</td>
                                   <td class="text-center">Fee Detail</td>
                                   <td class="text-center">Due Date</td>
                                   <td class="text-center">Amount</td>
                               </tr>
                           </thead>
                           <tbody>
                              <?php if($details) { ?>
                                <?php $total = 0; ?>
                                <?php foreach($details as $detail) { ?>
                                    <tr>
                                        <?php $i=1;?>
                                        <td class="text-center"><?php echo $i; ?></td>
                                        <td class="text-center"><?php echo $detail['name']; ?></td>
                                        <td class="text-center"><?php echo $detail['due_date']; ?></td>
                                        <td class="text-center"><i class="fa fa-inr"></i> <?php echo $detail['amount']; ?></td>
                                        <?php $total += $detail['original']; ?>
                                        <?php $i++; ?>
                                    <tr>
                                <?php } ?>
                                <tr>
                                    <th colspan="3" class="text-right">Total Amount</th>
                                    <th class="text-center"><i class="fa fa-inr"></i> <?php echo number_format($total,2); ?></th>
                                </tr>
                              <?php } else { ?>
                                <tr>
                                    <td colspan="5"> No Data Available</td>
                                </tr>
                              <?php } ?>
                           </tbody>
                       </table>
                   </div>
                </div>
          </div>
     </div>
  </div>

  <div class="panel-body">
       <div class="row">
            <div class="col-sm-12">
                  <div class="panel panel-default">
                     <div class="panel-heading">
                        <b><h3 class="panel-title"><i class="fa fa-users"></i> Student List</h3></b>
                     </div>
                     <div class="table-responsive">
                         <table class="table">
                             <thead>
                                 <tr>
                                     <td class="text-center">#</td>
                                     <td class="text-center">Roll Number</td>
                                     <td class="text-center">Name</td>
                                     <td class="text-center">Paid Amount</td>
                                     <td class="text-center">Remaining Amount</td>
                                     <td class="text-left">Action</td>
                                 </tr>
                             </thead>
                             <tbody>
                                <?php if($students) { ?>
                                      <?php $i=1;?>
                                      <?php foreach($students as $student) { ?>
                                          <tr>
                                              <td class="text-center"><?php echo $i; ?></td>
                                              <td class="text-center"><?php echo $student['roll_number']; ?></td>
                                              <td class="text-center"><?php echo $student['name']; ?></td>
                                              <td class="text-center"><i class="fa fa-inr"></i> <?php echo $student['paid_amount']; ?></td>
                                              <td class="text-center"><i class="fa fa-inr"></i> <?php echo $student['remaining_amount']; ?></td>
                                              <td class="text-left">
                                                <?php echo $this->Html->link('Take Fees',array('controller' => 'fees','action' => 'transaction','?' => array('student_id' => $student['id'],'fee_id' => $fee_id)),array('escape' => false ,'class' => 'btn btn-primary','data-original-title' => 'Take Fee','data-toggle' => 'tooltip')); ?>
                                              </td>
                                              <?php $i++; ?>
                                          <tr>
                                      <?php } ?>
                                      <tr class="bg-aqua">
                                          <th colspan="3" class="text-right">Grand Total</th>
                                          <th class="text-center"><i class="fa fa-inr"></i> <?php echo number_format($total_paid,2); ?></th>
                                          <th class="text-center"><i class="fa fa-inr"></i> <?php echo number_format($total_remaining,2); ?></th>
                                          <td>&nbsp;</td>
                                      </tr>
                                <?php } else { ?>
                                  <tr>
                                      <td colspan="5"> No Data Available</td>
                                  </tr>
                                <?php } ?>
                             </tbody>
                         </table>
                     </div>
                  </div>
            </div>
       </div>
  </div>