<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-teal">
            <div class="inner">
                <h3><?php echo $student_count; ?></h3>
                <p>Total Students</p>
            </div>
            <div class="icon">
                <i class="fa fa-users"></i>
            </div>
            <a target="_blank" href="<?php echo $this->webroot.'students'; ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3><?php echo $staff_count; ?></h3>
                <p>Total Staffs</p>
            </div>
            <div class="icon">
                <i class="fa fa-user"></i>
            </div>
            <a class="small-box-footer" href="<?php echo $this->webroot.'staffs'; ?>" target="_blank">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3><?php echo $subject_count; ?></h3>
                <p>Total Subjects</p>
            </div>
            <div class="icon">
                <i class="fa fa-graduation-cap"></i>
            </div>
            <a class="small-box-footer" href="<?php echo $this->webroot.'subjects'; ?>" target="_blank">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3>48000</h3>
                <p>Total Revenue</p>
            </div>
            <div class="icon">
                <i class="fa fa-inr"></i>
            </div>
            <a class="small-box-footer" href="<?php echo $this->webroot.'fees/category'; ?>" target="_blank">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>