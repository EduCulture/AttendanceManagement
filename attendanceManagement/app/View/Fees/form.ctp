<div class="page-header">
   <div class="container-fluid">
       <div class="pull-right">
          <button class="btn btn-primary" title="" data-toggle="tooltip" form="form-standard" type="submit" data-original-title="Save"><i class="fa fa-save"></i></button>
          <?php echo $this->Html->link('<i class="fa fa-reply"></i>',array('controller' => 'fees','action' => 'index'),array('escape' => false,'data-original-title' => 'Cancel','data-toggle' => 'tooltip','class' => 'btn btn-default')); ?>
       </div>
       <h1><i class="fa fa-money"></i> Fees</h1>
       <ul class="breadcrumb">
           <li>
               <?php echo $this->Html->link('Home',array('controller' => 'dashboard')); ?>
           </li>
           <li>
               <?php echo $this->Html->link('Fee List',array('controller' => 'fees','action' => 'category')); ?>
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
          <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo (($fee_id) ? 'Edit' : 'Add'); ?> Fees</h3>
      </div>
      <div class="panel-body">
          <form id="form-standard" class="form-horizontal" method="post" action="<?php echo $this->webroot . (($fee_id) ? 'fees/edit' : 'fees/add'); ?>" enctype="multipart/form-data">
               <div class="form-group required">
                     <label for="input-parent" class="col-sm-2 control-label">Name</label>
                     <div class="col-sm-10">
                         <input type="text" name="name" class="form-control" placeholder="Name" value="<?php echo $name; ?>" />
                         <?php if($error_name){ ?>
                             <div class="text-danger"><?php echo $error_name; ?></div>
                         <?php } ?>
                     </div>
                     <input type="hidden" name="fee_id" value="<?php echo $fee_id; ?>" />
               </div>
               <div class="form-group">
                    <label for="input-parent" class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-10">
                        <textarea name="description" id="input-description" class="form-control" placeholder="Description"><?php echo $description; ?></textarea>
                    </div>
               </div>
               <div class="form-group required">
                    <label for="input-parent" class="col-sm-2 control-label">Start Date</label>
                    <div class="col-sm-3">
                       <div class="input-group date">
                           <input type="text" readonly class="form-control" id="input-date-available" data-format="DD-MM-YYYY" placeholder="Start Date" name="start_date" value="<?php echo ($start_date) ? date("m/d/Y",strtotime($start_date)) : '' ;?>">
                           <span class="input-group-btn">
                               <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                           </span>
                       </div>
                       <div>
                          <?php if($error_start_date){ ?>
                              <div class="text-danger"><?php echo $error_start_date; ?></div>
                          <?php } ?>
                       </div>
                    </div>
               </div>
               <div class="form-group required">
                   <label for="input-parent" class="col-sm-2 control-label">Due Date</label>
                   <div class="col-sm-3">
                      <div class="input-group date">
                          <input type="text" readonly class="form-control" id="input-date-available" data-format="DD-MM-YYYY" placeholder="Due Date" name="due_date" value="<?php echo ($due_date) ? date("m/d/Y",strtotime($due_date)) : '' ;?>">
                          <span class="input-group-btn">
                              <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                          </span>
                      </div>
                      <div>
                         <?php if($error_due_date){ ?>
                             <div class="text-danger"><?php echo $error_due_date; ?></div>
                         <?php } ?>
                      </div>
                   </div>
               </div>

               <div role="tabpanel" class="tab-pane fade in" id="tab-standard">
                   <div class="row">
                     <div class="col-sm-2">
                         <ul class="nav nav-pills nav-stacked" id="standard">
                               <?php $standard_row = 0; ?>
                               <?php foreach ($standard_fee as $standard) { ?>
                                   <li><a href="#tab-standard<?php echo $standard_row; ?>" data-toggle="tab"><i class="fa fa-minus-circle" onclick="$('a[href=\'#tab-standard<?php echo $standard_row; ?>\']').parent().remove(); $('#tab-standard<?php echo $standard_row; ?>').remove(); $('#standard a:first').tab('show');"></i> <?php echo $standard['standard_name']; ?></a></li>
                                   <?php $standard_row++; ?>
                               <?php } ?>
                               <li>
                                 <input type="text" name="standard_name" value="" placeholder="Name" id="input-section" class="form-control" />
                               </li>
                         </ul>
                     </div>
                     <div class="col-sm-10">
                         <div class="tab-content">
                               <?php $standard_row = 0; ?>
                               <?php $fee_row = 0; ?>
                               <?php foreach ($standard_fee as $standard) { ?>
                                   <div class="tab-pane" id="tab-standard<?php echo $standard_row; ?>">
                                     <input type="hidden" name="standard_fee[<?php echo $standard_row; ?>][standard_name]" value="<?php echo $standard['standard_name']; ?>" />
                                     <input type="hidden" name="standard_fee[<?php echo $standard_row; ?>][standard_id]" value="<?php echo $standard['standard_id']; ?>" />

                                         <div class="table-responsive">
                                           <table id="fee-heading<?php echo $standard_row; ?>" class="table table-striped table-bordered table-hover">
                                             <thead>
                                               <tr>
                                                 <td class="text-left required">Price</td>
                                               </tr>
                                             </thead>
                                             <tbody>
                                               <tr id="fee-row0">
                                                  <td class="text-left">
                                                      <input type="text" class="form-control" name="standard_fee[<?php echo $standard_row; ?>][amount]" value="<?php echo $standard['amount']; ?>" />
                                                      <?php if(isset($error_amount[$standard_row])) { ?>
                                                        <div>
                                                           <div class="text-danger"><?php echo $error_amount[$standard_row]; ?></div>
                                                        </div>
                                                      <?php } ?>
                                                  </td>
                                               </tr>
                                             </tbody>
                                           </table>
                                         </div>
                                   </div>
                                   <?php $standard_row++; ?>
                               <?php } ?>
                         </div>
                     </div>
                   </div>
               </div>
          </form>
      </div>
   </div>
</div>

<link href="<?php echo $this->webroot; ?>js/summernote//summernote.css" rel="stylesheet" />
<script src="<?php echo $this->webroot; ?>js/summernote/summernote.js" type="text/javascript"></script>

<script>
    $('#input-description').summernote({
        height: 170
    });
</script>


<script>
var standard_row = <?php echo $standard_row; ?>;

$('input[name=\'standard_name\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: '<?php echo $this->webroot.'standards/getStandardSuggestion'; ?>?filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
					    label: item['standard_name'],
                        value: item['standard_id']
					}
				}));
			}
		});
	},
	'select': function(item) {

	    $('input[name=\'standard_name\']').val('');
        html  = '<div class="tab-pane" id="tab-standard' + standard_row + '">';
        html += '	<input type="hidden" name="standard_fee[' + standard_row + '][standard_id]" value="'+ item['value'] +'" />';
        html += '	<input type="hidden" name="standard_fee[' + standard_row + '][standard_name]" value="' + item['label'] + '" />';

        html += '<div class="table-responsive">';
        html += '  <table id="fee-heading'+standard_row+'" class="table table-striped table-bordered table-hover">';
        html += '    <thead>';
        html += '      <tr>';
        html += '        <td class="text-left required">Amount</td>';
        html += '      </tr>';
        html += '    </thead>';
        html += '    <tbody>';
        html += '      <tr id="fee-row'+standard_row+'">';
        html += '        <td class="text-left"><input type="text" name="standard_fee[' + standard_row + '][amount]" class="form-control" /></td>';
        html += '      </tr>';
        html += '    </tbody>';
        html += '  </table>';
        html += '</div>';

        html += '</div>';

        $('#tab-standard .tab-content').append(html);

        $('#standard > li:last-child').before('<li><a href="#tab-standard' + standard_row + '" data-toggle="tab"><i class="fa fa-minus-circle" onclick="$(\'a[href=\\\'#tab-standard' + standard_row + '\\\']\').parent().remove(); $(\'#tab-standard' + standard_row + '\').remove(); $(\'#option a:first\').tab(\'show\')"></i> ' + item['label'] + '</li>');

        $('#standard a[href=\'#tab-standard' + standard_row + '\']').tab('show');

        standard_row++;
	}
});
</script>

<script src="<?php echo $this->webroot; ?>js/datetimepicker/moment.js" type="text/javascript"></script>
<script src="<?php echo $this->webroot; ?>js/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<link href="<?php echo $this->webroot; ?>js/datetimepicker/bootstrap-datetimepicker.min.css" type="text/css" rel="stylesheet" media="screen" />

<script>

$('.date').datetimepicker({
    pickTime: false,
    minDate:new Date()
});
</script>

