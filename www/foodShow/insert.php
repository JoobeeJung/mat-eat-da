<?php
session_start();
?>
<meta charset="utf-8">
<?php

if(isset($_REQUEST["page"]))
  $page=$_REQUEST["page"];
else 
  $page=1;
if(!isset($_SESSION["userid"])) {
?>
<script>
      alert('로그인 후 이용해 주세요.');
      history.back();
</script>
<?php
}
if(isset($_REQUEST["mode"]))
  $mode=$_REQUEST["mode"];
else 
  $mode="";
if(isset($_REQUEST["foodShow_num"]))
  $num=$_REQUEST["foodShow_num"];
else 
  $num="";
$subject=$_REQUEST["foodShow_subject"];
$content=$_REQUEST["foodShow_content"];
$url=$_REQUEST["foodShow_url"];

if($url){
  $url = str_replace("watch?v=", "embed/", $url);
}
$hash_tag = $_REQUEST["hash_tag"];
$hash_tag = preg_replace("/[\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$<>()\[\]\{\}]/i", "", $hash_tag);
$hash_tag = str_replace(" ", "", $hash_tag);
if(substr($hash_tag, 1, 1) != "#"){
  $hash_tag = "#".$hash_tag;
}
if(substr($hash_tag, strlen($hash_tag)-1, 1) == "#"){
  $hash_tag = substr($hash_tag, 0, -1);
}
      
require_once("../lib/MYDB.php");
$pdo = db_connect();
  
if ($mode=="modify"){
    try{
      $pdo->beginTransaction();   
      $sql = "update joobee97.foodShow0201 set foodShow_subject=?, foodShow_content=?, foodShow_hashTag=?, foodShow_url=? where foodShow_num=?";
      $stmh = $pdo->prepare($sql); 
      $stmh->bindValue(1, $subject, PDO::PARAM_STR);  
      $stmh->bindValue(2, $content, PDO::PARAM_STR);
      $stmh->bindValue(3, $hash_tag, PDO::PARAM_STR);
      $stmh->bindValue(4, $url, PDO::PARAM_STR);
      $stmh->bindValue(5, $num, PDO::PARAM_STR);   
      $stmh->execute();
      $pdo->commit(); 
      } catch (PDOException $Exception) {
          $pdo->rollBack();
          print "오류: ".$Exception->getMessage();
      }                         
} else	{
  try{
    $pdo->beginTransaction();
    $sql = "insert into joobee97.foodShow0201(foodShow_id, foodShow_subject, foodShow_content, foodShow_date, foodShow_hit, foodShow_hashTag, foodShow_url)";
    $sql .= "values(?, ?, ?, now(), 0, ?, ?)";
    $stmh = $pdo->prepare($sql); 
    $stmh->bindValue(1, $_SESSION["userid"], PDO::PARAM_STR);
    $stmh->bindValue(2, $subject, PDO::PARAM_STR);  
    $stmh->bindValue(3, $content, PDO::PARAM_STR);
    $stmh->bindValue(4, $hash_tag, PDO::PARAM_STR);
    $stmh->bindValue(5, $url, PDO::PARAM_STR);   
    $stmh->execute();
    $pdo->commit(); 
    } catch (PDOException $Exception) {
        $pdo->rollBack();
      print "오류: ".$Exception->getMessage();
    }   
  }
echo "<script>window.location.href='list.php?page=$page'</script>";
//header('Location: http://localhost:8090/foodShow/list.php');
?>