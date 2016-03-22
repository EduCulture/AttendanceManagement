<?php
/**
 * Created by PhpStorm.
 * User: hitesh.kubavat
 * Date: 29-07-2015
 * Time: 11:39
 */

Class Dashboard extends AppModel {


    public function getDeviceDetails($range,$date_start = '') {

        $Device = ClassRegistry::init ('Device');

        if($range == 'week') {

            $andr_device_data = array();
            $iphn_device_data = array();
            $win_device_data = array();

            for ($i = 0; $i < 7; $i++) {
                $date = date('Y-m-d', $date_start + ($i * 86400));

                $andr_device_data[date('w', strtotime($date))] = array(
                    'day' => date('D', strtotime($date)),
                    'total' => 0
                );

                $iphn_device_data[date('w', strtotime($date))] = array(
                    'day' => date('D', strtotime($date)),
                    'total' => 0
                );

                $win_device_data[date('w', strtotime($date))] = array(
                    'day' => date('D', strtotime($date)),
                    'total' => 0
                );
            }

            $andrquery = $Device->query("SELECT SUM(if(platform = 'ANDR',1,0)) AS andr_total,created_date FROM `devices` WHERE DATE(`created_date`) >= DATE('" . date('Y-m-d', $date_start) . "') GROUP BY DAYNAME(`created_date`)");
            while ($result = $andrquery->fetch_assoc()) {
                //print_r($result)."<br/>";
                $andr_device_data[date('w', strtotime($result['devices']['created_date']))] = array(
                    'day' => date('D', strtotime($result['devices']['created_date'])),
                    'total' => $result[0]['andr_total']
                );
            }

            $iosquery = $Device->query("SELECT SUM(if(platform = 'IPHN',1,0)) AS iphn_total,created_date FROM `devices` WHERE DATE(`created_date`) >= DATE('" . date('Y-m-d', $date_start) . "') GROUP BY DAYNAME(`created_date`)");
            while ($result = $iosquery->fetch_assoc()) {
                //print_r($result)."<br/>";
                $iphn_device_data[date('w', strtotime($result['devices']['created_date']))] = array(
                    'day' => date('D', strtotime($result['devices']['created_date'])),
                    'total' => $result[0]['iphn_total']
                );
            }

            $winquery = $Device->query("SELECT SUM(if(platform = 'WPHN',1,0)) AS win_total,created_date FROM `devices` WHERE DATE(`created_date`) >= DATE('" . date('Y-m-d', $date_start) . "') GROUP BY DAYNAME(`created_date`)");
            while ($result = $winquery->fetch_assoc()) {
                //print_r($result)."<br/>";
                $win_device_data[date('w', strtotime($result['devices']['created_date']))] = array(
                    'day' => date('D', strtotime($result['devices']['created_date'])),
                    'total' => $result[0]['win_total']
                );
            }

            $device_data = array(
                'andr' => $andr_device_data,
                'iphn' => $iphn_device_data,
                'win' => $win_device_data
            );

        }else if($range == 'month') {

            $andr_device_data = array();
            $iphn_device_data = array();
            $win_device_data = array();

            for ($i = 1; $i <= date('t'); $i++) {
                $date = date('Y') . '-' . date('m') . '-' . $i;

                $andr_device_data[date('j', strtotime($date))] = array(
                    'day' => date('d', strtotime($date)),
                    'total' => 0
                );

                $iphn_device_data[date('j', strtotime($date))] = array(
                    'day' => date('d', strtotime($date)),
                    'total' => 0
                );

                $win_device_data[date('j', strtotime($date))] = array(
                    'day' => date('d', strtotime($date)),
                    'total' => 0
                );
            }

            $andrquery = $Device->query("SELECT SUM(if(platform = 'ANDR',1,0)) AS andr_total,created_date FROM `devices` WHERE DATE(`created_date`) >= DATE('" . date('Y') . '-' . date('m') . '-1' . "') GROUP BY DATE(`created_date`)");
            if ($andrquery) {
                foreach ($andrquery as $result) {
                    //print_r($result)."<br/>";
                    $andr_device_data[date('j', strtotime($result['devices']['created_date']))] = array(
                        'day' => date('d', strtotime($result['devices']['created_date'])),
                        'total' => $result[0]['andr_total']
                    );
                }
            }

            $iosquery = $Device->query("SELECT SUM(if(platform = 'IPHN',1,0)) AS iphn_total,created_date  FROM `devices` WHERE DATE(`created_date`) >= DATE('" . date('Y') . '-' . date('m') . '-1' . "') GROUP BY DATE(`created_date`)");
            if ($iosquery) {
                foreach ($iosquery as $result) {
                    //print_r($result)."<br/>";
                    $iphn_device_data[date('j', strtotime($result['devices']['created_date']))] = array(
                        'day' => date('d', strtotime($result['devices']['created_date'])),
                        'total' => $result[0]['iphn_total']
                    );
                }
            }

            $winquery = $Device->query("SELECT SUM(if(platform = 'WPHN',1,0)) AS win_total,created_date  FROM `devices` WHERE DATE(`created_date`) >= DATE('" . date('Y') . '-' . date('m') . '-1' . "') GROUP BY DATE(`created_date`)");
            if($winquery) {
                foreach ($winquery as $result) {
                    //print_r($result)."<br/>";
                    $win_device_data[date('j', strtotime($result['devices']['created_date']))] = array(
                        'day' => date('d', strtotime($result['devices']['created_date'])),
                        'total' => $result[0]['win_total']
                    );
                }
            }

            $device_data = array(
                'andr' => $andr_device_data,
                'iphn' => $iphn_device_data,
                'win'  => $win_device_data,
            );


        }else if($range == 'year') {

            $andr_device_data = array();
            $iphn_device_data = array();
            $win_device_data = array();

            for ($i = 1; $i <= 12; $i++) {
                $andr_device_data[$i] = array(
                    'month' => date('M', mktime(0, 0, 0, $i)),
                    'total' => 0
                );

                $iphn_device_data[$i] = array(
                    'month' => date('M', mktime(0, 0, 0, $i)),
                    'total' => 0
                );

                $win_device_data[$i] = array(
                    'month' => date('M', mktime(0, 0, 0, $i)),
                    'total' => 0
                );
            }

            $andrquery = $Device->query("SELECT SUM(if(platform = 'ANDR',1,0)) AS andr_total,created_date FROM `devices` WHERE YEAR(`created_date`) = YEAR(NOW()) GROUP BY MONTH(created_date)");
            if($andrquery) {
                foreach ($andrquery as $result) {
                    //print_r($result)."<br/>";
                    $andr_device_data[date('n', strtotime($result['devices']['created_date']))] = array(
                        'day' => date('M', strtotime($result['devices']['created_date'])),
                        'total' => $result[0]['andr_total']
                    );
                }
            }

            $iosquery = $Device->query("SELECT SUM(if(platform = 'IPHN',1,0)) AS iphn_total,created_date FROM `devices` WHERE YEAR(`created_date`) = YEAR(NOW()) GROUP BY MONTH(created_date)");
            if($iosquery) {
                foreach ($iosquery as $result) {
                    //print_r($result)."<br/>";
                    $iphn_device_data[date('n', strtotime($result['devices']['created_date']))] = array(
                        'day' => date('M', strtotime($result['devices']['created_date'])),
                        'total' => $result[0]['iphn_total']
                    );
                }
            }

            $winquery = $Device->query("SELECT SUM(if(platform = 'WPHN',1,0)) AS win_total,created_date FROM `devices` WHERE YEAR(`created_date`) = YEAR(NOW()) GROUP BY MONTH(created_date)");
            if($winquery) {
                foreach ($winquery as $result) {
                    //print_r($result)."<br/>";
                    $win_device_data[date('n', strtotime($result['devices']['created_date']))] = array(
                        'day' => date('M', strtotime($result['devices']['created_date'])),
                        'total' => $result[0]['win_total']
                    );
                }
            }

            $device_data = array(
                'andr' => $andr_device_data,
                'iphn' => $iphn_device_data,
                'win'  => $win_device_data
            );
        }

        return $device_data;
    }


    public function getUserDetails($range,$date_start = '') {

        $User = ClassRegistry::init ('User');

        if($range == 'week') {

            $user_data = array();
            $fb_user = array();
            $ggl_user = array();

            for ($i = 0; $i < 7; $i++) {
                $date = date('Y-m-d', $date_start + ($i * 86400));

                $user_data[date('w', strtotime($date))] = array(
                    'day' => date('D', strtotime($date)),
                    'total' => 0
                );

                $fb_user[date('w', strtotime($date))] = array(
                    'day' => date('D', strtotime($date)),
                    'total' => 0
                );

                $ggl_user[date('w', strtotime($date))] = array(
                    'day' => date('D', strtotime($date)),
                    'total' => 0
                );
            }

            $userquery = $User->query("SELECT COUNT(*) AS total,created_date FROM `users` WHERE `signin_from` = 'meddic' AND DATE(`created_date`) >= DATE('" .  date('Y-m-d', $date_start) . "') GROUP BY DAYNAME(`created_date`)");

            if($userquery) {
                foreach($userquery as $result) {
                    //print_r($result)."<br/>";
                    $user_data[date('w', strtotime($result['users']['created_date']))] = array(
                        'day' => date('D', strtotime($result['users']['created_date'])),
                        'total' => $result[0]['total']
                    );
                }
            }

            $fbquery = $User->query("SELECT COUNT(*) AS total,created_date FROM `users` WHERE `signin_from` = 'facebook' AND DATE(`created_date`) >= DATE('" . date('Y-m-d', $date_start) . "') GROUP BY DAYNAME(`created_date`)");
            if($fbquery) {
                foreach ($fbquery as $result) {
                    //print_r($result)."<br/>";
                    $fb_user[date('w', strtotime($result['users']['created_date']))] = array(
                        'day' => date('D', strtotime($result['users']['created_date'])),
                        'total' => $result[0]['total']
                    );
                }
            }

            $gglquery = $User->query("SELECT COUNT(*) AS total,created_date FROM `users` WHERE `signin_from` = 'google' AND DATE(`created_date`) >= DATE('" . date('Y-m-d', $date_start) . "') GROUP BY DAYNAME(`created_date`)");
            if($gglquery) {
                foreach ($gglquery as $result) {
                    //print_r($result)."<br/>";
                    $ggl_user[date('w', strtotime($result['users']['created_date']))] = array(
                        'day' => date('D', strtotime($result['users']['created_date'])),
                        'total' => $result[0]['total']
                    );
                }
            }

            $user_all_data = array(
                'user' => $user_data,
                'fb_user' => $fb_user,
                'ggl_user' => $ggl_user
            );

        }else if($range == 'month') {

            $user_data = array();
            $fb_user = array();
            $ggl_user = array();

            for ($i = 1; $i <= date('t'); $i++) {
                $date = date('Y') . '-' . date('m') . '-' . $i;

                $user_data[date('j', strtotime($date))] = array(
                    'day'   => date('d', strtotime($date)),
                    'total' => 0
                );

                $fb_user[date('j', strtotime($date))] = array(
                    'day'   => date('d', strtotime($date)),
                    'total' => 0
                );

                $ggl_user[date('j', strtotime($date))] = array(
                    'day'   => date('d', strtotime($date)),
                    'total' => 0
                );
            }

            $userquery = $User->query("SELECT COUNT(*) AS total,created_date FROM `users` WHERE `signin_from` = 'meddic' AND DATE(`created_date`) >= DATE('" . date('Y') . '-' . date('m') . '-1' . "') GROUP BY DATE(`created_date`)");

            if($userquery) {
                foreach ($userquery as $result) {
                    //print_r($result)."<br/>";
                    $user_data[date('j', strtotime($result['users']['created_date']))] = array(
                        'day' => date('d', strtotime($result['users']['created_date'])),
                        'total' => $result[0]['total']
                    );
                }
            }

            $fbquery = $User->query("SELECT COUNT(*) AS total,created_date FROM `users` WHERE `signin_from` = 'facebook' AND DATE(`created_date`) >= DATE('" . date('Y') . '-' . date('m') . '-1' . "') GROUP BY DATE(`created_date`)");
            if($fbquery) {
                foreach ($fbquery as $result) {
                    //print_r($result)."<br/>";
                    $fb_user[date('j', strtotime($result['users']['created_date']))] = array(
                        'day' => date('d', strtotime($result['users']['created_date'])),
                        'total' => $result[0]['total']
                    );
                }
            }

            $gglquery = $User->query("SELECT COUNT(*) AS total,created_date FROM `users` WHERE `signin_from` = 'google' AND DATE(`created_date`) >= DATE('" . date('Y') . '-' . date('m') . '-1' . "') GROUP BY DATE(`created_date`)");
            if($gglquery) {
                foreach ($gglquery as $result) {
                    //print_r($result)."<br/>";
                    $ggl_user[date('j', strtotime($result['users']['created_date']))] = array(
                        'day' => date('d', strtotime($result['users']['created_date'])),
                        'total' => $result[0]['total']
                    );
                }
            }

            $user_all_data = array(
                'user' => $user_data,
                'fb_user' => $fb_user,
                'ggl_user' => $ggl_user
            );

        }else if($range == 'year') {

            $user_data = array();
            $fb_user = array();
            $ggl_user = array();

            for ($i = 1; $i <= 12; $i++) {
                $user_data[$i] = array(
                    'month' => date('M', mktime(0, 0, 0, $i)),
                    'total' => 0
                );

                $fb_user[$i] = array(
                    'month' => date('M', mktime(0, 0, 0, $i)),
                    'total' => 0
                );

                $ggl_user[$i] = array(
                    'month' => date('M', mktime(0, 0, 0, $i)),
                    'total' => 0
                );
            }

            $userquery = $User->query("SELECT COUNT(*) AS total,created_date FROM `users` WHERE `signin_from` = 'meddic' AND YEAR(`created_date`) = YEAR(NOW()) GROUP BY MONTH(created_date)");
            if($userquery) {
                foreach ($userquery as $result) {
                    //print_r($result)."<br/>";
                    $user_data[date('n', strtotime($result['users']['created_date']))] = array(
                        'day' => date('M', strtotime($result['users']['created_date'])),
                        'total' => $result[0]['total']
                    );
                }
            }

            $fbquery = $User->query("SELECT COUNT(*) AS total,created_date FROM `users` WHERE `signin_from` = 'facebook' AND YEAR(`created_date`) = YEAR(NOW()) GROUP BY MONTH(created_date)");
            if($fbquery) {
                foreach ($fbquery as $result) {
                    //print_r($result)."<br/>";
                    $fb_user[date('n', strtotime($result['users']['created_date']))] = array(
                        'day' => date('M', strtotime($result['users']['created_date'])),
                        'total' => $result[0]['total']
                    );
                }
            }

            $gglquery = $User->query("SELECT COUNT(*) AS total,created_date FROM `users` WHERE `signin_from` = 'google' AND YEAR(`created_date`) = YEAR(NOW()) GROUP BY MONTH(created_date)");
            if($gglquery) {
                foreach ($gglquery as $result) {
                    //print_r($result)."<br/>";
                    $ggl_user[date('n', strtotime($result['users']['created_date']))] = array(
                        'day' => date('M', strtotime($result['users']['created_date'])),
                        'total' => $result[0]['total']
                    );
                }
            }

            $user_all_data = array(
                'user' => $user_data,
                'fb_user' => $fb_user,
                'ggl_user' => $ggl_user
            );
        }

        return $user_all_data;
    }
}