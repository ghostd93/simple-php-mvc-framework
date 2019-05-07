<?php 

class PagesController extends Controller{

    public function __construct(){
        $this->testModel = $this->model('Test');
    }

    public function index(){
        $this->view('pages/index', ['title' => 'Welcome']);
    }

    public function about(){
        $this->view('pages/about', ['title' => 'About']);
    }


}