<?php
/**
 * Created by PhpStorm.
 * User: deep.gandhi
 * Date: 29-07-2015
 * Time: 17:51
 */


App::uses('AppModel', 'Model');

class Quiz extends AppModel {

    public $useTable = 'word_quizes';

    public $belongsTo = array(
        'Word' => array(
            'className' => 'Word',
            'foreignKey' => 'word_id',
        )
    );

}