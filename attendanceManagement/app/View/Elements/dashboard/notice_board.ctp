<div class="col-lg-7 col-md-12 col-sx-12 col-sm-12" style="min-height:100px;">
   <div class="panel panel-body" style="border-top-color:#f4f4f4;border-left-color:#f4f4f4">
       <div class="nav-tabs-custom">
          <!-- Nav tabs -->
          <ul class="nav nav-tabs pull-right">
              <li role="presentation"><a href="#tab-staff" role="tab" data-toggle="tab">Staff</a></li>
              <li role="presentation"><a href="#tab-student" role="tab" data-toggle="tab">Student</a></li>
              <li role="presentation" class="active"><a href="#tab-general" role="tab" data-toggle="tab">General</a></li>
              <li class="pull-left header"><i class="fa fa-inbox"></i> Notice Board</li>
          </ul>

          <div class="tab-content" style="overflow: hidden; width: auto; height: 300px;padding : 15px;">
              <div role="tabpanel" class="tab-pane fade in active" id="tab-general">
                 <?php if($all) { ?>
                    <?php foreach($all as $val) { ?>
                        <div class="notice-main bg-light-blue">
                            <div class="notice-disp-date">
                                <small class="label label-success"><i class="fa fa-calendar"></i> <?php echo $val['notice_date']; ?></small>
                            </div>
                            <div class="notice-body">
                                 <div class="notice-title">
                                    <a class="noticeModalLink" href="#" style="color:#FFF" data-value="/dashboard/notice/view-popup?id=3"> <?php echo $val['title']; ?></a>&nbsp;
                                 </div>
                                 <div class="notice-desc"><?php echo $val['description']; ?> </div>
                            </div>
                        </div>
                    <?php } ?>
                 <?php } else { ?>
                    <div class="box-header bg-warning"><div style="padding:5px">No Notice Available</div></div>
                 <?php } ?>
              </div>
              <div role="tabpanel" class="tab-pane fade in" id="tab-student">
                 <?php if($students) { ?>
                     <?php foreach($students as $student) { ?>
                         <div class="notice-main bg-light-blue">
                             <div class="notice-disp-date">
                                 <small class="label label-success"><i class="fa fa-calendar"></i> <?php echo $student['notice_date']; ?></small>
                             </div>
                             <div class="notice-body">
                                  <div class="notice-title">
                                     <a class="noticeModalLink" href="#" style="color:#FFF" data-value="/dashboard/notice/view-popup?id=3"> <?php echo $student['title']; ?></a>&nbsp;
                                  </div>
                                  <div class="notice-desc"><?php echo $student['description']; ?> </div>
                             </div>
                         </div>
                     <?php } ?>
                 <?php } else { ?>
                    <div class="box-header bg-warning"><div style="padding:5px">No Notice Available</div></div>
                 <?php } ?>
              </div>
              <div role="tabpanel" class="tab-pane fade in" id="tab-staff">
                  <?php if($staffs) { ?>
                     <?php foreach($staffs as $staff) { ?>
                         <div class="notice-main bg-light-blue">
                             <div class="notice-disp-date">
                                 <small class="label label-success"><i class="fa fa-calendar"></i> <?php echo $staff['notice_date']; ?></small>
                             </div>
                             <div class="notice-body">
                                  <div class="notice-title">
                                     <a class="noticeModalLink" href="#" style="color:#FFF" data-value="/dashboard/notice/view-popup?id=3"> <?php echo $staff['title']; ?></a>&nbsp;
                                  </div>
                                  <div class="notice-desc"><?php echo $staff['description']; ?> </div>
                             </div>
                         </div>
                     <?php } ?>
                  <?php } else { ?>
                      <div class="box-header bg-warning"><div style="padding:5px">No Notice Available</div></div>
                  <?php } ?>
              </div>
          </div>
       </div>
   </div>
</div>
