<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
 //pr($layout);die;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="description" content="Medical Dictionary">
        <meta name="author" content="">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <meta content='text/html;charset=utf-8' http-equiv='content-type'>
        <meta http-equiv="Content-Type" content="application/xhtml+xml">
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <?php echo $this->Html->scriptBlock('var jsVars = '.$this->Js->object($jsVars).';'); ?>
        <?php echo $this->Html->charset(); ?>

        <title>Edu Culture</title>
        <?php
            echo $this->Html->meta('icon');
            echo $this->fetch('meta');
            echo $this->fetch('css');
            echo $this->Html->css('bootstrap/css/bootstrap.css');
            echo $this->Html->css('stylesheet.css');
            echo $this->Html->css('font-awesome/css/font-awesome.css');
            if (!$layout['loggedIn']){
                $header = $this->element('login_header');
            }else{
                //pr(CakeSession::read());die;
                $header = $this->element('header',array(
                    'username' => CakeSession::read("Auth.User.username"),
                    'email_id' => CakeSession::read("Auth.User.email")
                ));
            }

            $footer = $this->element('footer');

            echo $this->Html->script('jquery-2.1.1.min.js');
            echo $this->Html->script('bootstrap/bootstrap.js');
            echo $this->Html->script('common.js');
        ?>
    </head>
    <body>
        <div id="container">

            <?php echo $header; ?>

            <?php
               if ($layout['loggedIn']) {
                  echo $this->element('nav_menu',array('modules' => $modules));
               }
            ?>

            <div id="content">
                <?php echo $this->Session->flash(); ?>
                <?php if($valid) { ?>
                    <?php echo $this->fetch('content'); ?>
                <?php } else { ?>
                    <?php echo $this->element('access_denied'); ?>
                <?php } ?>

                <?php echo $footer; ?>
            </div>
        </div>
    </body>
</html>
