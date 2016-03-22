<?php
/**
 * Created by PhpStorm.
 * User: hitesh.kubavat
 * Date: 29-07-2015
 * Time: 11:39
 */

Class Map extends AppModel {

    public $useTable = 'user_device_mapping';

    public $belongsTo = array(
        'Device' => array(
            'className' => 'Device',
            'foreignKey' => 'device_id',
            'conditions' => array('Device.isonline' => 1)
        ),
        'DeviceConfig' => array(
            'className' => 'DeviceConfig',
            'foreignKey' => 'device_id',
        )
    );
}