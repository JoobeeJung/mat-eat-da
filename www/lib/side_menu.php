<?php
require_once("../lib/MYDB.php");
$pdo = db_connect();

$qryStr = $_POST["qryStr"]; //[0] num [1] type [2] id
$num = $qryStr[0];
$board_type = $qryStr[1];
$board_type_content = $board_type."_content";
$board_type_id = $board_type."_id";
$board_type_num = $board_type."_num";
$board_type_hit = $board_type."_hit";
$board_type_date = $board_type."_date";
$board_type_subject = $board_type."_subject";
$id = $qryStr[2];

$sql_like="SELECT   'foodShow' AS board_type, A.foodShow_num AS num, A.foodShow_id AS id, B.nick AS nick, A.foodShow_subject AS subject, A.foodShow_hit AS hit, A.foodShow_date AS date,
                    (SELECT COUNT(*) FROM joobee97.boardLike0201 WHERE boardLike_type = 'foodShow' AND A.foodShow_num = boardLike_num GROUP BY boardLike_num) AS LikeCNT,
                    substr(A.foodShow_content, instr(A.foodShow_content,'<img'), 
                          instr(substr(A.foodShow_content, instr(A.foodShow_content,'<img')), '>')) AS thumbnail 
          FROM     joobee97.foodShow0201 A, joobee97.member0201 B
          WHERE    A.foodShow_id = B.id
          UNION ALL
          SELECT   'restaurant' AS board_type, A.restaurant_num AS num, A.restaurant_id AS id, B.nick AS nick, A.restaurant_subject AS subject, A.restaurant_hit AS hit, A.restaurant_date AS date,
                   (SELECT COUNT(*) FROM joobee97.boardLike0201 WHERE boardLike_type = 'restaurant' AND A.restaurant_num = boardLike_num GROUP BY boardLike_num) AS LikeCNT,
                   substr(A.restaurant_content, instr(A.restaurant_content,'<img'), 
                         instr(substr(A.restaurant_content, instr(A.restaurant_content,'<img')), '>')) AS thumbnail 
          FROM     joobee97.restaurant0201 A, joobee97.member0201 B
          WHERE    A.restaurant_id = B.id
          UNION ALL
          SELECT   'recipe' AS board_type, A.recipe_num AS num, A.recipe_id AS id, B.nick AS nick, A.recipe_subject AS subject, A.recipe_hit AS hit, A.recipe_date AS date,
                   (SELECT COUNT(*) FROM joobee97.boardLike0201 WHERE boardLike_type = 'recipe' AND A.recipe_num = boardLike_num GROUP BY boardLike_num) AS LikeCNT,
                   substr(A.recipe_content, instr(A.recipe_content,'<img'), 
                         instr(substr(A.recipe_content, instr(A.recipe_content,'<img')), '>')) AS thumbnail 
          FROM     joobee97.recipe0201 A, joobee97.member0201 B
          WHERE    A.recipe_id = B.id
          ORDER BY LikeCNT DESC, hit DESC, date DESC";

$sql_hit="SELECT   'foodShow' AS board_type, A.foodShow_num AS num, A.foodShow_id AS id, B.nick AS nick, A.foodShow_subject AS subject, A.foodShow_hit AS hit, A.foodShow_date AS date,
                    (SELECT COUNT(*) FROM joobee97.boardLike0201 WHERE boardLike_type = 'foodShow' AND A.foodShow_num = boardLike_num GROUP BY boardLike_num) AS LikeCNT,
                    substr(A.foodShow_content, instr(A.foodShow_content,'<img'), 
                          instr(substr(A.foodShow_content, instr(A.foodShow_content,'<img')), '>')) AS thumbnail 
          FROM     joobee97.foodShow0201 A, joobee97.member0201 B
          WHERE    A.foodShow_id = B.id
          UNION ALL
          SELECT   'restaurant' AS board_type, A.restaurant_num AS num, A.restaurant_id AS id, B.nick AS nick, A.restaurant_subject AS subject, A.restaurant_hit AS hit, A.restaurant_date AS date,
                   (SELECT COUNT(*) FROM joobee97.boardLike0201 WHERE boardLike_type = 'restaurant' AND A.restaurant_num = boardLike_num GROUP BY boardLike_num) AS LikeCNT,
                   substr(A.restaurant_content, instr(A.restaurant_content,'<img'), 
                         instr(substr(A.restaurant_content, instr(A.restaurant_content,'<img')), '>')) AS thumbnail 
          FROM     joobee97.restaurant0201 A, joobee97.member0201 B
          WHERE    A.restaurant_id = B.id
          UNION ALL
          SELECT   'recipe' AS board_type, A.recipe_num AS num, A.recipe_id AS id, B.nick AS nick, A.recipe_subject AS subject, A.recipe_hit AS hit, A.recipe_date AS date,
                   (SELECT COUNT(*) FROM joobee97.boardLike0201 WHERE boardLike_type = 'recipe' AND A.recipe_num = boardLike_num GROUP BY boardLike_num) AS LikeCNT,
                   substr(A.recipe_content, instr(A.recipe_content,'<img'), 
                         instr(substr(A.recipe_content, instr(A.recipe_content,'<img')), '>')) AS thumbnail 
          FROM     joobee97.recipe0201 A, joobee97.member0201 B
          WHERE    A.recipe_id = B.id
          ORDER BY hit DESC, LikeCNT DESC, date DESC";

$sql_date="SELECT   'foodShow' AS board_type, A.foodShow_num AS num, A.foodShow_id AS id, B.nick AS nick, A.foodShow_subject AS subject, A.foodShow_hit AS hit, A.foodShow_date AS date,
                    (SELECT COUNT(*) FROM joobee97.boardLike0201 WHERE boardLike_type = 'foodShow' AND A.foodShow_num = boardLike_num GROUP BY boardLike_num) AS LikeCNT,
                    substr(A.foodShow_content, instr(A.foodShow_content,'<img'), 
                          instr(substr(A.foodShow_content, instr(A.foodShow_content,'<img')), '>')) AS thumbnail 
          FROM     joobee97.foodShow0201 A, joobee97.member0201 B
          WHERE    A.foodShow_id = B.id
          UNION ALL
          SELECT   'restaurant' AS board_type, A.restaurant_num AS num, A.restaurant_id AS id, B.nick AS nick, A.restaurant_subject AS subject, A.restaurant_hit AS hit, A.restaurant_date AS date,
                   (SELECT COUNT(*) FROM joobee97.boardLike0201 WHERE boardLike_type = 'restaurant' AND A.restaurant_num = boardLike_num GROUP BY boardLike_num) AS LikeCNT,
                   substr(A.restaurant_content, instr(A.restaurant_content,'<img'), 
                         instr(substr(A.restaurant_content, instr(A.restaurant_content,'<img')), '>')) AS thumbnail 
          FROM     joobee97.restaurant0201 A, joobee97.member0201 B
          WHERE    A.restaurant_id = B.id
          UNION ALL
          SELECT   'recipe' AS board_type, A.recipe_num AS num, A.recipe_id AS id, B.nick AS nick, A.recipe_subject AS subject, A.recipe_hit AS hit, A.recipe_date AS date,
                   (SELECT COUNT(*) FROM joobee97.boardLike0201 WHERE boardLike_type = 'recipe' AND A.recipe_num = boardLike_num GROUP BY boardLike_num) AS LikeCNT,
                   substr(A.recipe_content, instr(A.recipe_content,'<img'), 
                         instr(substr(A.recipe_content, instr(A.recipe_content,'<img')), '>')) AS thumbnail 
          FROM     joobee97.recipe0201 A, joobee97.member0201 B
          WHERE    A.recipe_id = B.id
          ORDER BY date DESC, LikeCNT DESC, hit DESC";
try{
  $stmh_like = $pdo->query($sql_like);
  $stmh_hit = $pdo->query($sql_hit);
  $stmh_date = $pdo->query($sql_date);
?>


<div id="container">
    <ul class="tabs">
        <li class="active" rel="tab1"><img src="../img/hitSort.png"></li>
        <li rel="tab2"><img src="../img/likeSort.png"></li>
        <li rel="tab3"><img src="../img/curSort.png"></li>
    </ul>
    <div class="tab_container">
        <div id="tab1" class="tab_content">
<ul>
<?php
$rowcnt=1;
while($row = $stmh_hit->fetch(PDO::FETCH_ASSOC)) {
  $item_type=$row["board_type"];
  $item_num=$row["num"];
  $item_id=$row["id"];
  $item_nick=$row["nick"];
  $item_subject=str_replace(" ", "&nbsp;", $item_subject=$row["subject"]);
  $item_hit=$row["hit"];
  $item_date=$row["date"];
  $item_date=substr($item_date, 0, 10);
  $item_LikeCNT=$row["LikeCNT"];
  $item_img = $row["thumbnail"];

  $item_type_num=$item_type."_num";

  if($item_type=="foodShow"){
    $sql_url = "SELECT foodShow_url
                FROM   joobee97.foodShow0201
                WHERE  foodShow_num = $item_num";
    $stmh_url = $pdo->query($sql_url);
    $row_url = $stmh_url->fetch(PDO::FETCH_ASSOC);
    $item_url = $row_url["foodShow_url"];
  }
?>
	<li>
<a href="../<?=$item_type?>/view.php?<?=$item_type_num?>=<?=$item_num?>">
<?php
if($item_type=="foodShow" && $item_url){
?>
<iframe width="314" height="150" src="<?=$item_url?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
<?php
}else if($item_img){
?>
<?=$item_img?>
<?php
}else{
?>
<img src=../img/M_warning.png>
<?php
}
?>
</a>

<?php 
  $likeCnt     = $row["CNT"];
  if(!$item_LikeCNT){
    $item_LikeCNT = 0;
  }
?>
              <div style="width:30px; float:left; margin-left:10px;font-size: 30px;">
              <?= $rowcnt++ ?>
              </div>
              &nbsp;&nbsp;<img src="../img/M_like2.png" style="width:10px; height:10px;margin-top:5px;"> <?=$item_LikeCNT?>
              <div align="right" style="width:70%; float:right; margin-right:10px; font-size:12px; color:black; word-spacing:10px;">
              &nbsp;<?=$item_subject?> <br>&nbsp;<?=$item_nick ?>&nbsp;<br>&nbsp;<?= $item_date ?>&nbsp;<br>
              </div>
              <br>
       
	</li>
<?php
  } 
?>
</ul>

        </div>
        <div id="tab2" class="tab_content">
        <ul>
<?php
$rowcnt=1;
while($row = $stmh_like->fetch(PDO::FETCH_ASSOC)) {
  $item_type=$row["board_type"];
  $item_num=$row["num"];
  $item_id=$row["id"];
  $item_nick=$row["nick"];
  $item_subject=str_replace(" ", "&nbsp;", $item_subject=$row["subject"]);
  $item_hit=$row["hit"];
  $item_date=$row["date"];
  $item_date=substr($item_date, 0, 10);
  $item_LikeCNT=$row["LikeCNT"];
  $item_img = $row["thumbnail"];

  $item_type_num=$item_type."_num";

  if($item_type=="foodShow"){
    $sql_url = "SELECT foodShow_url
                FROM   joobee97.foodShow0201
                WHERE  foodShow_num = $item_num";
    $stmh_url = $pdo->query($sql_url);
    $row_url = $stmh_url->fetch(PDO::FETCH_ASSOC);
    $item_url = $row_url["foodShow_url"];
  }
?>
	<li>
<a href="view.php?<?=$item_type_num?>=<?=$item_num?>">
<?php 
if($item_type=="foodShow" && $item_url){
  ?>
  <iframe width="314" height="150" src="<?=$item_url?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
  <?php
  }else if($item_img){
?>
<?=$item_img?>
<?php
}else{
?>
<img src=../img/M_warning.png>
<?php
}
?>
</a>

<?php
  $likeCnt     = $row["CNT"];
  if(!$item_LikeCNT){
    $item_LikeCNT = 0;
  }
?>
              <div style="width:30px; float:left; margin-left:10px;font-size: 30px;">
                <?= $rowcnt++ ?>
              </div>
              &nbsp;&nbsp;<img src="../img/M_like2.png" style="width:10px; height:10px;margin-top:5px;"> <?=$item_LikeCNT?>
              
              <div align="right" style="width:70%; float:right; margin-right:10px; font-size:12px; color:black; word-spacing:10px;">
                <?=$item_subject?>  &nbsp;<br>&nbsp;<?=$item_nick ?>&nbsp;<br>&nbsp;<?= $item_date ?>&nbsp;<br>
              </div>
              <br>
       
	</li>
<?php
  } 
?>
</ul>          
        </div>
        <div id="tab3" class="tab_content">
        <ul>
<?php
$rowcnt=1;
while($row = $stmh_date->fetch(PDO::FETCH_ASSOC)) {
  $item_type=$row["board_type"];
  $item_num=$row["num"];
  $item_id=$row["id"];
  $item_nick=$row["nick"];
  $item_subject=str_replace(" ", "&nbsp;", $item_subject=$row["subject"]);
  $item_hit=$row["hit"];
  $item_date=$row["date"];
  $item_date=substr($item_date, 0, 10);
  $item_LikeCNT=$row["LikeCNT"];
  $item_img = $row["thumbnail"];

  $item_type_num=$item_type."_num";

  if($item_type=="foodShow"){
    $sql_url = "SELECT foodShow_url
                FROM   joobee97.foodShow0201
                WHERE  foodShow_num = $item_num";
    $stmh_url = $pdo->query($sql_url);
    $row_url = $stmh_url->fetch(PDO::FETCH_ASSOC);
    $item_url = $row_url["foodShow_url"];
  }
?>
	<li>
<a href="view.php?<?=$item_type_num?>=<?=$item_num?>">
<?php 
if($item_type=="foodShow" && $item_url){
  ?>
  <iframe width="314" height="150" src="<?=$item_url?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
  <?php
  }else if($item_img){
?>
<?=$item_img?>
<?php
}else{
?>
<img src=../img/M_warning.png>
<?php
}
?>
</a>

<?php 


  $likeCnt     = $row["CNT"];
  if(!$item_LikeCNT){
    $item_LikeCNT = 0;
  }
?>
              
              <div style="width:30px; float:left; margin-left:10px;font-size: 30px;">
                <?= $rowcnt++ ?>
              </div>
              &nbsp;&nbsp;<img src="../img/M_like2.png" style="width:10px; height:10px;margin-top:5px;"> <?=$item_LikeCNT?>
              
              <div align="right" style="width:70%; float:right; margin-right:10px; font-size:12px; color:black; word-spacing:10px;">
                <?=$item_subject?> &nbsp;<br>&nbsp;<?=$item_nick ?>&nbsp;<br>&nbsp;<?= $item_date ?>&nbsp;<br>
              </div>
              <br>
       
	</li>
<?php
  } 
?>
</ul>          
        </div>
    </div>
</div>

<?php
}catch (PDOException $Exception) {
  print "오류: ".$Exception->getMessage();
}  
?> 

<script>

$(function () {

$(".tab_content").hide();
$(".tab_content:first").show();

$("ul.tabs li").click(function () {
    $("ul.tabs li").removeClass("active").css("color", "#333");
    $(this).addClass("active").css("color", "darkred");
    $(".tab_content").hide()
    var activeTab = $(this).attr("rel");
    $("#" + activeTab).fadeIn()
});
});
</script>