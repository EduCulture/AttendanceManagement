<?php
/**
 * User: deep.gandhi
 * Date: 29-07-2015
 * Time: 12:05
 */

App::uses('AppModel', 'Model');

class Word extends AppModel {

    public $hasOne = array(
        'Translation' => array(
            'className' => 'Translation',
            'foreignKey' => 'word_id',
            //'conditions' => array('language_id')
        )
    );

    public $belongsTo = array(
        'Category' => array(
            'className' => 'Category',
            'foreignKey' => 'category_id',
            //'fields' => array('Category.id','Category.category_name')
        )
    );


    public function addWord($data) {

        $log = new LogUtils();

        $logData = "\r\n" . 'II      ' . date('h:i A') .   '      Insert Word  ' . "\r\n";
        $logData .= 'II      ' . date('h:i A') .   '      Word    : ' . $data['word_name'] . "\r\n";

        $log->logInfo($logData);

        $this->query("SET CHARACTER SET utf8;");

        $this->save(array(
            'word_name' => $data['word_name'],
            'category_id' => $data['category_id'],
            'image_url' => $data['image_url'],
            'is_paid' => $data['type'],
            'active' => $data['active'],
            'video_url' => $data['video_url'],
            'description' => isset($data['description']) ? trim($data['description']) : NULL,
            'created_date' => date("Y-m-d H:i:s")
        ));

        $word_id = $this->id;

        $this->Translation->query("SET CHARACTER SET utf8;");

        $this->Translation->save(array(
            'word_id' => $word_id,
            'language_id' => $data['language_id'],
            'transliteration' => $data['transliteration'],
            'meaning' => $data['meaning'],
            'description' => isset($data['summary']) ? trim($data['summary']) : NULL
        ));

        //send push notification
        if($data['active']){

            $category = $this->Category->getCategory($data['category_id']);

            if($category['Category']['parent_category']){
                $parent_details = $this->Category->getCategory($category['Category']['parent_category']);
                if($parent_details){
                    $parent_category = $parent_details['Category']['category_name'];
                }
            }else{
                $parent_category = $category['Category']['category_name'];
            }

            $push_data = array(
                "action" => "new_word",
                "data" => array(
                    "id" => $word_id,
                    "name" => $data['word_name'],
                    "description" => isset($data['description']) ? trim($data['description']) : NULL,
                    "category" => $category['Category']['category_name'],
                    "parent_category" => $parent_category,
                    "pronunciation" => $data['transliteration'],
                    "meaning" => $data['meaning'],
                    "image" => $data['image_url'],
                    "video_url" => $data['video_url'],
                    "current_time" => strtotime(date("Y-m-d H:i:s")),
                    "is_paid" => $data['type']
                )
            );
            $this->sendPush($push_data,'Dictionary updated with new words, meaning and translation. (Added)');
        }

        return $word_id;
    }

    public function updateWord($data,$word_id) {

        $log = new LogUtils();

        $logData = "\r\n" . 'II      ' . date('h:i A') .   '      Update Word  ' . "\r\n";
        $logData .= 'II      ' . date('h:i A') .   '      Word    : ' . $data['word_name'] . "\r\n";

        $log->logInfo($logData);

        $this->query("SET CHARACTER SET utf8;");

        if(isset($data['description'])){
            $description = $data['description'];
        }else{
            $description = NULL;
        }

        if(isset($data['summary'])){
            $summary = $data['summary'];
        }else{
            $summary = NULL;
        }

        $this->updateAll(
            array('category_id' => "'{$data['category_id']}'", 'image_url' => "'{$data['image_url']}'", 'is_paid' => "'{$data['type']}'",'is_paid' => "'{$data['type']}'",'active' => "'{$data['active']}'",'video_url' => "'{$data['video_url']}'", 'description' => "'{$description}'"),
            array('Word.id' => $word_id)
        );

        $this->Translation->query("SET CHARACTER SET utf8;");

        $this->Translation->updateAll(
            array(
                'word_id' => "'{$word_id}'",
                'language_id' => "'{$data['language_id']}'",
                'transliteration' => "'{$data['transliteration']}'",
                'meaning' => "'{$data['meaning']}'",
                'description' => "'{$summary}'"
            ),
            array('Translation.word_id' => $word_id)
        );


        if($data['active']){

            $category = $this->Category->getCategory($data['category_id']);

            if($category['Category']['parent_category']){
                $parent_details = $this->Category->getCategory($category['Category']['parent_category']);
                if($parent_details){
                    $parent_category = $parent_details['Category']['category_name'];
                }
            }else{
                $parent_category = $category['Category']['category_name'];
            }

            $push_data = array(
                "action" => "new_word",
                "data" => array(
                    "id" => $word_id,
                    "name" => $data['word_name'],
                    "description" => isset($data['description']) ? trim($data['description']) : NULL,
                    "category" => $category['Category']['category_name'],
                    "parent_category" => $parent_category,
                    "pronunciation" => $data['transliteration'],
                    "meaning" => $data['meaning'],
                    "image" => $data['image_url'],
                    "video_url" => $data['video_url'],
                    "current_time" => strtotime(date("Y-m-d H:i:s")),
                    "is_paid" => $data['type']
                )
            );
            $this->sendPush($push_data,'Dictionary updated with modified data. (Edited)');
        }

        return $word_id;
    }
}