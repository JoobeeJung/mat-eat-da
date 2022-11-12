<?php
 $id     = $_REQUEST["id"];
 $pass   = $_REQUEST["pswd1"];
 $name   = $_REQUEST["name"];
 $nick   = $_REQUEST["nick"];
 $hp    = $_REQUEST["phoneNo"];
 $regist_day=date("Y-m-d H:i:s");    
 
 require_once("../lib/MYDB.php");  
 $pdo = db_connect(); 

 try{
   $pdo->beginTransaction();   
   $sql = " update joobee97.member0201 set pass=?, name=?, nick=?, hp=?, email='null', regist_day=? where id = ?"; 
   $stmh = $pdo->prepare($sql);  
   $stmh->bindValue(1, $pass, PDO::PARAM_STR);   
   $stmh->bindValue(2, $name, PDO::PARAM_STR);
   $stmh->bindValue(3, $nick, PDO::PARAM_STR);
   $stmh->bindValue(4, $hp, PDO::PARAM_STR);
   $stmh->bindValue(5, $regist_day, PDO::PARAM_STR);
   $stmh->bindValue(6, $id, PDO::PARAM_STR); 
   $stmh->execute();
   $pdo->commit();
  echo "<script>window.location.href='../index.php'</script>";
  //header("Location:http://localhost:8090/mateatda_yykim/index.php");
 } catch (PDOException $Exception) {
        $pdo->rollBack();
      print "오류: ".$Exception->getMessage();
 }
?>

