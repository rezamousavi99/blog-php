<?php
class Api extends Controller{

    public function __construct(){
        $this->userModel = $this->model('User');
        $this->tagModel = $this->model('Tag');
    }

    public function users_liked_post($blogid){

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

        }else{
            // Set the response content type
            header('Content-Type: JSON');
            // Process the request

            $blog_id = $blogid;
            $users = $this->userModel->api_get_users($blog_id);
            echo json_encode($users, JSON_PRETTY_PRINT);
        }
    }


    public function tags_post_count(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

        }else{
            // Set the response content type
            header('Content-Type: JSON');
            // Process the request

            $tags = $this->tagModel->api_tag_user_nums();
            echo json_encode($tags, JSON_PRETTY_PRINT);
        }

    }
}

