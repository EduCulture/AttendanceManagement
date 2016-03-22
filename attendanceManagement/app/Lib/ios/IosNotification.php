<?php

App::uses('Autoload', 'Lib/ios/ApnsPHP');
//require_once 'ApnsPHP/Autoload.php';

class IosNotification extends Autoload {

    public function __construct() {
        spl_autoload_register('Autoload::ApnsPHP_Autoload');
    }

    public function send($tokens = array(),$data,$alert = 'Med Meanings') {

        $log = new LogUtils();

        $logData = "\r\n" . 'II      ' . date('h:i A') . '      Ios Push Notification  ' . "\r\n";

        if(Configure::read('push_environment')) {
            $push = new ApnsPHP_Push(ApnsPHP_Abstract::ENVIRONMENT_PRODUCTION, APPLIBS . 'ios/med_prod.pem');
        }else{
            $push = new ApnsPHP_Push(ApnsPHP_Abstract::ENVIRONMENT_SANDBOX, APPLIBS . 'ios/med_dev.pem');
        }

        //pr($tokens);die;

        // Set the Provider Certificate passphrase
        $push->setProviderCertificatePassphrase('vrsspl');

        // Set the Root Certificate Autority to verify the Apple remote peer
        //$push->setRootCertificationAuthority('entrust_root_certification_authority.pem');
        //$tokens = array('5e762cb964ac01dca128b4ee0290d811960caf55b5f5563a47b013d1264633d9');
        foreach($tokens as $token) {

            // Connect to the Apple Push Notification Service
            $push->connect();

            // Instantiate a new Message with a single recipient
            $message = new ApnsPHP_Message($token);

            // Set a custom identifier. To get back this identifier use the getCustomIdentifier() method
            // over a ApnsPHP_Message object retrieved with the getErrors() message.
            //$message->setCustomIdentifier("Message-Badge-3");

            // Set badge icon to "3"
            //$message->setBadge(3);

            // Set a simple welcome text
            $message->setText($alert);

            // Play the default sound
            $message->setSound();

            // Set a custom property
            $message->setCustomProperty('data', $data);

            // Set another custom property
            //$message->setCustomProperty('data', array('bing', 'bong'));

            // Set the expiry value to 30 seconds
            $message->setExpiry(30);

            // Add the message to the message queue
            $push->add($message);

            // Send all messages in the message queue
            $push->send();

            // Disconnect from the Apple Push Notification Service
            $push->disconnect();

            // Examine the error message container
            $aErrorQueue = $push->getErrors();

            if (!empty($aErrorQueue)) {
                $logData .= 'II      ' . date('h:i A') .'      Token       :  '.$token.' - '.$aErrorQueue[1]['ERRORS'][0]['statusCode']. "\r\n";
            }else{
                $logData .= 'II      ' . date('h:i A') .'      Token       :  '.$token.' - 0'."\r\n";
            }

            $log->logInfo($logData);
        }
    }
}
