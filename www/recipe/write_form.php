<?php
session_start();


$board_type = "recipe";

if(isset($_REQUEST["page"]))  // 페이지 번호
  $page=$_REQUEST["page"];
else
  $page=1;
if(isset($_REQUEST["mode"]))
  $mode=$_REQUEST["mode"];
else
  $mode="";
if(isset($_REQUEST["recipe_num"]))
  $num=$_REQUEST["recipe_num"];
else
  $num="";
        
if ($mode=="modify"){
  try{   
    require_once("../lib/MYDB.php");
    $pdo = db_connect();
    
    $sql = "select * from joobee97.recipe0201 where recipe_num = ? ";
    $stmh = $pdo->prepare($sql); 
    $stmh->bindValue(1,$num,PDO::PARAM_STR); 
    $stmh->execute();
    $count = $stmh->rowCount();              
  if($count<1){  
    print "검색결과가 없습니다.<br>";
    }else{
    $row = $stmh->fetch(PDO::FETCH_ASSOC);
    $item_subject = $row["recipe_subject"];
    $item_content = $row["recipe_content"];
    $item_hashTag = $row["recipe_hashTag"];
    }
    }catch (PDOException $Exception) {
      print "오류: ".$Exception->getMessage();
    }
}
?>

<!DOCTYPE HTML>
<html>
<head> 
<meta charset="utf-8">
<title>맛Eat다</title>
<link rel="shortcut icon" type="image⁄x-icon" href="../img/M_logo.png">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<link  rel="stylesheet" type="text/css" href="../css/common.css">
<link  rel="stylesheet" type="text/css" href="../css/mateatda.css">

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="//code.jquery.com/jquery.min.js"></script>
<script type="text/javascript" src="../editor/js//HuskyEZCreator.js" charset="utf-8"></script>
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
      <div id="title">
        <img src="../img/write_form_title2.png">
      </div>
      <div class="clear"></div>
      <div id="write_form_title">
        <img src="../img/write_form_title2.png">
      </div>
      <div class="clear"></div>
<?php
if($mode=="modify"){
?>
      <form name="board_form" method="post" action="insert.php?mode=modify&recipe_num=<?=$num?>&page=<?=$page?>" enctype="multipart/form-data" onsubmit="submitContents(this);" novalidate> 
<?php  
} else {
?>
      <form  name="board_form" method="post" action="insert.php?page=<?=$page?>" enctype="multipart/form-data" onsubmit="submitContents(this);" novalidate> 
<?php
}
?>
      <div id="write_form">
        <div class="write_line"></div>
        <div id="write_row1">
          <div class="col1"> 별명 </div>
          <div class="col2"><?=$_SESSION["nick"]?></div>
        </div>
        <div class="write_line"></div>
        <div id="write_row2">
          <div class="col1"> 제목   </div>
          <div class="col2">
            <input type="text" name="recipe_subject" style="width:750px;"<?php if($mode=="modify"){ ?>value="<?=$item_subject?>" <?php }?> required>
          </div>
        </div>
        <div class="write_line"></div>
        <div id="write_row2">
          <div class="col1"> 해시태그   </div>
          <div class="col2">
            <input type="text" name="hash_tag" style="width:750px;"<?php if($mode=="modify"){ ?>value="<?=$item_hashTag?>" <?php }?> required>
          </div>
        </div>
        <div class="clear"></div>
        <div class="write_line"></div>
        <div id="write_row3">
          <div class="col1" style="height:450px;"> 내용   </div>
          <div class="col2">
            <textarea rows="40" cols="121" name="recipe_content" id="ir1" required><?php if($mode=="modify") print $item_content?></textarea>
<script type="text/javascript">

var oEditors = [];

nhn.husky.EZCreator.createInIFrame({
    oAppRef: oEditors,
    elPlaceHolder: "ir1",
    sSkinURI: "../editor/SmartEditor2Skin.html",
    fCreator: "createSEditor2"
});
</script>
      </div>
	</div>
        <div class="clear"></div>
            
<script>
function submitContents(elClickedObj) {
    a = oEditors.getById["ir1"].exec("UPDATE_CONTENTS_FIELD", []);
    text.a;
    alert(document.getElementById("ir1").value);
}
   try {
     elClickedObj.form.submit();
  } catch(e) {}
</script>  
        <div id="write_row9">
          <div id="write_button">
            <input type="image" src="../img/ok.png">&nbsp;
            <a href="list.php?page=<?=$page?>"><img src="../img/list.png"></a>
          </div>
        </div>
      </form>
    </div> 
  </div> 
</div>
<div id="footer_menu">
  <?php include "../lib/footer2.php"; ?>
</div>
</body>
</html>