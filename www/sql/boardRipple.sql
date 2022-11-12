 create table boardRipple0201 (
 boardRipple_num int not null auto_increment primary key,
 boardRipple_parent int not null,
 boardRipple_id varchar(15) not null,
 boardRipple_type varchar(20) not null,
 boardRipple_content text not null,
 boardRipple_date char(20)
 );
