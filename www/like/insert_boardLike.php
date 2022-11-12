<?php
session_start(); 
?>
  <meta charset="utf-8">
  <?php
     if(!isset($_SESSION["userid"])) {
  ?>
    <script>
         alert('로그인 후 이용해 주세요.');
	 history.back();
     </script>
  <?php
  }

  $id=$_SESSION["userid"];
  $num=$_REQUEST["num"]; 
  $board_type=$_REQUEST["board_type"];
  $board_type_num=$board_type."_num";
  
  require_once("../lib/MYDB.php");
  $pdo = db_connect();

  try{
    $pdo->beginTransaction(); 
    $sql1 = "insert into joobee97.boardLike0201(boardLike_id, boardLike_num, boardLike_type, boardLike_date) values(?, ?, ?, now())";
    $stmh1 = $pdo->prepare($sql1);
    $stmh1->bindValue(1, $id, PDO::PARAM_STR); 
    $stmh1->bindValue(2, $num, PDO::PARAM_STR); 
    $stmh1->bindValue(3, $board_type, PDO::PARAM_STR); 
    $stmh1 -> execute();
    $pdo->commit(); 

    echo "<script>window.location.href='../$board_type/view.php?$board_type_num=$num'</script>";
    //header("Location:http://localhost:8090/$board_type/view.php?num=$num");
    } catch (PDOException $Exception) {
      $pdo->rollBack();
    print "오류: ".$Exception->getMessage();
    } 
   ?>



