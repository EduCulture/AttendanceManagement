<?php

/**
 * Created by PhpStorm.
 * User: balkrushna.maheta
 * Date: 01-08-2015
 * Time: 12:42
 */
App::uses('AppController', 'Controller');

class CategoriesController extends AppController {

    public $paginate = array(
        'limit' => 10,
        'order' => array(
            'Category.id' => 'ASC'
        )
    );

    /**
     *Description:This is used for the showing the categories list.
     */
    public function index() {
        $this->_getCategory();
        if (isset($_POST['selected']) && !empty($_POST['selected'])) {
            $this->_deleteCategory($_POST['selected']);
        }
    }

    protected function _getCategory() {
        $this->Paginator->settings = $this->paginate;
        $category = $this->Paginator->paginate('Category');
        $this->set('categories',$category);
    }

    protected function _editNews() {

    }

    /**
     * Description:This is used for the deleting category from the database.
     */
    protected function _deleteCategory($c_id) {
        if ($c_id[0] <> 1 && $c_id[0] <> 2) {
            $this->loadModel('Word');
            $category = $this->Category->find('first',array('conditions' => array('id' => $c_id[0])));
            if ($category) {
                $p = $category['Category']['parent_category'];
                if ($category['Category']['has_child'] == 1) {
                    $child = $this->Category->getChildCategories($c_id[0]);
                    if($child) {
                        foreach ($child['ids'] as $c) {
                            $this->Word->deleteAll(array('Word.category_id' => $c));
                        }
                    }
                    $this->Category->deleteAll(array('parent_category' => $c_id[0]));
                }
                $this->Word->deleteAll(array('Word.category_id' => $c_id[0]));
                $this->Category->delete($c_id[0]);
                //make has_child = 0 when it does not have any child
                $has_childs = $this->Category->find('all',array('conditions' => array('parent_category' => $p)));
                if (!$has_childs) {
                    $parent = $this->Category->find('first',array('conditions' => array('id' => $p)));
                    $this->Category->id = $parent['Category']['id'];
                    $this->Category->saveField('has_child',0);
                }
                $this->Session->setFlash('Category Successfully Deleted','flash');
                $this->redirect(array("controller" => "categories", "action" => "index"));
            }
        }
    }

    /**
     *Description:This is used for the adding the category in to the list.
     */
    public function add() {
        $this->_setDataToDropDown();
        if ($this->request->is('post')) {
            $this->_addCategory();
        }
    }

    protected function _addCategory() {
        $created = date("Y-m-d H:i:s");
        $parentCategory = isset($_REQUEST['category']) ? $_REQUEST['category'] : '';
        $subParentCategory = isset($_REQUEST['sub_category']) ? $_REQUEST['sub_category'] : '';
        $childCategory = isset($_REQUEST['child_category']) ? $_REQUEST['child_category'] : '';
        $description = isset($_REQUEST['description']) ? $_REQUEST['description'] : '';
        $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : '';
        $active = isset($_REQUEST['active']) ? $_REQUEST['active'] : 0;
        if(isset($_POST['active']) && $_POST['active'] == 'ON'){
            $active = 1;
        } else {
            $active = 0;
        }
        $category = array('child_category' => $childCategory, 'description' => $description, 'active' => $active);
        $this->set('category',$category);
        $valid = true;
        if(empty($_POST['child_category'])){
            $c_error = 'Category is Required';
            $this->set('c_error',$c_error);
            $valid = false;
        }

        if(empty($_POST['description']) && (strlen($_POST['description']) < 4)){
            $d_error = 'Description Must Be Greater Than 4 Words';
            $this->set('d_error',$d_error);
            $valid = false;
        }

        //adding category data
        if ($childCategory <> '' && $description <> '' && $valid == true) {
            $parentHasChild = $this->Category->find('first',array('conditions' => array('id' => 2)));
            if ($subParentCategory == 1 && $parentHasChild['Category']['has_child'] == 0) {
                $this->Category->id = $parentHasChild['Category']['id'];
                $this->Category->saveField('has_child',1);
                $categoryData = array('category_name' => $childCategory, 'parent_category' => $parentHasChild['Category']['id'], 'has_child' => 0,
                    'user_id' => $this->Auth->user('id'), 'description' => $description, 'category_type' => $type, 'active' => $active,
                    'created_date' => $created);
            } elseif ($subParentCategory == 1) {
                $categoryData = array('category_name' => $childCategory, 'parent_category' => 2, 'has_child' => 0,
                    'user_id' => $this->Auth->user('id'), 'description' => $description, 'category_type' => $type, 'active' => $active,
                    'created_date' => $created);
            } else {
                $subParent = $this->Category->find('first', array('conditions' => array('category_name' => $subParentCategory)));
                $this->Category->id = $subParent['Category']['id'];
                $this->Category->saveField('has_child',1);
                $categoryData = array('category_name' => $childCategory, 'parent_category' => $subParent['Category']['id'], 'has_child' => 0,
                    'user_id' => $this->Auth->user('id'), 'description' => $description, 'category_type' => $type, 'active' => $active,
                    'created_date' => $created);
            }
            $this->Category->create();
            if($this->Category->save($categoryData)) {
                $this->Session->setFlash('Category Successfully Addeed','flash');
                $this->redirect(array("controller" => "categories", "action" => "index"));
            }
        }
    }

    protected function _setDataToDropDown() {
        $has_child = $this->Category->find('all',array('conditions' => array('has_child' => 1, 'id' => 2)));
        if($has_child) {
            $subCategory = $this->Category->getChildCategories(2);
            $sc = array();
            $i=0;
            foreach($subCategory['data'] as $scategory) {
                $sc[$i] = $scategory['Category']['category_name'];
                $i++;
            }
            $this->set('subcategory',$sc);
        }
    }
}