
<!-- User Chart -->
<div class="col-lg-5 col-md-12 col-sx-12 col-sm-12">
  <div class="panel panel-default">
     <div class="panel-heading">
        <div class="pull-right"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-calendar"></i> <i class="caret"></i></a>
           <ul id="range-user" class="dropdown-menu dropdown-menu-right">
              <li><a href="week">Week</a></li>
              <li class="active"><a href="month">Month</a></li>
              <li><a href="year">Year</a></li>
           </ul>
        </div>
        <h3 class="panel-title"><i class="fa fa-user"></i>School Analytics</h3>
     </div>
     <div class="panel-body">
          <div id="chart-user" style="width: 100%; height: 260px;"></div>
     </div>
  </div>
</div>


<?php /*
<script type="text/javascript" src= "<?php echo $this->webroot; ?>js/flot/jquery.flot.js"></script>
<script type="text/javascript" src="<?php echo $this->webroot; ?>js/flot/jquery.flot.resize.min.js"></script>
<script type="text/javascript">
    $('#range a').on('click', function(e) {
        e.preventDefault();

        $(this).parent().parent().find('li').removeClass('active');

        $(this).parent().addClass('active');

        $.ajax({
            type: 'get',
            url: '<?php echo $this->webroot;?>dashboard/getDeviceChartDetails?range='+$(this).attr('href'),
            //url: 'chart/chart_ajax.php?range=' + $(this).attr('href'),
            dataType: 'json',
            success: function(json) {
                if (typeof json['andr'] == 'undefined') { return false; }
                var option = {
                    shadowSize: 0,
                    colors: ['#77C159', '#666666','#2CA1E1'],
                    bars: {
                        show: true,
                        fill: true,
                        lineWidth: 1
                    },
                    grid: {
                        backgroundColor: '#FFFFFF',
                        hoverable: true
                    },
                    points: {
                        show: false
                    },
                    xaxis: {
                        show: true,
                        ticks: json['xaxis']
                    }
                }

                $.plot('#chart-sale', [json['andr'], json['iphn'],json['win']], option);

                $('#chart-sale').bind('plothover', function(event, pos, item) {
                    $('.tooltip').remove();

                    if (item) {
                        $('<div id="tooltip" class="tooltip top in"><div class="tooltip-arrow"></div><div class="tooltip-inner">' + item.datapoint[1] + ' Device' + '</div></div>').prependTo('body');

                        $('#tooltip').css({
                            position: 'absolute',
                            left: item.pageX - ($('#tooltip').outerWidth() / 2),
                            top: item.pageY - $('#tooltip').outerHeight(),
                            pointer: 'cusror'
                        }).fadeIn('slow');

                        $('#chart-sale').css('cursor', 'pointer');
                    } else {
                        $('#chart-sale').css('cursor', 'auto');
                    }
                });

                $('.legendColorBox').find('div:first').css('margin-right','5px');
            }

        });
    });


    $('#range .active a').trigger('click');
</script>

<script>
    $('#range-user a').on('click', function(e) {
        e.preventDefault();

        $(this).parent().parent().find('li').removeClass('active');

        $(this).parent().addClass('active');

        $.ajax({
            type: 'get',
            url: '<?php echo $this->webroot;?>dashboard/getUserChartDetails?range='+$(this).attr('href'),
            //url: 'chart/user_ajax.php?range=' + $(this).attr('href'),
            dataType: 'json',
            success: function(json) {
                if (typeof json['user'] == 'undefined') { return false; }
                var option = {
                    shadowSize: 0,
                    colors: ['#DD4B39','#3B5998','#424242'],
                    bars: {
                        show: true,
                        fill: true,
                        lineWidth: 1
                    },
                    grid: {
                        backgroundColor: '#FFFFFF',
                        hoverable: true
                    },
                    points: {
                        show: false
                    },
                    xaxis: {
                        show: true,
                        ticks: json['xaxis']
                    }
                }

                $.plot('#chart-user', [json['ggl_user'],json['fb_user'],json['user']], option);

                $('#chart-user').bind('plothover', function(event, pos, item) {
                    $('.tooltip').remove();

                    if (item) {
                        $('<div id="tooltip" class="tooltip top in"><div class="tooltip-arrow"></div><div class="tooltip-inner">' + item.datapoint[1] +' User' + '</div></div>').prependTo('body');

                        $('#tooltip').css({
                            position: 'absolute',
                            left: item.pageX - ($('#tooltip').outerWidth() / 2),
                            top: item.pageY - $('#tooltip').outerHeight(),
                            pointer: 'cusror'
                        }).fadeIn('slow');

                        $('#chart-user').css('cursor', 'pointer');
                    } else {
                        $('#chart-user').css('cursor', 'auto');
                    }
                });

                $('.legendColorBox').find('div:first').css('margin-right','5px');
            }
        });
    });

    $('#range-user .active a').trigger('click');
</script>
*/ ?>