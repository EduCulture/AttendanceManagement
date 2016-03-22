<nav id="column-left">
    <ul id="menu">
        <?php /*
        <li id="dashboard">
            <?php echo $this->Html->link('<i class="fa fa-dashboard fa-fw"></i> <span>Dashboard</span> ', array('controller' => 'dashboard', 'action' => 'index'),array('escape' => false));  ?>
        </li>

        <?php if(!CakeSession::read('Auth.User.school_id')){ ?>
            <li><?php echo $this->Html->link('<i class="fa fa-building"></i> <span>Classes</span>', array('controller' => 'schools', 'action' => 'index'),array('escape' => false));  ?></li>
            <li><?php echo $this->Html->link('<i class="fa fa-users"></i> <span>Roles</span>', array('controller' => 'roles', 'action' => 'index'),array('escape' => false));  ?></li>
        <?php } ?>

        <?php if(CakeSession::read('Auth.User.school_id')){ ?>
        <li><?php echo $this->Html->link('<i class="fa fa-user-md"></i> <span>Staff</span>', array('controller' => 'staffs', 'action' => 'index'),array('escape' => false));  ?></li>

        <li id="catalog"><a class="parent"><i class="fa fa-users"></i> <span>Students</span></a>
            <ul>
                <li>
                    <?php echo $this->Html->link('<i class="fa fa-users"></i> <span>Manage Students</span>', array('controller' => 'students', 'action' => 'index'),array('escape' => false));  ?>
                </li>
                <li>
                    <?php echo $this->Html->link('<i class="fa fa-line-chart"></i> <span>Report</span>', array('controller' => 'students', 'action' => 'report'),array('escape' => false));  ?>
                </li>
            </ul>
        </li>

        <li><?php echo $this->Html->link('<i class="fa fa-comments"></i> <span>Remarks</span>', array('controller' => 'remarks', 'action' => 'index'),array('escape' => false));  ?></li>
        <!-- <li><?php echo $this->Html->link('<i class="fa fa-flag"></i> <span>Event Management</span>', array('controller' => 'events', 'action' => 'index'),array('escape' => false));  ?></li> -->
        <li><a class="parent"><i class="fa fa-sitemap"></i> <span>Cluster Management</span></a>
            <ul>
                <li><?php echo $this->Html->link('<i class="fa fa-building-o"></i> <span> Cluster</span>', array('controller' => 'standards', 'action' => 'index'),array('escape' => false));  ?></li>
                <li><?php echo $this->Html->link('<i class="fa fa-share-alt"></i> <span> Batch</span>', array('controller' => 'sections', 'action' => 'index'),array('escape' => false));  ?></li>
            </ul>
        </li>

        <li><?php echo $this->Html->link('<i class="fa fa-book"></i> <span>Subjects</span>', array('controller' => 'subjects', 'action' => 'index'),array('escape' => false));  ?></li>
        <li><?php echo $this->Html->link('<i class="fa fa-edit"></i> <span>Assignment</span>', array('controller' => 'assignment', 'action' => 'index'),array('escape' => false));  ?></li>
        <li id="catalog"><a class="parent"><i class="fa fa-money fa-fw"></i> <span>Fees</span></a>
            <ul>
                <li>
                    <?php echo $this->Html->link('Category', array('controller' => 'fees/category', 'action' => 'index'),array('escape' => false));  ?>
                </li>
                <li>
                    <?php echo $this->Html->link('Collect fees', array('controller' => 'fees/collect', 'action' => 'index'),array('escape' => false));  ?>
                </li>

            </ul>
        </li>
        <li><a class="parent"><i class="fa fa-check-square-o"></i> <span>Attendance</span></a>
            <ul>
                <li><?php echo $this->Html->link('<i class="fa fa-check-square-o"></i> <span>Take Attendance</span>', array('controller' => 'attendance', 'action' => 'index'),array('escape' => false));  ?></li>
                <li><?php echo $this->Html->link('<i class="fa fa-line-chart"></i> <span>Report</span>', array('controller' => 'attendance', 'action' => 'report'),array('escape' => false));  ?></li>
            </ul>
        </li>
        <li><a class="parent"><i class="fa fa-comments"></i> <span>Communication</span></a>
            <ul>
                <li>
                    <?php echo $this->Html->link('<i class="fa fa-list-alt"></i> <span>Message of Day</span>', array('controller' => 'messages', 'action' => 'index'),array('escape' => false));  ?>
                </li>
                <li>
                    <?php echo $this->Html->link('<i class="fa fa-columns"></i> <span>Notice</span>', array('controller' => 'notices', 'action' => 'index'),array('escape' => false));  ?>
                </li>
            </ul>
        </li>
        <li><a class="parent"><i class="fa fa-calendar-o"></i> <span>Schedule</span></a>
            <ul>
                <li>
                    <?php echo $this->Html->link('<i class="glyphicon glyphicon-time"></i> <span>Class Timing</span>', array('controller' => 'timing', 'action' => 'index'),array('escape' => false));  ?>
                </li>
                <li>
                    <?php echo $this->Html->link('<i class="fa fa-calendar"></i> <span>Schedule</span>', array('controller' => 'timetable', 'action' => 'index'),array('escape' => false));  ?>
                </li>
            </ul>
        </li>
        <li><a class="parent"><i class="fa fa-clipboard"></i> <span>Test</span></a>
            <ul>
                <li>
                    <?php echo $this->Html->link('<i class="fa fa-link"></i> <span> Exam Group</span>', array('controller' => 'exams', 'action' => 'index'),array('escape' => false));  ?>
                </li>
                <li>
                    <?php echo $this->Html->link('<i class="glyphicon glyphicon-stats"></i> <span> Grade Level</span>', array('controller' => 'grades', 'action' => 'index'),array('escape' => false));  ?>
                </li>
                <li>
                    <?php echo $this->Html->link('<i class="glyphicon glyphicon-th-list"></i> <span> Result Summary</span>', array('controller' => 'exams', 'action' => 'summary'),array('escape' => false));  ?>
                </li>
            </ul>
        </li>
        <?php } ?>
        */ ?>

        <?php //pr($modules);die; ?>

        <?php foreach($modules as $module) { ?>
            <?php
                $module_name = array_keys($module)[0];
            ?>
            <?php if($module[$module_name]['child']) { ?>
                <li><a class="parent"><?php echo $module[$module_name]['icon']; ?><span><?php echo $module[$module_name]['name']; ?></span></a>
                    <ul>
                        <?php foreach($module[$module_name]['child'] as $children) { ?>
                            <li>
                                <?php echo $this->Html->link($children['icon'] .'<span>'." ".$children['name'].'</span>', array('controller' => $children['controller'], 'action' => $children['action']),array('escape' => false));  ?>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
            <?php } else { ?>
                <li>
                    <?php echo $this->Html->link($module[$module_name]['icon'] .'<span>'." ".$module[$module_name]['name'].'</span>', array('controller' => $module[$module_name]['controller'], 'action' => $module[$module_name]['action']),array('escape' => false));  ?>
                </li>
            <?php } ?>
        <?php } ?>
    </ul>
</nav>