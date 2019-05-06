<?php 
/**
 * Core Class
 * Creates URL & loads core controller
 */

 class Core {
     
    protected $currentController = 'PageController';
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