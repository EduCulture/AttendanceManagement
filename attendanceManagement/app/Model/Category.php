<?php
/**
 * Created by PhpStorm.
 * User: deep.gandhi
 * Date: 29-07-2015
 * Time: 12:14
 */

App::uses('AppModel', 'Model');

class Category extends AppModel {

    public $useTable = 'categories';

    public function getChildCategories($parent_category_id){

        $category = $this->find('first',array(
            'conditions' => array('Category.id' => $parent_category_id)
        ));

        if($category['Category']['has_child']){
            $child_categories = $this->find('all',array(
                'conditions' => array('Category.parent_category' => $parent_category_id)
            ));

            if($child_categories) {
                foreach ($child_categories as $children) {
                    $ids[] = $children['Category']['id'];
                    $data[] = $children;
                }

                $return = array(
                   'ids' => $ids,
                   'data' => $data
                );

                return $return;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }


    public function getCategory($category_id) {

        $data = $this->find('first',array(
           'conditions' => array('Category.id' => $category_id)
        ));

        if($data){
            return $data;
        }else{
            return false;
        }
    }
}