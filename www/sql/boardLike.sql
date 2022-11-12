create table boardLike0201 (
 boardLike_num int not null, /* 좋아요 누른 게시물 일련번호 */
 boardLike_id varchar(15) not null, /* 좋아요 누른 사람 일련번호 */
 boardLike_type varchar(20), /* 좋아요 누른 게시물 타입 (mukbang, restaurant, recipe) */
 boardLike_date varchar(20), /* 좋아요 누른 일시 */
 primary key(boardLike_num, boardLike_id, boardLike_type)
 );
