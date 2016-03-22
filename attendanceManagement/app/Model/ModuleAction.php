<?php
/**
 * Created by PhpStorm.
 * User: deep.gandhi
 * Date: 29-07-2015
 * Time: 12:43
 */


App::uses('AppModel', 'Model');

class ModuleAction extends AppModel {

    public $useTable = 'module_actions';

    public $hasMany = array(
        'RolePermission' => array(
            'className'  => 'RolePermission',
            'foreignKey' => 'module_action_id',
            'fields' => array('RolePermission.role_id')
        )
    );

    public $belongsTo = array(
        'Action' => array(
            'className' => 'Action',
            'foreignKey' => 'action_id',
            'fields' => array('Action.action_name')
        ),
    );
}