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

<script type="text/javascript" src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=9pyy87m6ck&submodules=geocoder"></script>
<!--<script type="text/javascript" src="https://openapi.map.naver.com/openapi/v3/maps.js?clientId=9pyy87m6ck&submodules=geocoder"></script>-->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="//code.jquery.com/jquery.min.js"></script>

</head>

<?php

$id = $_SESSION["userid"];
$board_type = "restaurant";
require_once("../lib/MYDB.php");
$pdo = db_connect();

if(isset($_REQUEST["page"])) // $_REQUEST["page"]값이 없을 때에는 1로 지정 
  $page=$_REQUEST["page"];  // 페이지 번호
else
  $page=1;

  $scale = 9;       // 한 페이지에 보여질 게시글 수
  $page_scale = 5;  // 한 페이지당 표시될 페이지 수
  $first_num = ($page-1) * $scale; // 리스트에 표시되는 게시글의 첫 순번.

if(isset($_REQUEST["mode"]))
  $mode=$_REQUEST["mode"];
else 
  $mode="";
if(isset($_REQUEST["search"]))
  $search=$_REQUEST["search"];
else 
  $search="";
if(isset($_REQUEST["find"]))
  $find=$board_type."_".$_REQUEST["find"];
else
  $find="";

if($mode=="search"){
  if(!$search){
?>
    <script>
      alert('검색할 단어를 입력해 주세요!');
      history.back();
    </script>
<?php
  }
$sql="SELECT A.*, B.*,
             substr(A.restaurant_content, instr(A.restaurant_content,'<img'), 
                instr(substr(A.restaurant_content, instr(A.restaurant_content,'<img')), '>')) AS thumbnail
      FROM joobee97.restaurant0201 A, joobee97.member0201 B 
      WHERE A.restaurant_id = B.id 
      AND $find LIKE '%$search%'
      ORDER BY A.restaurant_num DESC
      LIMIT $first_num, $scale";
} 
else {
$sql="SELECT A.*, B.*,
             substr(A.restaurant_content, instr(A.restaurant_content,'<img'), 
                instr(substr(A.restaurant_content, instr(A.restaurant_content,'<img')), '>')) AS thumbnail 
      FROM joobee97.restaurant0201 A, joobee97.member0201 B 
      WHERE A.restaurant_id = B.id 
      ORDER BY A.restaurant_num DESC
      LIMIT $first_num, $scale";
}
try{  
  $stmh = $pdo->query($sql); 
  $count=$stmh->rowCount();
  
  $sql_total = "select * from joobee97.restaurant0201";  //전체 레코드수를 파악하기 위함.
  $stmh_total = $pdo->query($sql_total);
      
  $total_row = $stmh_total->rowCount();     //전체 글수
  $total_page = ceil($total_row / $scale); // 전체 페이지 블록 수
  $current_page = ceil($page/$page_scale); //현재 페이지 블록 위치계산
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


<?php 

try{
  $sql5 = "SELECT restaurant_address AS addr, restaurant_storeName AS sname
           FROM   joobee97.restaurant0201
           WHERE  restaurant_address LIKE '서울특별시%'
           LIMIT  100";
  $stmh5 = $pdo->query($sql5);
  $rowCount=$stmh5->rowCount(); 
  $cnt1 = 0;
  while($row = $stmh5->fetch(PDO::FETCH_ASSOC)){
    $item_address[$cnt1]     = $row["addr"];
    $item_storeName[$cnt1]   = $row["sname"];
    $cnt1++;
  }
?>
<?php
} catch (PDOException $Exception) {
  print "오류: ".$Exception->getMessage();
}
?>
<div id="content3" align= "center">
<img src="../img/muk_moa.png" style="width:150px; height:100%; margin:30px 0 20px 0;">
<div id="map" class="content3" align= "center" style="width:1198px;height:500px;"></div>
    <script>
      var map = new naver.maps.Map('map', {
      center: new naver.maps.LatLng(37.5666805, 126.9784147),
      zoom: 7,
      minZoom: 1,
      mapTypeId: naver.maps.MapTypeId.HYBRID,
      zoomControl: true,
      zoomControlOptions: {
        position: naver.maps.Position.TOP_RIGHT
      },
      disableKineticPan: false
});
<?php

try{
  $sql5 = "SELECT restaurant_address AS addr, restaurant_storeName AS sname,
                  substr(restaurant_content, instr(restaurant_content,'<img'), 
                    instr(substr(restaurant_content, instr(restaurant_content,'<img')), '>')) AS thumbnail
           FROM   joobee97.restaurant0201
           WHERE  restaurant_address LIKE '서울특별시%'
           LIMIT  100";
  $stmh5 = $pdo->query($sql5);
  $rowCount=$stmh5->rowCount(); 
  

  while($row = $stmh5->fetch(PDO::FETCH_ASSOC)){
    $item_address2     = $row["addr"];
    $item_storeName2   = $row["sname"];
    $item_thumbnail2  = $row["thumbnail"];
    if($item_thumbnail2){
      $item_thumbnail2 = str_replace("img ", "img style=\"width:150px;height:80px;margin:5px;\" ", $item_thumbnail2);
    }else if(!$item_thumbnail2){
      $item_thumbnail2 = '<img src="../img/M_warning.png" style="width:150px; height:80px;margin:5px;">';
    }
?>
      var myaddress = "<?=$item_address2?>";
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
              content: '<p align="center" style="font-size:15px;"><b><?=$item_storeName2?></b></p><?=$item_thumbnail2?>',
              maxWidth: 160,
              backgroundColor: "#eee",
              borderColor: "#2db400",
              borderWidth: 5,
              anchorSize: new naver.maps.Size(30, 30),
              anchorSkew: true,
              anchorColor: "#eee",
              pixelOffset: new naver.maps.Point(20, -20)
          });
      });
<?php
}
} catch (PDOException $Exception) {
  print "오류: ".$Exception->getMessage();
}
?>
      </script>
</div>

<div id="right_menu" style="position: absolute; top: 10px; margin-left: 50px; width:500px"><a href="http://www.chungjungone.com/knowhow/cooking/cookingClassList.do"><img src="../img/side_banner.png"></a></div>
<div id="wrap">

  <div id="contentKing">
    <div style="margin:30px 80px 10px 80px;">
    <form name="board_form" method="post" action="list.php?mode=search">
      <select name="find" style="margin-right:5px; width:150px; height:50px; background-color:#ffffff; border:solid 3px #eb6e72; font-size:20px; vertical-align:top;">
            <option value='subject'>제목</option>
            <option value='content'>내용</option>
            <option value='nick'>닉네임</option>
            <option value='hashTag'>해시태그</option>
      </select>
      <input type="search" name="search" style="margin-right:5px; width:850px; height:50px; background-color:#ffffff; border:solid 3px #eb6e72; font-size:20px; vertical-align:top;" placeholder="Search...">
      <input type="image" style="width:80px; height:45px; background-color:#eb6e72; border:solid 3px #eb6e72; vertical-align:top;" src="../img/list_search_button.png">
      <!--<input type="submit" style="width:80px; height:50px; background-color:#cccccc; border:solid 3px #cccccc; font-size:20px;" value="검색">-->
    </form>
    </div>
<?php

if ($page==1)  
  $start_num=$total_row;    // 페이지당 표시되는 첫번째 글순번
else 
  $start_num=$total_row-($page-1) * $scale;

$cnt = 4;
$rowcnt = 1;
while($row = $stmh->fetch(PDO::FETCH_ASSOC)) {
  $item_num=$row["restaurant_num"];
  $item_id=$row["restaurant_id"];
  $item_name=$row["name"];
  $item_nick=$row["nick"];
  $item_hit=$row["restaurant_hit"];
  $item_date=$row["restaurant_date"];
  $item_date=substr($item_date, 0, 10);
  $item_subject=str_replace(" ", "&nbsp;", $row["restaurant_subject"]);
  $item_img = $row["thumbnail"];

  $item_img = str_replace(">", "alt='sample45'>", $item_img);
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
              <div id="list_content"  class="snip1361">
                  <a href="view.php?restaurant_num=<?=$item_num?>&page=<?=$page?>">
<?php 
if($item_img){
?>
<?=$item_img?>
<?php
}else{
?>
<img src=../img/M_warning.png  alt="sample45">
<?php
}
?>
<?php 
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
              <div align="right" style="width:90%; float:right; font-size:15px; word-spacing:10px;">
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
      print "<a href=list.php?page=$prev_page>◀ </a>";
      }
 
      for($i=$start_page; $i<=$end_page && $i<= $total_page; $i++) 
      {        // [1][2][3] 페이지 번호 목록 출력
        if($page==$i) // 현재 위치한 페이지는 링크 출력을 하지 않도록 설정.
           print "<font color=red><b>[$i]</b></font>"; 
        else 
           print "<a href=list.php?page=$i>[$i]</a>";
      }

      if($page<$total_page)
      {
        $next_page = $page + $page_scale;
        if($next_page > $total_page) 
            $next_page = $total_page;
        // netx_page 값이 전체 페이지수 보다 크면 맨 뒤 페이지로 이동시킴
        print "<a href=list.php?page=$next_page> ▶</a><p>";
      }

    } catch (PDOException $Exception) {
  print "오류: ".$Exception->getMessage();
}  
?> 
      </div>
    </div>
<div id="list_write_button">
          <a href="list.php?page=<?=$page?>"><img src="../img/list.png"></a>&nbsp;
<?php
if(isset($_SESSION["userid"]))
{
?>
          <a href="write_form.php?page=<?=$page?>"><img src="../img/write.png"></a>
<?php
}
?>
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
</div>
<div id="footer_menu">
  <?php include "../lib/footer2.php"; ?>
</div>
</body>
</html>