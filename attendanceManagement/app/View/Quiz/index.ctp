<div class="page-header">
    <div class="container-fluid">
        <h1> <i class="fa fa-calendar fa-fw"></i> Quiz of the Day Log</h1>
        <?php if(!empty($quiz_success)) { ?>
            <div class="alert alert-success">
                <i class="fa fa-check-circle"></i> <?php echo $quiz_success; ?><button data-dismiss="alert" class="close" type="button">×</button>
            </div>
        <?php } ?>
    </div>
</div>



<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-list"></i> Quiz List</h3>
            <form method="post">
                <button type="submit" id="btngetquiz" style="margin-top: -20px;display:none;" name="btngetquiz" class="btn btn-success btn-xs pull-right" value=""><i class="fa fa-calendar"></i> Send Quiz</button>
            </form>
        </div>
        <div class="panel-body">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-search"></i> Filter</h3>
                    <a data-toggle="collapse" href="#filter-panel" aria-expanded="false" aria-controls="collapseExample"><span class="hidden-xs hidden-sm hidden-md pull-right"><i class="fa fa-list"></i></span> </a>
                </div>
                <div class="panel-body collapse <?php echo ($is_filter) ? 'in' : ''; ?>" id="filter-panel">
                    <div class="well">
                        <form enctype="multipart/form-data" method="post">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="input-name" class="control-label">Word</label>
                                        <input type="text" class="form-control" id="input-name" placeholder="Word" value="" name="filter_word">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">Quiz Date</label>
                                        <div class="input-group date">
                                            <input type="text" class="form-control" id="input-date-available" data-date-format="DD-MM-YYYY" placeholder="Date" value="" readonly name="filter_date">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <button class="btn btn-primary pull-left" style="margin-top:20px;" id="button-filter" type="submit"><i class="fa fa-search"></i> Filter</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <form id="quiz-list" enctype="multipart/form-data" method="post">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <td class="text-left" style="width: 10%">Date</td>
                            <td class="text-left">Word</td>
                            <td class="text-left">Option 1</td>
                            <td class="text-left">Option 2</td>
                            <td class="text-left">Option 3</td>
                            <td class="text-left">Option 4</td>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if($quiz) { ?>
                            <?php foreach($quiz as $data) { ?>
                                <tr>
                                    <td class="text-left"><?php echo date("d M, Y h:i A",strtotime($data['Quiz']['sent_date'])); ?></td>
                                    <td class="text-left"><?php echo $data['Word']['word_name']; ?></td>
                                    <td class="text-left"><?php echo ($data['Quiz']['correct_option_no'] == 0) ? "<span class='alert-success' style='background:none;'><i class='fa fa-check-square fa-lg'></i></span>" : '';?>  <?php echo " ".$data['Quiz']['option1']; ?></td>
                                    <td class="text-left"><?php echo ($data['Quiz']['correct_option_no'] == 1) ? "<span class='alert-success' style='background:none;'><i class='fa fa-check-square fa-lg'></i></span>" : '';?><?php echo " ".$data['Quiz']['option2']; ?></td>
                                    <td class="text-left"><?php echo ($data['Quiz']['correct_option_no'] == 2) ? "<span class='alert-success' style='background:none;'><i class='fa fa-check-square fa-lg'></i></span>" : '';?><?php echo " ".$data['Quiz']['option3']; ?></td>
                                    <td class="text-left"><?php echo ($data['Quiz']['correct_option_no'] == 3) ? "<span class='alert-success' style='background:none;'><i class='fa fa-check-square fa-lg'></i></span>" : '';?><?php echo " ".$data['Quiz']['option4']; ?></td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="7" class="text-center">No Data Available</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            </form>
            <div class="row">
                <div class="col-sm-6 text-left"><?php echo $this->Paginator->numbers(); ?></div>
                <div class="col-sm-6 text-right">
                    <?php echo $this->Paginator->counter('Showing {:start} to {:end} of {:count} ({:pages} Pages)'); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    echo $this->Html->script('moment.js');
    echo $this->Html->script('bootstrap-datetimepicker.min.js');
    echo $this->Html->css('bootstrap-datetimepicker.min.css');
?>
<script>
    $('.date').datetimepicker({
        pickTime: false
    });
</script>