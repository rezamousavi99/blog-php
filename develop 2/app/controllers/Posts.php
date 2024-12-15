<?php

class Posts extends Controller{

    public function __construct(){
        $this->postModel = $this->model('Post');
        $this->tagModel = $this->model('Tag');
        $this->likeModel = $this->model('Like');

      }

    public function all_posts(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){


        }else{
            $data = [
                'blogs' => $this->postModel->fetch_all_posts(),
            ];

            if(isset($_GET["search_input"])){
                $search_input = $_GET["search_input"];
                $search_query = " where concat(blogs.title, blogs.content, users.user_name) like '%$search_input%'";
                $data = [
                    'blogs' => $this->postModel->fetch_all_posts($search_query),
                ];
            }
        
            $this->view('posts/all_posts', $data);
            }
        }
    
    public function post($slug){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){


            if (isset($_SESSION["loggedin_user_data"]) and isset($_POST['blog_id_onlike'])){
                $logged_user_id = $_SESSION["loggedin_user_data"]["id"];


                $is_exist = $this->likeModel->check_like_exist($logged_user_id, $_POST['blog_id_onlike']);

                if ($is_exist) {
                    $this->likeModel->unlike($logged_user_id, $_POST['blog_id_onlike']);


                } else {
                    $this->likeModel->like($logged_user_id, $_POST['blog_id_onlike']);

                }

                $post = $this->postModel->fetch_post($slug);
                $data = [
                    'post' => $post,
                    'tags' => $this->tagModel->get_post_tags($slug),
                    'likes' => $this->likeModel->get_post_likes($post[0]["id"]),
                ];

                $this->view('posts/detail_post', $data);

            }else{
                header('Location: ' . URLROOT . "/users/login");

            }

        }else{
            $post = $this->postModel->fetch_post($slug);
            $data = [
                'post' => $post,
                'tags' => $this->tagModel->get_post_tags($slug),
                'likes' => $this->likeModel->get_post_likes($post[0]["id"]),
            ];


            $this->view('posts/detail_post', $data);


        }
    }

    public function add_post(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $slug = convertTitleToURL($_POST["blogname"]);

           //Insert post Data into Database
            $this->postModel->add_post($_POST['blogname'], $_POST['blogexcerpt'], $slug, $_POST['description'], $_POST['userid']);

            $last_blog_id = $this->postModel->fetch_last_post_id()["id"];

//            var_dump($last_blog_id);
//            die();


            //Insert tags into blog tags table
            foreach ($_POST['tags'] as $tag) {
                $this->tagModel->add_tags($tag, $last_blog_id);

            }


        header("Location: ".URLROOT);



        }else{
            $this->view('posts/add_post');
        }

    }

    public function edit_post(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){



            //update slug from new blog title name
            $updated_slug = convertTitleToURL($_POST["blogname"]);

            //assign the slug of the blog that we want to update

            $slug = $_SESSION["edit_blog"]["slug"];

            //update with new values that we get from update form
            $this->postModel->update_post($_POST["blogname"], $_POST['blogexcerpt'], $updated_slug, $_POST['description'],$_POST['userid'], $slug);


            $updated_blog_id = $this->postModel->fetch_updated_post_id($updated_slug)[0]["id"];


            // delete all rows from blog_tags where blog id
            $this->tagModel->delete_blog_tags($updated_blog_id);

            // insert all tags where we get from user
            foreach ($_POST['tags'] as $tag) {
                $this->tagModel->add_tags($tag, $updated_blog_id);
//                $db->insert("blog_tags", array("blog_id" => $updated_blog_id, "tag_id" => $tag));
            }

            header("Location: ".URLROOT."/posts/all_posts");




        }else{

            $blog = $_SESSION["edit_blog"];


            if($_SESSION["loggedin_user_data"]["user_name"] != $blog["user_name"]){
                die("<h2>you are not allowed to view this page...</h2>");
            }

            $user_id = $_SESSION["loggedin_user_data"]["id"];

            $tags = $this->tagModel->get_tags();

            $data = [
                'blog' => $blog,
                'tags' => $tags,
                'user_id' => $user_id
            ];
            $this->view('posts/update_post', $data);
        }

    }

    public function delete_post(){

        //assign the slug of the blog that we want to delete
        $slug = $_SESSION["edit_blog"]["slug"];
        $blog_id = $_SESSION["edit_blog"]["id"];

        //first delete all tags from blog_tags table
        $this->tagModel->delete_blog_tags($blog_id);

        $this->postModel->delete_post($slug);

        header("Location: ".URLROOT."/posts/all_posts");


    }
}

function convertTitleToURL($str) {

    // Convert string to lowercase
    $str = strtolower($str);

    // Convert String into URL Code
    $str = urlencode($str);

    // Replace URL encode with hyphon
    $str = str_replace('+', '-', $str);

    return $str;
}