<?php
/**
 * User: deep.gandhi
 * Date: 30-07-2015
 * Time: 14:36
 */

App::uses('AppController', 'Controller');

class ImageController extends AppController {

    public function fileManager() {

        if (isset($this->request->query['filter_name'])) {
            $filter_name = rtrim(str_replace(array('../', '..\\', '..', '*'), '', $this->request->query['filter_name']), '/');
        } else {
            $filter_name = null;
        }

        if (isset($this->request->query['directory'])) {
            $directory = rtrim(WWW_ROOT . 'uploads/image/catalog/' . str_replace(array('../', '..\\', '..'), '', $this->request->query['directory']), '/');
        } else {
            $directory = WWW_ROOT . 'uploads/image/catalog';
        }

        if (isset($this->request->query['page'])) {
            $page = $this->request->query['page'];
        } else {
            $page = 1;
        }
        //echo $directory;die;
        $directories = glob($directory . '/' . $filter_name . '*', GLOB_ONLYDIR);

        if (!$directories) {
            $directories = array();
        }

        // Get files
        $files = glob($directory . '/' . $filter_name . '*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}', GLOB_BRACE);
        //pr($files);die;
        if (!$files) {
            $files = array();
        }

        // Merge directories and files
        $images = array_merge($directories, $files);

        //pr($images);die;

        // Get total number of files and directories
        $image_total = count($images);

        // Split the array based on current page number and max number of items per page of 10
        $images = array_splice($images, ($page - 1) * 16, 16);
        //echo Router::url('/');die;
        $url = array();

        if (isset($this->request->query['target'])) {
            $data['target'] = $this->request->query['target'];
            $target = $url['target'] = $this->request->query['target'];
        }else{
            $target = $data['target'] = '';
        }

        if (isset($this->request->query['thumb'])) {
            $url['thumb'] = $this->request->query['thumb'];
            $thumb = $data['thumb'] = $this->request->query['thumb'];
        }else{
            $thumb = $data['thumb'] = '';
        }

        foreach ($images as $image) {
            $name = str_split(basename($image), 14);

            if (is_dir($image)) {

                //echo substr($image, strlen(WWW_ROOT . 'uploads/'));die;

                $data['images'][] = array(
                    'thumb' => '',
                    'name'  => implode(' ', $name),
                    'type'  => 'directory',
                    'path'  => substr($image, strlen(WWW_ROOT)),
                    'href'  => Router::url(array('controller' => 'image','action' => 'fileManager','?' => array('directory' => urlencode(substr($image, strlen(WWW_ROOT . 'uploads/image/catalog/'))),'target' => $target,'thumb' => $thumb))),
                    //'href'  => $this->url->link('common/filemanager', 'token=' . $this->session->data['token'] . '&directory=' . urlencode(utf8_substr($image, utf8_strlen(DIR_IMAGE . 'catalog/'))) . $url, 'SSL')
                );
                //pr($data);die;
            } elseif (is_file($image)) {

                //echo $image;die;

                $this->loadModel('Image');
                $image_thumb_url = $this->Image->getImageUrl(implode(' ', $name),'image/catalog');

                $data['images'][] = array(
                    'thumb' => $image_thumb_url,
                    'name'  => implode(' ', $name),
                    'type'  => 'image',
                    'path'  => substr($image, strlen(WWW_ROOT)),
                    'href'  => $image_thumb_url,
                    //'href'  => $server . 'image/' . utf8_substr($image, utf8_strlen(DIR_IMAGE))
                );
            }
        }

        //pr($data);die;

        if (isset($this->request->query['directory'])) {
            $data['directory'] = urlencode($this->request->query['directory']);
            $url['directory'] = $data['directory'] = urlencode($this->request->query['directory']);
        } else {
            $data['directory'] = '';
        }

        if (isset($this->request->query['filter_name'])) {
            $data['filter_name'] = $this->request->query['filter_name'];
        } else {
            $data['filter_name'] = '';
        }

        //refresh url
        $data['refresh'] = Router::url(array('controller' => 'image','action' => 'fileManager' ,'?' => $url));

        if(isset($url['directory'])){
            unset($url['directory']);
        }

        if (isset($this->request->query['directory'])) {
            $pos = strrpos($this->request->query['directory'], '/');
            if ($pos) {
                $url['directory'] = urlencode(substr($this->request->get['directory'], 0, $pos));
            }
        }

        //parent url
        $data['parent'] = Router::url(array('controller' => 'image','action' => 'fileManager' ,'?' => $url));

        $this->set('data',$data);

        $this->layout = 'ajax';
    }

    public function upload() {

        $json = array();

        //pr($_FILES['file']);die;
        // Make sure we have the correct directory
        if (isset($this->request->query['directory'])) {
            $directory = rtrim(WWW_ROOT . 'uploads/image/catalog/' . str_replace(array('../', '..\\', '..'), '', $this->request->query['directory']), '/');
        } else {
            $directory = WWW_ROOT . 'uploads/image/catalog';
        }

        // Check its a directory
        if (!is_dir($directory)) {
            $json['error'] = 'Invalid Directory';
        }

        if (!$json) {
            if (!empty($_FILES['file']['name']) && is_file($_FILES['file']['tmp_name'])) {
                // Sanitize the filename
                $filename = basename(html_entity_decode($_FILES['file']['name'], ENT_QUOTES, 'UTF-8'));

                // Validate the filename length
                if ((strlen($filename) < 2) || (strlen($filename) > 255)) {
                    $json['error'] = 'filename must be between 2 to 255 character';
                }

                // Allowed file extension types
                $allowed = array(
                    'jpg',
                    'jpeg',
                    'gif',
                    'png'
                );

                if (!in_array(strtolower(substr(strrchr($filename, '.'), 1)), $allowed)) {
                    $json['error'] = 'Only '.implode(',',$allowed) . 'are allowed';
                }

                // Allowed file mime types
                $allowed = array(
                    'image/jpeg',
                    'image/pjpeg',
                    'image/png',
                    'image/x-png',
                    'image/gif'
                );

                if (!in_array($_FILES['file']['type'], $allowed)) {
                    $json['error'] = 'Only '.implode(',',$allowed) . 'are allowed';
                }

                // Check to see if any PHP files are trying to be uploaded
                $content = file_get_contents($_FILES['file']['tmp_name']);

                if (preg_match('/\<\?php/i', $content)) {
                    $json['error'] = $this->language->get('error_filetype');
                }

                // Return any upload error
                if ($_FILES['file']['error'] != UPLOAD_ERR_OK) {
                    $json['error'] = 'Error' . $_FILES['file']['error'];
                }
            } else {
                $json['error'] = 'File not found';
            }
        }

        if (!$json) {
            move_uploaded_file($_FILES['file']['tmp_name'], $directory . '/' . $filename);
            $json['success'] = 'Successfully uploaded';
        }

        echo json_encode($json);
        $this->autoRender = false;
        //$this->response->setOutput(json_encode($json));
    }

    public function folder() {

        $json = array();

        // Make sure we have the correct directory
        if (isset($this->request->query['directory'])) {
            $directory = rtrim(WWW_ROOT . 'uploads/image/catalog/' . str_replace(array('../', '..\\', '..'), '', $this->request->query['directory']), '/');
        } else {
            $directory = WWW_ROOT . 'uploads/image/catalog';
        }

        // Check its a directory
        if (!is_dir($directory)) {
            $json['error'] = 'Invalid Directory';
        }

        if (!$json) {
            // Sanitize the folder name
            $folder = str_replace(array('../', '..\\', '..'), '', basename(html_entity_decode($this->request->data['folder'], ENT_QUOTES, 'UTF-8')));

            // Validate the filename length
            if ((strlen($folder) < 2) || (strlen($folder) > 128)) {
                $json['error'] = 'Directory name must be between 2 to 128 character';
            }

            // Check if directory already exists or not
            if (is_dir($directory . '/' . $folder)) {
                $json['error'] = 'Directory with this name already exists';
            }
        }

        if (!$json) {
            mkdir($directory . '/' . $folder, 0777);

            $json['success'] = 'Directory created';
        }

        echo json_encode($json);
        $this->autoRender = false;
    }

    public function delete() {

        $json = array();

        if (isset($this->request->data['path'])) {
            $paths = $this->request->data['path'];
        } else {
            $paths = array();
        }

        // Loop through each path to run validations
        foreach ($paths as $path) {
            $path = rtrim(WWW_ROOT . str_replace(array('../', '..\\', '..'), '', $path), '/');

            // Check path exsists
            if ($path == WWW_ROOT . 'uploads/image/catalog') {
                $json['error'] = 'Can not delete parent directory';
                break;
            }
        }

        if (!$json) {
            // Loop through each path
            foreach ($paths as $path) {
                $path = rtrim(WWW_ROOT . str_replace(array('../', '..\\', '..'), '', $path), '/');

                // If path is just a file delete it
                if (is_file($path)) {
                    unlink($path);

                    // If path is a directory beging deleting each file and sub folder
                } elseif (is_dir($path)) {
                    $files = array();

                    // Make path into an array
                    $path = array($path . '*');

                    // While the path array is still populated keep looping through
                    while (count($path) != 0) {
                        $next = array_shift($path);

                        foreach (glob($next) as $file) {
                            // If directory add to path array
                            if (is_dir($file)) {
                                $path[] = $file . '/*';
                            }

                            // Add the file to the files to be deleted array
                            $files[] = $file;
                        }
                    }

                    // Reverse sort the file array
                    rsort($files);

                    foreach ($files as $file) {
                        // If file just delete
                        if (is_file($file)) {
                            unlink($file);

                            // If directory use the remove directory function
                        } elseif (is_dir($file)) {
                            rmdir($file);
                        }
                    }
                }
            }

            $json['success'] = 'Successfully deleted';
        }

        echo json_encode($json);
        $this->autoRender = false;
    }
}