<div class="page-header">
    <div class="container-fluid">
        <h1><i class="fa fa-line-chart"></i> Students Statistics</h1>
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
       <div class="col-md-6">
          <div class="box box-warning">
             <div class="box-header with-border">
                 <h4 class="box-title"><i class="fa fa-pie-chart"></i> Standard Wise Total Students</h4>
             </div>
             <div class="box-body">
                <div id="standard-student-detail" style="max-width: 500px; height: 400px; margin: 0 auto">
                </div>
             </div>
          </div>
       </div>
       <div class="col-md-6">
           <div class="box box-info">
              <div class="box-header with-border">
                  <h4 class="box-title"><i class="fa fa-bar-chart"></i> Year Wise Admission</h4>
              </div>
              <div class="box-body">
                 <div id="month-student-detail" style="max-width: 500px; height: 400px; margin: 0 auto">
                 </div>
              </div>
           </div>
       </div>
    </div>

    <div class="row">
        <div class="col-md-12">
           <div class="box box-info">
              <div class="box-header with-border">
                  <h4 class="box-title"><i class="fa fa-list-ul"></i> Recently Added Student</h4>
              </div>
              <div class="box-body table-responsive">
                 <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                           <th class="text-center">Roll Number</th>
                           <th class="text-center">Student Name</th>
                           <th class="text-center">Standard</th>
                           <th class="text-center">Section</th>
                           <th class="text-center">Joining Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($students) { ?>
                            <?php foreach($students as $student) { ?>
                                <tr>
                                    <td class="text-center"><?php echo $student['Student']['roll_number']; ?></td>
                                    <td class="text-center"><?php echo $student['Student']['first_name'].' '.$student['Student']['last_name']; ?></td>
                                    <td class="text-center"><?php echo $student['Standard']['name']; ?></td>
                                    <td class="text-center"><?php echo $student['Section']['name']; ?></td>
                                    <td class="text-center"><?php echo date("d-M-Y",strtotime($student['Student']['date_added'])); ?></td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                 </table>
              </div>
              <div class="box-footer clearfix">
                  <a class="btn btn-sm btn-info btn-flat pull-left" href="<?php echo $this->webroot."students/index";?>">Add Student</a>
                  <a class="btn btn-sm btn-default btn-flat pull-right" href="<?php echo $this->webroot."students/add";?>">View All Students</a>
              </div>
           </div>
        </div>
    </div>
</div>


<script src="http://code.highcharts.com/highcharts.js"></script>
<script>
$(function () {
    $('#month-student-detail').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Monthly Average Admission'
        },
        xAxis: {
            categories: [
                'Jan',
                'Feb',
                'Mar',
                'Apr',
                'May',
                'Jun',
                'Jul',
                'Aug',
                'Sep',
                'Oct',
                'Nov',
                'Dec'
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Admission Count'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y: 1f}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [
            {
                name: '2015',
                //data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 0, 194.1, 95.6, 54.4],
                data : <?php echo $month_admission; ?>
            },
        ]
    });


    $('#standard-student-detail').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: ''
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.y:1f}</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: false
                },
                showInLegend: true
            }
        },
        series: [{
            name: "Total Students",
            colorByPoint: true,
            data: <?php echo $standard_count; ?>
        }]
    });

    $('svg').find('text:last').remove();
});
</script>