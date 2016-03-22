
<div class="panel-body">
  <table class="table table-bordered">
        <thead>
          <tr>
             <td class="text-left">Date Added</td>
             <td class="text-left">Staff Name</td>
             <td class="text-left">Remark</td>
          </tr>
        </thead>
        <tbody>
          <?php if($remarks) { ?>
              <?php foreach($remarks as $remark) { ?>
                  <tr>
                    <td class="text-left"><?php echo date("d-M-y",strtotime($remark['Remark']['date_added'])); ?></td>
                    <td class="text-left"><?php echo $remark['Staff']['first_name'].' '.$remark['Staff']['last_name']; ?></td>
                    <td class="text-left"><?php echo $remark['Remark']['remarks']; ?></td>
                  </tr>
              <?php } ?>
          <?php } else { ?>
              <tr>
                <td colspan="5">No Data Available</td>
              </tr>
          <?php } ?>
        </tbody>
  </table>
</div>

