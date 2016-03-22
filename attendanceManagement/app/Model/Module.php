<?php
/**
 * Created by PhpStorm.
 * User: deep.gandhi
 * Date: 29-07-2015
 * Time: 12:42
 */

App::uses('AppModel', 'Model');

class Module extends AppModel {

    public $hasMany = array(
        'ModuleAction' => array(
            'className' => 'ModuleAction',
            'foreignKey' => 'module_id',
            //'fields' => array('ModuleAction.id','ModuleAction.action_id')
        )
    );
}