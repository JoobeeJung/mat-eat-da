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

if(isset($_REQUEST["restaurant_num"]))
  $num=$_REQUEST["restaurant_num"];
else 
  $num="";

$subject=$_REQUEST["restaurant_subject"];
$content=$_REQUEST["restaurant_content"];
$storeName=$_REQUEST["restaurant_storeName"];
$address=$_REQUEST["addr2"];
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
      $sql = "update joobee97.restaurant0201 set restaurant_subject=?, restaurant_content=?, restaurant_address=?, restaurant_hashTag=?, restaurant_storeName=? where restaurant_num=?";
      $stmh = $pdo->prepare($sql); 
      $stmh->bindValue(1, $subject, PDO::PARAM_STR);  
      $stmh->bindValue(2, $content, PDO::PARAM_STR);      
      $stmh->bindValue(3, $address, PDO::PARAM_STR);
      $stmh->bindValue(4, $hash_tag, PDO::PARAM_STR);
      $stmh->bindValue(5, $storeName, PDO::PARAM_STR);
      $stmh->bindValue(6, $num, PDO::PARAM_STR);   
      $stmh->execute();
      $pdo->commit(); 
      } catch (PDOException $Exception) {
          $pdo->rollBack();
          print "오류: ".$Exception->getMessage();
      }                         
      
} else	{
  try{
    $pdo->beginTransaction();
    $sql = "insert into joobee97.restaurant0201(restaurant_id, restaurant_subject, restaurant_content, restaurant_date, restaurant_hit, restaurant_address, restaurant_hashTag, restaurant_storeName)";
    $sql .= "values(?, ?, ?, now(), 0, ?, ?, ?)";
    $stmh = $pdo->prepare($sql); 
    $stmh->bindValue(1, $_SESSION["userid"], PDO::PARAM_STR);
    $stmh->bindValue(2, $subject, PDO::PARAM_STR);  
    $stmh->bindValue(3, $content, PDO::PARAM_STR);
    $stmh->bindValue(4, $address, PDO::PARAM_STR);
    $stmh->bindValue(5, $hash_tag, PDO::PARAM_STR);
    $stmh->bindValue(6, $storeName, PDO::PARAM_STR);     
    $stmh->execute();
    $pdo->commit(); 
    } catch (PDOException $Exception) {
        $pdo->rollBack();
      print "오류: ".$Exception->getMessage();
    }   
  }
echo "<script>window.location.href='list.php?page=$page'</script>";
//header('Location: http://localhost:8090/restaurant/list.php');
?>