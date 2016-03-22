<div class="page-header">
    <div class="container-fluid">
        <h1><i class="fa fa-th-list"></i> Student Result Summary</h1>
        <ul class="breadcrumb">
            <li>
                <?php echo $this->Html->link('Home',array('controller' => 'dashboard')); ?>
            </li>
            <li>
                <?php echo $this->Html->link('Exam',array('controller' => 'exams','action' => 'index')); ?>
            </li>
        </ul>
    </div>
</div>


<div class="col-sm-12">
    <div class="box box-info box-solid">
        <div class="box-header with-border">
            <h4 class="box-title"><i class="fa fa-search"></i> Search Students</h4>
            <div class="box-tools pull-right">
                <button data-toggle="collapse" data-target="#serach-panel" style="background-color:#00c0ef;" class="btn btn-box-tool btn-xs"><i class="fa fa-minus"></i></button>
            </div>
        </div>

        <div id="serach-panel">
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group field-examresults-stu_id required">
                            <input type="text" id="search-student" class="form-control" name="search_student" placeholder="Enter Student Name" autocomplete="off">
                            <p class="help-block help-block-error"></p>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <strong class="text-info hint">
                            [HINT : Enter Student first name or last name]
                        </strong>
                    </div>
                </div>
            </div>
            <?php /*
            <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="search">Submit</button>		<button type="reset" class="btn btn-default btn-create">Reset</button>
            </div>
            */ ?>
        </div>
    </div>

    <div id="append-div">

    </div>
</div>

<div class="panel-body"></div>

<script>
$('input[name=\'search_student\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: '<?php echo $this->webroot.'students/getSuggestion'; ?>?filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
					    label: item['student_name'] + ' - ' + item['standard_name'] + ' ' + item['section_name'] ,
                        value: item['student_id'],
                        standard_id : item['standard_id'],
                        section_id : item['section_id']
					}
				}));
			}
		});
	},
	'select': function(item) {

        //alert(item.standard_id);
	    $('input[name=\'section\']').val('');
        $.ajax({
            'url' : '<?php echo $this->webroot."exams/getStudentExamReport"; ?>',
            'type' : 'post',
            'data' : {student_id : item.value,standard_id : item.standard_id, section_id : item.section_id},
            'dataType' : 'html',
            'success' : function(response){
                if(response){
                    $('#append-div').html(response);
                }
            }
        });
	}
});
</script>