<?php
session_start(); 
if(isset($_REQUEST["page"])) // $_REQUEST["page"]값이 없을 때에는 1로 지정 
  $page=$_REQUEST["page"];  // 페이지 번호
else
  $page=1;
$num=$_REQUEST["restaurant_num"];
$id=$_SESSION["userid"];
$board_type = "restaurant";
require_once("../lib/MYDB.php");
$pdo = db_connect();

try{
    $sql = "SELECT A.*, B.*,
                  (SELECT boardLike_id FROM joobee97.boardLike0201 WHERE boardLike_id = '$id' AND boardLike_num = A.restaurant_num AND boardLike_type = '$board_type') AS boardLike_id,
                  substr(A.restaurant_content, instr(A.restaurant_content,'<img'), 
                    instr(substr(A.restaurant_content, instr(A.restaurant_content,'<img')), '>')) AS thumbnail 
            FROM joobee97.restaurant0201 A, joobee97.member0201 B
            WHERE A.restaurant_id = B.id 
            AND   A.restaurant_num = $num
            ORDER BY A.restaurant_num DESC";
    $stmh = $pdo->prepare($sql);
    $stmh->bindValue(1, $num, PDO::PARAM_STR);
    $stmh->execute();
    
    $row = $stmh->fetch(PDO::FETCH_ASSOC);

    $item_num     = $row["restaurant_num"];
    $item_id      = $row["restaurant_id"];
    $item_name    = $row["name"];
    $item_nick    = $row["nick"];
    $item_hit     = $row["restaurant_hit"];
    $item_address = $row["restaurant_address"];
    $item_hashTag = $row["restaurant_hashTag"];
    $item_storeName = $row["restaurant_storeName"];
    $item_thumbnail = $row["thumbnail"];

    $item_date    = $row["restaurant_date"];
    $item_date    = substr($item_date,0,10);
    $item_subject = str_replace(" ", "&nbsp;", $row["restaurant_subject"]);
    $item_content = $row["restaurant_content"];

    $boardLike_id = $row["boardLike_id"];

    if($item_thumbnail){
      $item_thumbnail = str_replace("img ", "img style=\"width:150px;height:80px;margin:5px;\" ", $item_thumbnail);
    }else if(!$item_thumbnail){
      $item_thumbnail = '<img src="../img/M_warning.png" style="width:150px; height:80px;margin:5px;">';
    }
    
    if(!isset($boardLike_id)){
      $boardLike_id = 0;
    }
    $item_hashTag = str_replace('##', '#', $item_hashTag);
    $hash_tag =explode('#', $item_hashTag);
    $cnt = count($hash_tag);
    $new_hit = $item_hit + 1;
    try{
      $pdo->beginTransaction(); 
      $sql4 = "update joobee97.restaurant0201 set restaurant_hit=? where restaurant_num=?";   // 조회수 증가
      $stmh4 = $pdo->prepare($sql4);
      $stmh4->bindValue(1, $new_hit, PDO::PARAM_STR);      
      $stmh4->bindValue(2, $num, PDO::PARAM_STR);
      $stmh4->execute();
      $pdo->commit();
      } catch (PDOException $Exception) {
        $pdo->rollBack();
      print "오류: ".$Exception->getMessage();
    }
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>맛Eat다</title>
<link rel="shortcut icon" type="image⁄x-icon" href="../img/M_logo.png">
<link  rel="stylesheet" type="text/css" href="../css/common.css">
<link  rel="stylesheet" type="text/css" href="../css/mateatda.css">
<link rel="stylesheet" type="text/css" href="../css/sideMenu.css">

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="//code.jquery.com/jquery.min.js"></script>

<!--네이버 지도 api 구현중-->
<script type="text/javascript" src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=9pyy87m6ck&submodules=geocoder"></script>
<!--<script type="text/javascript" src="https://openapi.map.naver.com/openapi/v3/maps.js?clientId=9pyy87m6ck&submodules=geocoder"></script>-->

<script type="text/javascript">
  function del(href) 
  {
    if(confirm("한번 삭제한 자료는 복구할 방법이 없습니다.\n\n정말 삭제하시겠습니까?")) {
        document.location.href = href;
      }
  }

  function clickLikeBtn(href) {
    if('<?=$boardLike_id?>' != '<?=$_SESSION["userid"]?>'){
      document.likeBtn.src = "../img/M_like2.png"; //좋아요
    }else if ('<?=$boardLike_id?>' == '<?=$_SESSION["userid"]?>'){
      document.likeBtn.src = "../img/M_like1.png"; //좋아요 취소
    }
    document.location.href = href;
  }

  function clickLikeBtn2(href) 
  {
    if(confirm("끙")) {
        document.location.href = href;
      }
  }

</script>
</head>

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
<div id="content">
  <div id="col2">
    <div id="title"><img src="../img/2ru.png" style="width:100px; height:40px; margin-left:10px;"></div>
    <div id="view_comment"> &nbsp;</div>
    <div id="view_title">
      <div id="view_title1"><b>(<?=$item_storeName?>) </b><?= $item_subject ?></div>
      <div id="view_title2"><?= $item_nick ?> | 조회 : <?= $item_hit ?> | <?= $item_date ?> </div>	
    </div>
    <div><b>해시태그 : 
    <?php
    for($i = 1 ; $i < $cnt ; $i++){
      ?><a href="../mypage/hash_list.php?mode=search&search=<?=$hash_tag[$i]?>&find=hashTag">
      <?php
      print ("#".$hash_tag[$i]." ")
      ?></a>
      <?php
    }
    ?>
    </b></div>
    <div id="view_content">
  <?= $item_content ?>
    </div>
    <div><b><p size="10px">주소 : <?=$item_address?></p></b></div>
    <div id="map" style="width:100%;height:400px;"></div>
    <script>
      var map = new naver.maps.Map('map');
      var myaddress = "<?=$item_address?>";
      naver.maps.Service.geocode({address: myaddress}, function(status, response) {
          if (status !== naver.maps.Service.Status.OK) {
              return alert(myaddress + '의 검색 결과가 없거나 기타 네트워크 에러');
          }
          var result = response.result;
          var myaddr = new naver.maps.Point(result.items[0].point.x, result.items[0].point.y);
          map.setCenter(myaddr);
          var marker = new naver.maps.Marker({
            position: myaddr,
            map: map
          });
          naver.maps.Event.addListener(marker, "click", function(e) {
            if (infowindow.getMap()) {
                infowindow.close();
            } else {
                infowindow.open(map, marker);
            }
          });
          var infowindow = new naver.maps.InfoWindow({
              content: '<p align="center" style="font-size:15px;"><b><?=$item_storeName?></b></p><?=$item_thumbnail?>',
              maxWidth: 160,
              backgroundColor: "#eee",
              borderColor: "#2db400",
              borderWidth: 5,
              anchorSize: new naver.maps.Size(30, 30),
              anchorSkew: true,
              anchorColor: "#eee",
              pixelOffset: new naver.maps.Point(20, -20)
          });
          infowindow.open(map, marker);
      });
      </script>
         <div id="ripple">

  <form name="ripple_form" method="post" action="../ripple/insert_boardRipple.php?num=<?=$item_num?>&board_type=<?=$board_type?>"> 
        <div id="ripple_box">
          <div id="ripple_box1">
<?php if(!$boardLike_id) {
?>
            <a href="javascript:clickLikeBtn('../like/insert_boardLike.php?num=<?=$num?>&board_type=<?=$board_type?>')">
            <img name="likeBtn" src="../img/M_like1.png" style="width:30px; height:30px; float:left;">
            </a>
<?php }else {
?>
            <a href="javascript:clickLikeBtn('../like/delete_boardLike.php?num=<?=$num?>&board_type=<?=$board_type?>')">
            <img name="likeBtn" src="../img/M_like2.png" style="width:30px; height:30px; float:left;">
            </a>
<?php 
}
try{
  $sql3 = "SELECT boardLike_type, boardLike_num, COUNT(*) AS CNT
           FROM joobee97.boardLike0201
           WHERE boardLike_type = '$board_type'
           AND boardLike_num = $item_num
           GROUP BY boardLike_num, boardLike_type
           ORDER BY CNT DESC";
  $stmh3 = $pdo->query($sql3);
  $row = $stmh3->fetch(PDO::FETCH_ASSOC);

  $likeCnt     = $row["CNT"];
?>
<br> <?=$likeCnt?> LIKE
<?php
} catch (PDOException $Exception) {
  print "오류: ".$Exception->getMessage();
}
?>
          </div>
          <div id="ripple_box1"><img src="../img/memo_ripple_button.png" style="width:160px;"></div>
          <div id="ripple_box2">
            <textarea rows="5" cols="95" name="boardRipple_content" required></textarea>
          </div>
          <div id="ripple_box3"><input type=image src="../img/ripple.png"></div>
        </div>
  </form>
<?php
try{
  $sql2 = "SELECT A.*, B.*
           FROM   joobee97.boardRipple0201 A, joobee97.member0201 B
           WHERE  A.boardRipple_parent = $item_num
           AND    A.boardRipple_id = B.id
           AND    A.boardRipple_type = '$board_type'
           ORDER BY A.boardRipple_num DESC";
  $stmh2 = $pdo->query($sql2);     
} catch (PDOException $Exception) {
  print "오류: ".$Exception->getMessage();
}
?>
<div style="overflow:scroll;width:98%;max-height:270px;">
<?php
  while ($row_ripple = $stmh2->fetch(PDO::FETCH_ASSOC)) {
    $ripple_num     = $row_ripple["boardRipple_num"];
    $ripple_id      = $row_ripple["boardRipple_id"];
    $ripple_nick    = $row_ripple["nick"];
    $ripple_content = str_replace("\n", "<br>", $row_ripple["boardRipple_content"]);
    $ripple_content = str_replace(" ", "&nbsp;", $ripple_content);
    $ripple_date    = $row_ripple["boardRipple_date"];
?>

        <div id="ripple_writer_title">
        <ul>
          <li id="writer_title1"><?=$ripple_nick?></li>
          <li id="writer_title2"><?=$ripple_date?></li>
          &nbsp; &nbsp;
<?php
if(isset($_SESSION["userid"])){
if($_SESSION["userid"]=="admin" || $_SESSION["userid"]==$ripple_id)
      print "<a href=../ripple/delete_boardRipple.php?num=$item_num&ripple_num=$ripple_num&board_type=$board_type>[삭제]</a>"; 
    }
?>       
        </ul>
        </div>
        <div id="ripple_content"><?=$ripple_content?></div>
        <div class="hor_line_ripple"></div>
<?php
  }
?>
</div>
 </div>
    <div id="view_button">
      <a href="list.php"><img src="../img/list.png"></a>&nbsp;
<?php
  if(isset($_SESSION["userid"])) {
    if($_SESSION["userid"]==$item_id || $_SESSION["userid"]=="admin" || $_SESSION["level"]==1 )
        {
?>
      <a href="write_form.php?mode=modify&restaurant_num=<?=$num?>"><img src="../img/modify.png"></a>&nbsp;
      <a href="javascript:del('delete.php?restaurant_num=<?=$num?>&board_type=<?=$board_type?>')"><img src="../img/delete.png"></a>&nbsp;
<?php  	}
?>
      <a href="write_form.php"><img src="../img/write.png"></a>
<?php
    }
} catch (PDOException $Exception) {
      print "오류: ".$Exception->getMessage();
}
?>
</div>
<div class="clear"></div>
      </div>
    </div>
    <div id="side_content2" class="side_content2">
      <div id="mysidenav" class="sidenav">
        <?php
        $qryStr = array($item_num, $board_type, $id);
        $_POST["qryStr"] = $qryStr;
        ?><img src="../img/direct.png" style="width:350px">
        <?php include "../lib/side_menu.php" ?>
      </div>
      <script type="text/javascript">
        $(function(){
          $('.side_content2').mouseenter(function(){
            document.getElementById('mysidenav').style.width = '370px';
          });
          $('.side_content2').mouseleave(function(){
            document.getElementById('mysidenav').style.width = '0';
          });
        });
        function closeNav() {
          document.getElementById('mysidenav').style.width = '0';
        }
      </script>
    </div>
</div>
<div id="footer_menu">
  <?php include "../lib/footer2.php"; ?>
</div>
</body>
</html>