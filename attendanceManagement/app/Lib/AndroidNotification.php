<?php

define( 'API_ACCESS_KEY', 'AIzaSyC8o6jpSOQcwo3vfNCxX-R9UjD-ousWFlA');

class AndroidNotification {

    public function send($tokens = array(), $data) {

        $log = new LogUtils();

        $logData = "\r\n" . 'II      ' . date('h:i A') . '      Android Push Notification  ' . "\r\n";

        if($tokens) {

            //$logData .= 'II      ' . date('h:i A') . '      Token   : ' . implode('::',$registrationIds) . "\r\n";

            $fields = array(
                'registration_ids' => $tokens,
                'data' => $data
            );

            $headers = array(
                'Authorization: key=' . API_ACCESS_KEY,
                'Content-Type: application/json'
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://android.googleapis.com/gcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            $result = curl_exec($ch);

            if ($result === FALSE) {
                $logData .= 'II      ' . date('h:i A') . '      Resp   : ' . curl_error($ch) . "\r\n";
            }else{
                $logData .= 'II      ' . date('h:i A') . '      Resp   : ' . $result . "\r\n";
            }

            curl_close($ch);

            $log->logInfo($logData);

            return $result;

        }else{
            $logData .= 'II      ' . date('h:i A') . '      Error  : Tokens not available' . "\r\n";
            $log->logInfo($logData);
            return false;
        }
    }
}