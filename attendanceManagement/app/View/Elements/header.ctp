<header class="navbar navbar-static-top" id="header">
    <div class="navbar-header">
        <div>
            <a class="pull-left" id="button-menu" type="button"><i class="fa fa-indent fa-lg"></i></a>
            <?php
                /*
                echo $this->Html->image("/images/header_logo.png", array(
                    "alt" => "logo",
                    'url' => array('controller' => 'dashboard'),
                    'height' => '45px',
                    'style' => 'padding:5px;'
                ));
                */
            ?>
        </div>
    </div>

    <ul class="nav pull-right">
        <li><a href="#" onclick="return false;"><span class="hidden-xs hidden-sm hidden-md" data-toggle="tooltip" data-placement="bottom" title="<?php echo $email_id; ?>"><i class="fa fa-user fa-lg"></i> <?php echo $username; ?> </span> </a></li>
        <li>
            <?php echo $this->Html->link('Logout <i class="fa fa-sign-out fa-lg"></i>', array('controller' => 'users', 'action' => 'logout'),array('escape' => false));  ?>
        </li>
    </ul>
</header>