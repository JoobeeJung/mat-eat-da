create table restaurant0201 (
 restaurant_num int not null auto_increment primary key,
 restaurant_id varchar(15) not null,
 restaurant_subject varchar(100) not null,
 restaurant_content text not null,
 restaurant_date varchar(20),
 restaurant_hit int,
 restaurant_address varchar(50),
 restaurant_hashTag varchar(50),
 restaurant_storeName varchar(30)
);