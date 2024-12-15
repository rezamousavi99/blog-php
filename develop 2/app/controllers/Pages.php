<?php
  class Pages extends Controller {
    public function __construct(){
      $this->postModel = $this->model('Post');

    }
    
    public function index(){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){

      }else{
        $data = [
          'blogs' => $this->postModel->fetch_limited_posts(4),
        ];
      
        $this->view('pages/index', $data);
      }
    }



    public function about(){
      $data = [
        'title' => 'About Us',
          'description' => 'App to share posts with other users.',
      ];

      $this->view('pages/about', $data);
    }
  }