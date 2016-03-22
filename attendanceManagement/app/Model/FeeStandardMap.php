<?php
/**
 * Created by PhpStorm.
 * User: hitesh.kubavat
 * Date: 29-07-2015
 * Time: 11:39
 */

Class FeeStandardMap extends AppModel {

    public $useTable = 'fee_standard_mapping';

    public $belongsTo = array(
        'Standard' => array(
            'className' => 'Standard',
            'foreignKey' => 'standard_id',
            'fields' => array('name')
        ),
        'Fee' => array(
            'className' => 'Fee',
            'foreignKey' => 'fee_id',
        ),
    );

    public function getFeeDetails($fee_id,$standard_id) {

        $fee_details = $this->find('all',array(
            'conditions' => array('FeeStandardMap.fee_id' => $fee_id,'FeeStandardMap.standard_id' => $standard_id)
        ));

        //pr($fee_details);die;
        $return = [];
        $total = 0;
        if($fee_details) {
            foreach ($fee_details as $fee_detail) {
                $total += $fee_detail['FeeStandardMap']['amount'];
                $return[] = array(
                    'name' => $fee_detail['Fee']['name'],
                    'due_date' => date("d-M-y", strtotime($fee_detail['Fee']['due_date'])),
                    'amount' => number_format($fee_detail['FeeStandardMap']['amount'],2),
                    'original' => $fee_detail['FeeStandardMap']['amount']
                );
            }
        }

        return array('fee_data' => $return,'total_fee' => $total);

    }
}