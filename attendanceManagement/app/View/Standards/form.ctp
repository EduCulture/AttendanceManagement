<div class="page-header">
   <div class="container-fluid">
       <div class="pull-right">
          <button class="btn btn-primary" title="" data-toggle="tooltip" form="form-standard" type="submit" data-original-title="Save"><i class="fa fa-save"></i> Save</button>
          <?php echo $this->Html->link('<i class="fa fa-reply"></i> Cancel',array('controller' => 'standards','action' => 'index'),array('escape' => false,'data-original-title' => 'Cancel','data-toggle' => 'tooltip','class' => 'btn btn-default')); ?>
       </div>
       <h1>Standards</h1>
       <ul class="breadcrumb">
           <li>
               <?php echo $this->Html->link('Home',array('controller' => 'dashboard')); ?>
           </li>
           <li>
               <?php echo $this->Html->link('Standards List',array('controller' => 'standards','action' => 'index')); ?>
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
          <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo (($standard_id) ? 'Edit' : 'Add'); ?> Standards</h3>
      </div>
      <div class="panel-body">
          <form id="form-standard" class="form-horizontal" method="post" action="<?php echo $this->webroot . (($standard_id) ? 'standards/edit' : 'standards/add'); ?>" enctype="multipart/form-data">
               <div class="form-group required">
                     <label for="input-parent" class="col-sm-2 control-label">Name</label>
                     <div class="col-sm-10">
                         <input type="text" name="name" class="form-control" placeholder="Name" value="<?php echo $name; ?>" />
                         <?php if($error_name){ ?>
                             <div class="text-danger"><?php echo $error_name; ?></div>
                         <?php } ?>
                     </div>
                     <input type="hidden" name="standard_id" value="<?php echo $standard_id; ?>" />
               </div>

               <div role="tabpanel" class="tab-pane fade in" id="tab-section">
                   <div class="row">
                     <div class="col-sm-2">
                         <ul class="nav nav-pills nav-stacked" id="section">
                               <?php $section_row = 0; ?>
                               <?php foreach ($staff_subject as $section) { ?>
                                   <li><a href="#tab-section<?php echo $section_row; ?>" data-toggle="tab"><i class="fa fa-minus-circle" onclick="$('a[href=\'#tab-section<?php echo $section_row; ?>\']').parent().remove(); $('#tab-section<?php echo $section_row; ?>').remove(); $('#section a:first').tab('show');"></i> <?php echo $section['section_name']; ?></a></li>
                                   <?php $section_row++; ?>
                               <?php } ?>
                               <li>
                                 <input type="text" name="section" value="" placeholder="Section" id="input-section" class="form-control" />
                               </li>
                         </ul>
                     </div>
                     <div class="col-sm-10">
                         <div class="tab-content">
                               <?php $section_row = 0; ?>
                               <?php $subject_row = 0; ?>
                               <?php foreach ($staff_subject as $section) { ?>
                                   <div class="tab-pane" id="tab-section<?php echo $section_row; ?>">
                                     <input type="hidden" name="staff_subject[<?php echo $section_row; ?>][section_name]" value="<?php echo $section['section_name']; ?>" />
                                     <input type="hidden" name="staff_subject[<?php echo $section_row; ?>][section_id]" value="<?php echo $section['section_id']; ?>" />

                                     <div class="table-responsive">
                                       
                                       <table id="subject-heading<?php echo $section_row; ?>" class="table table-striped table-bordered table-hover">
                                         <thead>
                                           <tr>
                                             <td class="text-left">Subjects</td>
                                             <td class="text-right">Staff</td>
                                             <td></td>
                                           </tr>
                                         </thead>
                                         <tbody>
                                           <?php foreach ($section['details'] as $section_staff_value) { ?>
                                               <tr id="subject-row<?php echo $subject_row; ?>">
                                                   <td class="text-left">
                                                       <select id="subject-dropdown-<?php echo $subject_row; ?>" name="staff_subject[<?php echo $section_row; ?>][details][<?php echo $subject_row; ?>][subject_id]"  class="form-control">
                                                           <?php foreach($subjects as $subject) { ?>
                                                               <option value="<?php echo $subject['Subject']['id']; ?>" <?php echo ($subject['Subject']['id']==$section_staff_value['subject_id']) ? 'selected="selected"' : ''; ?> ><?php echo $subject['Subject']['name']; ?></option>
                                                            <?php } ?>
                                                       </select>
                                                   </td>
                                                   <td class="text-right">
                                                       <select id="staff-dropdown-<?php echo $subject_row; ?>'" name="staff_subject[<?php echo $section_row; ?>][details][<?php echo $subject_row; ?>][staff_id]" class="form-control">
                                                           <?php foreach($staffs as $staff) { ?>
                                                               <option value="<?php echo $staff['Staff']['id']; ?>" <?php echo ($staff['Staff']['id']==$section_staff_value['staff_id']) ? 'selected="selected"' : ''; ?> ><?php echo $staff['Staff']['first_name'].' '.$staff['Staff']['last_name']; ?></option>
                                                           <?php } ?>
                                                       </select>
                                                   </td>
                                                   <td class="text-left"><button type="button" onclick="$(this).tooltip(\'destroy\');$(\'#$subject-row<?php echo $subject_row; ?>'.'\').remove();" data-toggle="tooltip" rel="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                                               </tr>
                                               <?php $subject_row++; ?>
                                           <?php } ?>
                                         </tbody>
                                         <tfoot>
                                           <tr>
                                             <td colspan="6"></td>
                                             <td class="text-left"><button type="button" onclick="addSubjectValue('<?php echo $section_row; ?>');" data-toggle="tooltip" title="Add Staff" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                                           </tr>
                                         </tfoot>
                                       </table>
                                     </div>
                                   </div>
                                   <?php $section_row++; ?>
                               <?php } ?>
                         </div>
                     </div>
                   </div>
               </div>
          </form>
      </div>
   </div>
</div>


<script>

var section_row = <?php echo $section_row; ?>;

$('input[name=\'section\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: '<?php echo $this->webroot.'standards/getSuggestion'; ?>?filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
					    label: item['section_name'],
                        value: item['section_id']
					}
				}));
			}
		});
	},
	'select': function(item) {

	    $('input[name=\'section\']').val('');
        html  = '<div class="tab-pane" id="tab-section' + section_row + '">';
        html += '	<input type="hidden" name="staff_subject[' + section_row + '][section_id]" value="'+ item['value'] +'" />';
        html += '	<input type="hidden" name="staff_subject[' + section_row + '][section_name]" value="' + item['label'] + '" />';

        html += '<div class="table-responsive">';
        
        html += '  <table id="subject-heading'+section_row+'" class="table table-striped table-bordered table-hover">';
        html += '    <thead>';
        html += '      <tr>';
        html += '        <td class="text-left">Subjects</td>';
        html += '        <td class="text-right">Staff</td>';
        html += '        <td></td>';
        html += '      </tr>';
        html += '    </thead>';
        html += '    <tbody>';
        html += '    </tbody>';
        html += '    <tfoot>';
        html += '      <tr>';
        html += '        <td colspan="6"></td>';
        html += '        <td class="text-left"><button type="button" data-toggle="tooltip" onClick="addSubjectValue('+section_row+')" title="Add" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>';
        html += '      </tr>';
        html += '    </tfoot>';
        html += '  </table>';
        html += '</div>';

        html += '</div>';

        $('#tab-section .tab-content').append(html);

        $('#section > li:last-child').before('<li><a href="#tab-section' + section_row + '" data-toggle="tab"><i class="fa fa-minus-circle" onclick="$(\'a[href=\\\'#tab-section' + section_row + '\\\']\').parent().remove(); $(\'#tab-section' + section_row + '\').remove(); $(\'#option a:first\').tab(\'show\')"></i> ' + item['label'] + '</li>');

        $('#section a[href=\'#tab-section' + section_row + '\']').tab('show');

        section_row++;
	}
});
</script>

<script>

var subject_row = <?php echo $subject_row; ?>;
var section_row = <?php echo $section_row; ?>;

function addSubjectValue(section_row) {
    //alert(subject_row);
	html  = '<tr id="subject-row' + subject_row + '">';
	html += '  <td class="text-left"><select id="subject-dropdown-'+subject_row+'" onchange="getSubjectTeachers('+subject_row+')" name="staff_subject[' + section_row + '][details][' + subject_row + '][subject_id]" class="form-control">';
	    <?php foreach($subjects as $subject) { ?>
	html += ' <option value="<?php echo $subject['Subject']['id']; ?>"><?php echo $subject['Subject']['name']; ?></option>';
	    <?php } ?>
	html += '  </select></td>';

    html += '  <td class="text-left"><select id="staff-dropdown-'+subject_row+'" name="staff_subject[' + section_row + '][details][' + subject_row + '][staff_id]" class="form-control">';

    html += '  </select></td>';

    html += '  <td class="text-left"><button type="button" onclick="$(this).tooltip(\'destroy\');$(\'#subject-row' + subject_row + '\').remove();" data-toggle="tooltip" rel="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
	html += '</tr>';

	$('#subject-heading' + section_row + ' tbody').append(html);
    $('[rel=tooltip]').tooltip();

    getSubjectTeachers(subject_row);

	subject_row++;
}

function getSubjectTeachers(row) {

    subject_id = $('#subject-dropdown-'+row).val();

    $.ajax({
        url: '<?php echo $this->webroot;?>subjects/getSubjectStaff',
        type: 'post',
        data: {subject_id : subject_id},
        dataType: 'json',
        success: function (response) {
            if(response) {
                html = '';
                for(i=0;i<response.length;i++) {
                    html += '<option value='+response[i].staff_id+'>'+ response[i].staff_name + '</option>';
                }
                $('#staff-dropdown-'+row).html(html);
            }
        }
    });
}
</script>

