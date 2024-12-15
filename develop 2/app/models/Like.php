<?php

class Like {
    private $db;
    public function __construct() {
        $this->db = new Database();
    }

    public function get_post_likes($post_id){
        return $this->db->select("SELECT * FROM likes where blog_id= $post_id");
    }

    public function check_like_exist($user_id, $post_id){
        return $this->db->select("SELECT * FROM likes WHERE user_id=$user_id AND blog_id=$post_id");
    }

    public function like($user_id, $post_id){
        return $this->db->insert("likes", array("user_id" => $user_id, "blog_id" => $post_id));

    }

    public function unlike($user_id, $post_id){
        return $this->db->delete("likes", "user_id=$user_id AND blog_id=$post_id");
    }

}