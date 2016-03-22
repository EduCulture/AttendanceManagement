<?php
/**
 * Created by PhpStorm.
 * User: Deep Gandhi
 * Date: 08-09-2015
 * Time: 04:14 PM
 */

App::uses('AppModel', 'Model');

class StudentParentMap extends AppModel {

    public $useTable = 'student_parents_mapping';

    public $belongsTo = array(
        'Parents' => array(
            'className' => 'Parents',
            'foreignKey' => 'parent_id',
        ),
    );

}