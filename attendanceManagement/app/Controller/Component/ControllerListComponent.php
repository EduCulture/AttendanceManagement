<?php
/**
 * Created by PhpStorm.
 * User: Deep Gandhi
 * Date: 27-10-2015
 * Time: 12:37 PM
 */

class ControllerListComponent extends Object {
    public function get() {
        $controllerClasses = App::objects('controller');
        //pr($controllerClasses);die;
        foreach($controllerClasses as $controller) {
            if (($controller != 'AppController') && ($controller != 'ImageController')) {
                App::import('Controller', str_replace('Controller', '', $controller));
                $className = $controller;
                //echo $className;die;

                $actions = get_class_methods($className);
                foreach($actions as $k => $v) {
                    if ($v{0} == '_') {
                        unset($actions[$k]);
                    }
                }
                $parentActions = get_class_methods('AppController');
                $controllers[str_replace('Controller', '', $controller)] = array_diff($actions, $parentActions);
            }
        }
        //pr($controllers);die;
        return $controllers;
    }
}