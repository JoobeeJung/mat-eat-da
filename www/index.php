<?php
session_start();

require_once("./lib/MYDB.php");
$pdo = db_connect();

$sql_hashTag = "SELECT  A.foodShow_hashTag AS hashTag
                FROM    joobee97.foodShow0201 A
                UNION ALL
                SELECT  A.restaurant_hashTag AS hashTag
                FROM    joobee97.restaurant0201 A
                UNION ALL
                SELECT  A.recipe_hashTag AS hashTag
                FROM    joobee97.recipe0201 A";

$sql_totalDate = "SELECT   date, COUNT(*) AS CNT
                  FROM     (
                  SELECT   SUBSTR(restaurant_date,1,10) AS date
                  FROM     joobee97.restaurant0201
                  UNION ALL
                  SELECT   SUBSTR(recipe_date,1,10) AS date
                  FROM     joobee97.recipe0201
                  UNION ALL
                  SELECT   SUBSTR(foodShow_date,1,10) AS date
                  FROM     joobee97.foodShow0201
                  ) AS total_date
                  GROUP BY date";
                  
$sql_foodShow = "SELECT   A.foodShow_url,
                  (SELECT COUNT(*) FROM joobee97.boardLike0201 WHERE boardLike_type = 'foodShow' AND A.foodShow_num = boardLike_num GROUP BY boardLike_num) AS LikeCNT
                 FROM     joobee97.foodShow0201 A
                 WHERE    foodShow_url IS NOT NULL
                 ORDER BY LikeCNT DESC
                 LIMIT    1";
try{
  $stmh_foodShow = $pdo->query($sql_foodShow);
  $row_foodShow = $stmh_foodShow->fetch(PDO::FETCH_ASSOC);
  $no1FoodShow = $row_foodShow["foodShow_url"];
?>

<!DOCTYPE html>
<html>
<head> 
<title>맛Eat다</title>
<link rel="shortcut icon" type="image⁄x-icon" href="./img/M_logo.png">
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="./css/common.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

</head>
<body>
<div id="wrap">

  <div id="header">
    <?php include "./lib/top_login1.php"; ?>
  </div>

  <div id="menu">
    <?php include "./lib/top_menu1.php"; ?>
  </div>
</div>
<div id="content3" style="width:100%; height:400px; margin-left:0px">
      <ul id= "bxslider" class="bxslider" align="center" style="width:100%;height:515px;">
          <li>
            <div title="배너1"><a href="./recipe/view.php?recipe_num=11"><img src="./img/M_banner1.png"></a></div>
          </li>
  				<li>
            <div title="배너2"><a href="./recipe/view.php?recipe_num=12"><img src="./img/M_banner2.png"></a></div>
          </li>
          <li>
            <div title="배너3"><a href="./recipe/view.php?recipe_num=8"><img src="./img/M_banner3.png"></a></div>
          </li>
          <li>
            <div title="배너4"><a href="./recipe/view.php?recipe_num=9"><img src="./img/M_banner4.png"></a></div>
          </li>
          <li>
            <div title="배너5"><a href="./recipe/view.php?recipe_num=7"><img src="./img/M_banner5.png"></a></div>
          </li>
          <li>
            <div style="position:absolute;font-size:15px;margin-left:960px;"><h1>실시간 해시태그</h1></div>
            <div id="graph" style="height: 300px; margin:50px;" title="그래프2"></div>
          </li>
          <li>
            <div style="position:absolute;font-size:15px;margin-left:960px;"><h1>게시물 업로드수</h1></div>
            <div id="myfirstchart" style="height: 300px; margin:50px;" title="그래프1"></div>
          </li>
			</ul>
    
  </div>


<div id="content3" align="center" style="width:590px;height:350px">
    <?php
    if($no1FoodShow){
    ?>
    <iframe width="600" height="350" src="<?=$no1FoodShow?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    <?php
    }else{
    ?>
    <img src=./img/M_warning.png width="600" height="350">
    <?php
    }
    ?>  
</div>
<div id="content3" align="center" style="width:590px;height:350px; margin-top:10px;"><a href="./restaurant/view.php?restaurant_num=2"><img src="./img/index_banner3.png" style="width:590px;height:340px;"></a></div>
<div style="width:590px;height:700px; margin-left:1080px"><a href="./recipe/view.php?recipe_num=10"><img src="./img/index_banner2.png" style="width:590px;height:700px"></a></div>

<script>
<?php
  $stmh_hashTag = $pdo->query($sql_hashTag);
  $stmh_totalDate = $pdo->query($sql_totalDate);

  $rowcnt = $stmh_hashTag->rowcount();
  $rowcnt2 = $stmh_totalDate->rowcount();
  $j=0;
  $total_hash = '';
  $max_hash;
  $max_hash_key;
  $sum_hash;
  $rank_hash;
  
  while($row = $stmh_hashTag->fetch(PDO::FETCH_ASSOC)) {
    $total_hash .= $row["hashTag"];
  }
  $total_hash = "제외".$total_hash;
  $hash_tag = explode('#', $total_hash);
  $hash_cnt = array_count_values($hash_tag);
  arsort($hash_cnt);
  
  
  foreach( $hash_cnt as $key => $value ){
  $sum_hash += $value;
  $rank_hash[$j][0] = $key;
  $rank_hash[$j][1] = $value;
  $j++;
  }
  $max_hash = max($hash_cnt);
  $max_hash_key = array_search($max_hash, $hash_cnt);

  $date_array;
  $cnt_array;
?>

  new Morris.Line({
  element: 'myfirstchart',
  data: [
    <?php
    $z=1;
    while($row2 = $stmh_totalDate->fetch(PDO::FETCH_ASSOC)){
      $date_array = $row2["date"];
      $cnt_array = $row2["CNT"];
      if($z!=$rowcnt2){
      ?>
      { year: '<?=$date_array?>', value: <?=$cnt_array?> },
      <?php
      }else if($z==$rowcnt2){
      ?>
      { year: '<?=$date_array?>', value: <?=$cnt_array?> }
      <?php
      }
      $z++;
    }
    ?>
  ],
  xkey: 'year',
  ykeys: ['value'],
  labels: ['Value']
});

Morris.Donut({
  element: 'graph',
  data: [
    {value: <?=round($rank_hash[1][1]/$sum_hash*100)?>, label: '#<?=$rank_hash[1][0]?>'},
    {value: <?=round($rank_hash[2][1]/$sum_hash*100)?>, label: '#<?=$rank_hash[2][0]?>'},
    {value: <?=round($rank_hash[3][1]/$sum_hash*100)?>, label: '#<?=$rank_hash[3][0]?>'},
    {value: <?=round($rank_hash[4][1]/$sum_hash*100)?>, label: '#<?=$rank_hash[4][0]?>'}
  ],
  formatter: function (x) { return x + "%"}
}).on('click', function(i, row){
  console.log(i, row);
});

Morris.Bar({
  element: 'bar',
  axes: false,
  data: [
    {x: '맛집', y: 3, z: 2, a: 3},
    {x: '레시피', y: 2, z: null, a: 1},
    {x: '먹방', y: 0, z: 2, a: 4},
    {x: '기타', y: 2, z: 4, a: 3}
  ],
  xkey: 'x',
  ykeys: ['y', 'z', 'a'],
  labels: ['Y', 'Z', 'A']
});


</script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script src="./js/jquery.bxslider.min.js"></script>
<link href="./js/jquery.bxslider.css" rel="stylesheet" />  
 <script>
$('.bxslider').bxSlider({
  
  auto: true, 
  speed: 3500, 
  pause: 4000, 
  mode:'horizontal', 
  autoControls: true, 
  captions: true,
  pager:true
});
</script>
<?php
}catch (PDOException $Exception) {
  print "오류: ".$Exception->getMessage();
} 
?>
<div id="footer_menu">
  <?php include "./lib/footer1.php"; ?>
</div>
</body>
</html>
