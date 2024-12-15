CREATE DATABASE  IF NOT EXISTS `blogdb`;
use blogdb;

CREATE TABLE users(
    id INT NOT NULL AUTO_INCREMENT primary key,
    user_name varchar(255) not null,
    first_name varchar(255),
    last_name varchar(255),
    email varchar(255) not null,
    user_password varchar(255) not null,
    unique(user_name),
    unique(email)
);


CREATE TABLE blogs(
 	id INT NOT NULL AUTO_INCREMENT primary key,
	title varchar(255) not null,
	excerpt varchar(255),
    publication_date datetime DEFAULT CURRENT_TIMESTAMP,
    update_date datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    slug varchar(255) not null,
	content text,
	user_id int,
	CONSTRAINT fk_blogs FOREIGN KEY (user_id) REFERENCES users(id)
                  ON DELETE CASCADE ,
    unique(slug),
    unique(title)
);



CREATE TABLE Tags(
	id INT NOT NULL AUTO_INCREMENT primary key,
    caption varchar(255)
);

CREATE TABLE blog_tags(
    blog_id int not null,
    tag_id int not null,
    CONSTRAINT FK_blog_tags_blog_id FOREIGN KEY (blog_id) REFERENCES blogs(id)
        ON DELETE CASCADE ,
    CONSTRAINT FK_blog_tags_tag_id FOREIGN KEY (tag_id) REFERENCES Tags(id)
        ON DELETE CASCADE
);

CREATE TABLE likes(
	id INT NOT NULL AUTO_INCREMENT primary key,
    user_id int not null,
    blog_id int not null,
    liked_at datetime DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT FK_likes_user_id FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE ,
    CONSTRAINT FK_likes_blog_id FOREIGN KEY (blog_id) REFERENCES blogs(id)
        ON DELETE CASCADE ,
	CONSTRAINT UNQ_likes UNIQUE (user_id, blog_id)
);


CREATE TABLE Comments(
	id INT NOT NULL AUTO_INCREMENT primary key,
    user_id int not null,
    blog_id int not null,
    Content text not null,
    commented_at datetime DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT FK_Comments_user_id FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE ,
    CONSTRAINT FK_Comments_blog_id FOREIGN KEY (blog_id) REFERENCES blogs(id)
        ON DELETE CASCADE
);
