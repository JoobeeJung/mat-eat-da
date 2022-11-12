<?php session_start(); ?>
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

$num=$_REQUEST["num"]; 
$ripple_content=$_REQUEST["boardRipple_content"];
$board_type=$_REQUEST["board_type"];
$type_num = $board_type."_num";

require_once("../lib/MYDB.php");
$pdo = db_connect();
  try{
  $pdo->beginTransaction();   
  $sql = "insert into joobee97.boardRipple0201(boardRipple_parent, boardRipple_id, boardRipple_type, boardRipple_content, boardRipple_date)";
  $sql.= "values(?, ?, ?, ?,now())"; 
  $stmh = $pdo->prepare($sql); 
  $stmh->bindValue(1, $num, PDO::PARAM_STR);
  $stmh->bindValue(2, $_SESSION["userid"], PDO::PARAM_STR); 
  $stmh->bindValue(3, $board_type, PDO::PARAM_STR); 
  $stmh->bindValue(4, $ripple_content, PDO::PARAM_STR);
  $stmh->execute();
  $pdo->commit(); 

  echo "<script>window.location.href='../$board_type/view.php?$type_num=$num'</script>";
  //header("Location:http://localhost:8090/mateatda_yykim/$board_type/view.php?num=$num");
  } catch (PDOException $Exception) {
        $pdo->rollBack();
      print "오류: ".$Exception->getMessage();
  }
?>