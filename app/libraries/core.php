<?php 
/**
 * Core Class
 * Creates URL & loads core controller
 */

class Core {
    
    protected $currentController = 'PagesController';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct(){
        //print_r($this->getUrl());
        $url = $this->getUrl();
        
        // set current controller based on URL
        if(file_exists('../app/mvc/controller/' . ucwords($url[0]) . 'Controller.php')){
            $this->currentController = ucwords($url[0]) . 'Controller';
            unset($url[0]);
        }

        // load controller
        require_once '../app/mvc/controller/' . $this->currentController . '.php';

        // instationate controller class
        $this->currentController = new $this->currentController;

        // method mapping
        if(isset($url[1])){
            if(method_exists($this->currentController, $url[1])){
                $this->currentMethod = $url[1];
                unset($url[1]);
            }
        }

        // getting parameters from URL
        $this->params = $url ? array_values($url) : [];

        // call mapped method with params
        call_user_func_array([$this->currentController, $this->currentMethod], 
            $this->params);
    }

    public function getUrl(){
        // explode url string to array
        if(isset($_GET['url'])){
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }
}