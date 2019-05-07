<?php 
/**
 * Base Controller Class
 */

class Controller {

    // include model file and instatiate model class
    public function model($model){

        require_once '../app/mvc/model' . $model . '.php';
        return new $model();

    }

    // include view file with data
    public function view($view, array $data = null){

        if(file_exists('../app/mvc/view/' . $view . '.php')){
            require_once '../app/mvc/view/' . $view . '.php';
        } else {
            die('View does not exist');
        }

    }
}