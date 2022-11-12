<?php
session_start();
?>
<!DOCTYPE HTML>
<html>
<head>
    <style>
        #list_item#list_item3
        {font-size: 15px;
        font-weight: bold;}
    </style>
<meta charset="UTF-8">
<title>맛Eat다</title>
<link rel="shortcut icon" type="image⁄x-icon" href="../img/M_logo.png">
<link rel="stylesheet" type="text/css" href="../css/common.css">
<link rel="stylesheet" type="text/css" href="../css/mateatda.css">
<link rel="stylesheet" type="text/css" href="../css/listEffect.css">
<link rel="stylesheet" type="text/css" href="../css/sideMenu.css">

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<script src="//code.jquery.com/jquery.min.js"></script>
</head>

<?php

$id = $_SESSION["userid"];
$board_type = "like";
require_once("../lib/MYDB.php");
$pdo = db_connect();

if(isset($_REQUEST["page"])) // $_REQUEST["page"]값이 없을 때에는 1로 지정 
  $page=$_REQUEST["page"];  // 페이지 번호
else
  $page=1;

  $scale = 9;       // 한 페이지에 보여질 게시글 수
  $page_scale = 5;  // 한 페이지당 표시될 페이지 수
  $first_num = ($page-1) * $scale; // 리스트에 표시되는 게시글의 첫 순번.

$sql="SELECT  'restaurant' AS board_type, A.restaurant_num AS num, A.restaurant_id AS id, C.nick AS nick, A.restaurant_subject AS subject, A.restaurant_hit AS hit, A.restaurant_date AS date,
              (SELECT COUNT(*) FROM joobee97.boardLike0201 WHERE boardLike_type = 'restaurant' AND A.restaurant_num = boardLike_num GROUP BY boardLike_num) AS LikeCNT,
              substr(A.restaurant_content, instr(A.restaurant_content,'<img'), 
                    instr(substr(A.restaurant_content, instr(A.restaurant_content,'<img')), '>')) AS thumbnail 
      FROM    joobee97.restaurant0201 A, joobee97.boardLike0201 B, joobee97.member0201 C
      WHERE   B.boardLike_id = C.id and C.id = '$id'
      AND     B.boardLike_type = 'restaurant'
      AND     B.boardLike_num = A.restaurant_num
      UNION ALL
      SELECT  'recipe' AS board_type, A.recipe_num AS num, A.recipe_id AS id, C.nick AS nick, A.recipe_subject AS subject, A.recipe_hit AS hit, A.recipe_date AS date,
              (SELECT COUNT(*) FROM joobee97.boardLike0201 WHERE boardLike_type = 'recipe' AND A.recipe_num = boardLike_num GROUP BY boardLike_num) AS LikeCNT,
              substr(A.recipe_content, instr(A.recipe_content,'<img'), 
                    instr(substr(A.recipe_content, instr(A.recipe_content,'<img')), '>')) AS thumbnail 
      FROM    joobee97.recipe0201 A, joobee97.boardLike0201 B, joobee97.member0201 C
      WHERE   B.boardLike_id = C.id and C.id = '$id'
      AND     B.boardLike_type = 'recipe'
      AND     B.boardLike_num = A.recipe_num
      UNION ALL
      SELECT  'foodShow' AS board_type, A.foodShow_num AS num, A.foodShow_id AS id, C.nick AS nick, A.foodShow_subject AS subject, A.foodShow_hit AS hit, A.foodShow_date AS date,
              (SELECT COUNT(*) FROM joobee97.boardLike0201 WHERE boardLike_type = 'foodShow' AND A.foodShow_num = boardLike_num GROUP BY boardLike_num) AS LikeCNT,
              substr(A.foodShow_content, instr(A.foodShow_content,'<img'), 
                    instr(substr(A.foodShow_content, instr(A.foodShow_content,'<img')), '>')) AS thumbnail 
      FROM    joobee97.foodShow0201 A, joobee97.boardLike0201 B, joobee97.member0201 C
      WHERE   B.boardLike_id = C.id and C.id = '$id'
      AND     B.boardLike_type = 'foodShow'
      AND     B.boardLike_num = A.foodShow_num
      ORDER BY LikeCNT DESC, hit DESC, date DESC
      LIMIT    $first_num, $scale";

try{  
  $stmh = $pdo->query($sql); 
  $count=$stmh->rowCount(); 

  $sql_total = "SELECT  'restaurant' AS board_type, A.restaurant_num AS num, A.restaurant_id AS id, C.nick AS nick, A.restaurant_subject AS subject, A.restaurant_hit AS hit, A.restaurant_date AS date,
                        (SELECT COUNT(*) FROM joobee97.boardLike0201 WHERE boardLike_type = 'restaurant' AND A.restaurant_num = boardLike_num GROUP BY boardLike_num) AS LikeCNT,
                        substr(A.restaurant_content, instr(A.restaurant_content,'<img'), 
                              instr(substr(A.restaurant_content, instr(A.restaurant_content,'<img')), '>')) AS thumbnail 
                FROM    joobee97.restaurant0201 A, joobee97.boardLike0201 B, joobee97.member0201 C
                WHERE   B.boardLike_id = C.id and C.id = '$id'
                AND     B.boardLike_type = 'restaurant'
                AND     B.boardLike_num = A.restaurant_num
                UNION ALL
                SELECT  'recipe' AS board_type, A.recipe_num AS num, A.recipe_id AS id, C.nick AS nick, A.recipe_subject AS subject, A.recipe_hit AS hit, A.recipe_date AS date,
                        (SELECT COUNT(*) FROM joobee97.boardLike0201 WHERE boardLike_type = 'recipe' AND A.recipe_num = boardLike_num GROUP BY boardLike_num) AS LikeCNT,
                        substr(A.recipe_content, instr(A.recipe_content,'<img'), 
                              instr(substr(A.recipe_content, instr(A.recipe_content,'<img')), '>')) AS thumbnail 
                FROM    joobee97.recipe0201 A, joobee97.boardLike0201 B, joobee97.member0201 C
                WHERE   B.boardLike_id = C.id and C.id = '$id'
                AND     B.boardLike_type = 'recipe'
                AND     B.boardLike_num = A.recipe_num
                UNION ALL
                SELECT  'foodShow' AS board_type, A.foodShow_num AS num, A.foodShow_id AS id, C.nick AS nick, A.foodShow_subject AS subject, A.foodShow_hit AS hit, A.foodShow_date AS date,
                        (SELECT COUNT(*) FROM joobee97.boardLike0201 WHERE boardLike_type = 'foodShow' AND A.foodShow_num = boardLike_num GROUP BY boardLike_num) AS LikeCNT,
                        substr(A.foodShow_content, instr(A.foodShow_content,'<img'), 
                              instr(substr(A.foodShow_content, instr(A.foodShow_content,'<img')), '>')) AS thumbnail 
                FROM    joobee97.foodShow0201 A, joobee97.boardLike0201 B, joobee97.member0201 C
                WHERE   B.boardLike_id = C.id and C.id = '$id'
                AND     B.boardLike_type = 'foodShow'
                AND     B.boardLike_num = A.foodShow_num
                ORDER BY LikeCNT DESC, hit DESC, date DESC";

  $stmh_total = $pdo->query($sql_total);
      
  $total_row = $stmh_total->rowCount();     //전체 글수

  $total_page = ceil($total_row/$scale); // 전체 페이지 블록 수
  $current_page = ceil($page/$page_scale); //현재 페이지 블록 위치계산
if($total_row==0){
?>
<script>
      alert('좋아요한 게시물이 없습니다.');
      history.back();
</script>
<?php
}
?>
<body>

<div id="wrap">
  <div id="header">
    <?php include "../lib/top_login2.php"; ?>
  </div>
  <div id="menu">
<?php
$qryStr2 = array($board_type);
$_POST["qryStr2"] = $qryStr2;
?>
    <?php include "../lib/top_menu2.php"; ?>
  </div>
</div>

<div id="wrap">
  <div id="contentKing">

<?php
if ($page==1)  
  $start_num=$total_row;    // 페이지당 표시되는 첫번째 글순번
else 
  $start_num=$total_row-($page-1) * $scale;

$cnt = 4;
$rowcnt = 1;
while($row = $stmh->fetch(PDO::FETCH_ASSOC)) {
  $item_type=$row["board_type"];
  $item_board_type = $row["board_type"]."_num";
  $item_num=$row["num"];
  $item_id=$row["id"];
  $item_nick=$row["nick"];
  $item_subject=str_replace(" ", "&nbsp;", $item_subject=$row["subject"]);
  $item_hit=$row["hit"];
  $item_date=$row["date"];
  $item_date=substr($item_date, 0, 10);
  $item_LikeCNT=$row["LikeCNT"];
  $item_img = $row["thumbnail"];
  $item_img = str_replace(">", "alt='sample45'>", $item_img);

  if($item_type=="foodShow"){
    $sql_url = "SELECT foodShow_url
                FROM   joobee97.foodShow0201
                WHERE  foodShow_num = $item_num";
    $stmh_url = $pdo->query($sql_url);
    $row_url = $stmh_url->fetch(PDO::FETCH_ASSOC);
    $item_url = $row_url["foodShow_url"];
  }
?>
<?php   
$cssStr = "col";
$cssStr .= $cnt;

if($cnt==4){
?>
        <div id="content2">
<?php 
}
?>
          <div id="<?=$cssStr?>">
              <div id="list_content" class="snip1361">
                  <a href="../<?=$item_type?>/view.php?<?=$item_board_type?>=<?=$item_num?>">
<?php 
if($item_type=="foodShow" && $item_url){
  ?>
  <iframe width="100%" height="100%" src="<?=$item_url?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
  <?php
  }else if($item_img){
?>
<?=$item_img?>
<?php
}else{
?>
<img src=../img/M_warning.png alt="sample45">
<?php
}
?>

<?php 

try{
  $sql3 = "SELECT boardLike_type, boardLike_num, COUNT(*) AS CNT
           FROM joobee97.boardLike0201
           WHERE boardLike_type = '$item_type'
           AND boardLike_num = $item_num
           GROUP BY boardLike_num, boardLike_type
           ORDER BY CNT DESC";
  $stmh3 = $pdo->query($sql3);
  $row = $stmh3->fetch(PDO::FETCH_ASSOC);

  $likeCnt     = $row["CNT"];
  if(!$likeCnt){
    $likeCnt = 0;
  }
?>
<?php
} catch (PDOException $Exception) {
  print "오류: ".$Exception->getMessage();
}
?>
              <figcaption>
              <div style="width:10px; float:left; font-size: 20px;">
                <?= $rowcnt ?>
              </div>
              <div align="right" style="width:80%; float:right; font-size:15px; word-spacing:10px;">
                <?=$item_subject?> 
              </div>
              <br>
              <p align="left"><img src="../img/M_like2.png" style="width:10px; height:10px;margin-top:5px;"> <?=$likeCnt?> &nbsp;<br><?=$item_nick ?>&nbsp;<br><?= $item_date ?>&nbsp;</p>
              
              </figcaption>

            </a></div>
          </div>
<?php
$rowcnt++;
$count--;
if($cnt==6||$count==0){
?>
    </div>
<?php
$cnt=4;
}else{
$cnt++;
}
$start_num--;
}
?>
<?php
  // 페이지 구분 블럭의 첫 페이지 수 계산 ($start_page)
     $start_page = ($current_page - 1) * $page_scale + 1;
  // 페이지 구분 블럭의 마지막 페이지 수 계산 ($end_page)
     $end_page = $start_page + $page_scale - 1;
 
?>
    <div id="page_button" style="">
      <div id="page_num">  
<?php
    if($page!=1 && $page>$page_scale)
    {
     $prev_page = $page - $page_scale;    
     // 이전 페이지값은 해당 페이지 수에서 리스트에 표시될 페이지수 만큼 감소
      if($prev_page <= 0) 
          $prev_page = 1;  // 만약 감소한 값이 0보다 작거나 같으면 1로 고정
      print "<a href=write.php?page=$prev_page>◀ </a>";
      }
 
      for($i=$start_page; $i<=$end_page && $i<= $total_page; $i++) 
      {        // [1][2][3] 페이지 번호 목록 출력
        if($page==$i) // 현재 위치한 페이지는 링크 출력을 하지 않도록 설정.
           print "<font color=red><b>[$i]</b></font>"; 
        else 
           print "<a href=write.php?page=$i>[$i]</a>";
      }

      if($page<$total_page)
      {
        $next_page = $page + $page_scale;
        if($next_page > $total_page) 
            $next_page = $total_page;
        // netx_page 값이 전체 페이지수 보다 크면 맨 뒤 페이지로 이동시킴
        print "<a href=write.php?page=$next_page> ▶</a><p>";
      }

    } catch (PDOException $Exception) {
  print "오류: ".$Exception->getMessage();
}  
?> 
      </div>
    </div>
<div id="list_write_button">
          <a href="like.php?page=<?=$page?>"><img src="../img/list.png"></a>&nbsp;
</div>
</div>

  </div>
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script src="../js/jquery.bxslider.min.js"></script>
<link href="../js/jquery.bxslider.css" rel="stylesheet" />  
 <script>
$('.bxslider').bxSlider({
  auto: true, 
  speed: 1000, 
  pause: 4000, 
  mode:'fade', 
  autoControls: true, 
  captions: true,
  pager:true
});
</script>

</body>
</html>