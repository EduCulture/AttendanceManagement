<?php
/**
 * Created by PhpStorm.
 * User: hitesh.kubavat
 * Date: 29-07-2015
 * Time: 11:39
 */

Class StudentFeeMap extends AppModel {

    public $useTable = 'student_fee_mapping';

    public $belongsTo = array(
        'Fee' => array(
            'className' => 'Fee',
            'foreignKey' => 'fee_id',
        ),
    );
}