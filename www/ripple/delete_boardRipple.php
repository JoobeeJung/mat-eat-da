<?php
  $num=$_REQUEST["num"];
  $ripple_num=$_REQUEST["ripple_num"];
  $board_type=$_REQUEST["board_type"];
  $type_num = $board_type."_num";

  require_once("../lib/MYDB.php");
  $pdo = db_connect();
          
    try{
      $pdo->beginTransaction();
      $sql = "delete from joobee97.boardRipple0201 where boardRipple_num = ?"; 
      $stmh = $pdo->prepare($sql);
      $stmh->bindValue(1,$ripple_num,PDO::PARAM_STR);
      $stmh->execute();   
      $pdo->commit();
              
      echo "<script>window.location.href='../$board_type/view.php?$type_num=$num'</script>";
      //header("Location:http://localhost:8090/$board_type/view.php?num=$num");
      } catch (Exception $ex) {
              $pdo->rollBack();
              print "오류: ".$Exception->getMessage();
      }
?>
