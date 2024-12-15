<?php

    class Post {
        private $db;
        public function __construct() {
            $this->db = new Database();
        }

        public function fetch_limited_posts($limit){
            $posts = $this->db->select("select blogs.id, blogs.title, blogs.excerpt, users.user_name 
            from blogs 
            inner join users on blogs.user_id = users.id
            order by blogs.id DESC limit $limit");
            return $posts;
        }

        public function fetch_all_posts($search=""){
            $posts = $this->db->select("select blogs.id, blogs.title, users.user_name, blogs.slug, blogs.excerpt 
            from blogs 
            inner join users on blogs.user_id = users.id " . $search);
            return $posts;
        }

        public function fetch_last_post_id(){
            return $this->db->select("SELECT blogs.id FROM blogs ORDER BY id DESC LIMIT 1")[0];
        }

        public function fetch_post($slug){
            $post = $this->db->select("SELECT blogs.id, blogs.title, users.email, users.user_name, blogs.excerpt,
                                                blogs.update_date, blogs.user_id, blogs.content, blogs.slug
                                            FROM blogs inner join users on users.id = blogs.user_id where slug='$slug'");
            return $post;
        }

        public function fetch_updated_post_id($updated_slug){
            return $this->db->select("SELECT id FROM blogs where slug='$updated_slug'");
        }

        public function add_post($blogname, $excerpt, $slug, $content, $userid){
            $this->db->insert("blogs", array("title" => $blogname, "excerpt"=> $excerpt,
                "slug" => $slug, "content" => $content, "user_id" => $userid));
        }

        public function update_post($blogname, $excerpt, $updated_slug, $content, $userid, $slug){
            $this->db->update("blogs", array("title" => $blogname, "excerpt"=> $excerpt,
                "slug" => $updated_slug, "content" => $content, "user_id" => $userid), "slug='$slug'");
        }

        public function delete_post($slug){
            $this->db->delete("blogs", "slug = '$slug'");
        }



    }