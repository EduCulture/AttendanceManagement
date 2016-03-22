<header id="header" class="navbar navbar-static-top" style="background: url('<?php echo $this->webroot; ?>images/main-bg-dark.png') repeat-x scroll left bottom rgba(0, 0, 0, 0);">
    <div class="navbar-header">
        <?php
            echo $this->Html->image("/images/header_logo.png", array(
                "alt" => "logo",
                'url' => array('controller' => 'users', 'action' => 'login'),
                'height' => '60px',
                'style' => 'padding:5px;'
            ));
        ?>
    </div>
</header>