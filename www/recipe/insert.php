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

if(isset($_REQUEST["recipe_num"]))
  $num=$_REQUEST["recipe_num"];
else 
  $num="";
$subject=$_REQUEST["recipe_subject"];
$content=$_REQUEST["recipe_content"];
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
      $sql = "update joobee97.recipe0201 set recipe_subject=?, recipe_content=?, recipe_hashTag=? where recipe_num=?";
      $stmh = $pdo->prepare($sql); 
      $stmh->bindValue(1, $subject, PDO::PARAM_STR);  
      $stmh->bindValue(2, $content, PDO::PARAM_STR);
      $stmh->bindValue(3, $hash_tag, PDO::PARAM_STR);
      $stmh->bindValue(4, $num, PDO::PARAM_STR);   
      $stmh->execute();
      $pdo->commit(); 
      } catch (PDOException $Exception) {
          $pdo->rollBack();
          print "오류: ".$Exception->getMessage();
      }                         
      
} else	{
  try{
    $pdo->beginTransaction();
    $sql = "insert into joobee97.recipe0201(recipe_id, recipe_subject, recipe_content, recipe_date, recipe_hit, recipe_hashTag)";
    $sql .= "values(?, ?, ?, now(), 0, ?)";
    $stmh = $pdo->prepare($sql); 
    $stmh->bindValue(1, $_SESSION["userid"], PDO::PARAM_STR);
    $stmh->bindValue(2, $subject, PDO::PARAM_STR);  
    $stmh->bindValue(3, $content, PDO::PARAM_STR);
    $stmh->bindValue(4, $hash_tag, PDO::PARAM_STR);     
    $stmh->execute();
    $pdo->commit(); 
    } catch (PDOException $Exception) {
        $pdo->rollBack();
      print "오류: ".$Exception->getMessage();
    }   
  }
echo "<script>window.location.href='list.php?page=$page'</script>";
//header('Location: http://localhost:8090/recipe/list.php');
?>