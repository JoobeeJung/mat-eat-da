create table recipe0201 (
 recipe_num int not null auto_increment primary key,
 recipe_id varchar(15) not null,
 recipe_subject varchar(100) not null,
 recipe_content text not null,
 recipe_date varchar(20),
 recipe_hit int,
 recipe_hashTag varchar(50)
);