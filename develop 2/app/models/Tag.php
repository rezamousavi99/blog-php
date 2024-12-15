<?php

class Tag {
    private $db;
    public function __construct() {
        $this->db = new Database();
    }

    public function get_tags() {
        return $this->db->select("SELECT * FROM tags");
    }
    public function get_post_tags($slug){
        $tags = $this->db->select("select tags.caption, blogs.id from tags
                                 inner join blog_tags on blog_tags.tag_id = tags.id
                                 inner join blogs on blogs.id = blog_tags.blog_id
                                 where blogs.slug='$slug'");
        return $tags;
    }

    public function add_tags($tag, $postid){
        $this->db->insert("blog_tags", array("blog_id" => $postid, "tag_id" => $tag));

    }

    public function delete_blog_tags($blog_id){
        $this->db->delete_allrows("blog_tags", "blog_id='$blog_id'");
    }

    public function api_tag_user_nums(){
        $tags = $this->db->select("select tags.caption as caption, count(blog_tags.blog_id) as post_nums from tags
                                    inner join blog_tags on tags.id = blog_tags.tag_id
                                    group by tags.caption");
        return $tags;
    }
}