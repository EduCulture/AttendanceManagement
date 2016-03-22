
<div class="box-body table-responsive no-padding" style="overflow-x:scroll;">
    <table class="table table-bordered table-striped" style="border-collapse: collapse;background: none repeat scroll 0 0 #ffffff;">
        <tbody>
            <tr>
                <th> Days </th>
                <?php foreach($calendar as $index => $day) { ?>
                   <th style="color:<?php echo $day['color']; ?>"> <?php echo $index ."<br/>" . $day['day']; ?> </th>
                <?php } ?>
            </tr>
            <tr>
                <th> <span style= "color:green">P</span> / <span style= "color:red">A</span> </th>
                <?php foreach($calendar as  $status) { ?>
                    <?php
                     $color = '#000';
                    if($status['status'] == 'P') {
                        $color = 'green';
                    }else if($status['status'] == 'A') {
                        $color = 'red';
                    }
                    ?>
                   <th style="color : <?php echo $color; ?>"> <?php echo $status['status']; ?> </th>
                <?php } ?>
            </tr>
        </tbody>
    </table>
</div>