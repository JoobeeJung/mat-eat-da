create table foodShow0201 (
 foodShow_num int not null auto_increment primary key,
 foodShow_id varchar(15) not null,
 foodShow_subject varchar(100) not null,
 foodShow_content text not null,
 foodShow_date varchar(20),
 foodShow_hit int,
 foodShow_hashTag varchar(50),
 foodShow_url text
);
