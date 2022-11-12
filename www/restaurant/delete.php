<?php   
session_start();
?>
<meta charset="utf-8">
<?php
   $num=$_REQUEST["restaurant_num"];
   $id=$_SESSION["userid"];
   $board_type=$_REQUEST["board_type"];
   require_once("../lib/MYDB.php");
   $pdo = db_connect();

   try{
     $pdo->beginTransaction();
     $sql = "delete from joobee97.restaurant0201 where restaurant_num = ?";  
     $stmh = $pdo->prepare($sql);
     $stmh->bindValue(1,$num,PDO::PARAM_STR);      
     $stmh->execute();   
     $pdo->commit();

     try{
      $pdo->beginTransaction();
      $sql = "delete from joobee97.boardLike0201 where boardLike_num = ? and boardLike_type = ?";  
      $stmh = $pdo->prepare($sql);
      $stmh->bindValue(1,$num,PDO::PARAM_STR);
      $stmh->bindValue(2,$board_type,PDO::PARAM_STR);   
      $stmh->execute();   
      $pdo->commit();
                          
      } catch (Exception $ex) {
         $pdo->rollBack();
         print "오류: ".$Exception->getMessage();
    }
    try{
      $pdo->beginTransaction();
      $sql = "delete from joobee97.boardRipple0201 where boardRipple_parent = ? and boardRipple_type = ?";  
      $stmh = $pdo->prepare($sql);
      $stmh->bindValue(1,$num,PDO::PARAM_STR);
      $stmh->bindValue(2,$board_type,PDO::PARAM_STR);  
      $stmh->execute();   
      $pdo->commit();                        
      } catch (Exception $ex) {
         $pdo->rollBack();
         print "오류: ".$Exception->getMessage();
    }
     } catch (Exception $ex) {
        $pdo->rollBack();
        print "오류: ".$Exception->getMessage();
   }
echo "<script>window.location.href='list.php'</script>";
//header('Location: http://localhost:8090/restaurant/list.php');
?>