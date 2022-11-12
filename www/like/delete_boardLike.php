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
    $sql2 = "delete from joobee97.boardLike0201 where boardLike_id = '$id' and boardLike_num = $num and boardLike_type = '$board_type'";  
    $stmh2 = $pdo->query($sql2);
    $pdo->commit();
    echo "<script>window.location.href='../$board_type/view.php?$board_type_num=$num'</script>";
    //header("Location:http://localhost:8090/$board_type/view.php?num=$num");
    } catch (Exception $ex) {
      $pdo->rollBack();
      print "??: ".$Exception->getMessage();
    }
?>