<?php
    $id     = $_REQUEST["id"];
    $pass   = $_REQUEST["pswd1"];
    $name   = $_REQUEST["name"];
    $nick   = $_REQUEST["nick"];
    $hp    = $_REQUEST["phoneNo"];
    
    require_once("../lib/MYDB.php");
    
    $pdo = db_connect();
    
    try{
        $pdo->beginTransaction();   
        $sql = "insert into joobee97.member0201 VALUES(?, ?, ?, ?, ?, 'null', now(),9)"; 
        $stmh = $pdo->prepare($sql); 
        $stmh->bindValue(1, $id, PDO::PARAM_STR);
        $stmh->bindValue(2, $pass, PDO::PARAM_STR);   
        $stmh->bindValue(3, $name, PDO::PARAM_STR);
        $stmh->bindValue(4, $nick, PDO::PARAM_STR);
        $stmh->bindValue(5, $hp, PDO::PARAM_STR);
        $stmh->execute();
        $pdo->commit(); 
        echo "<script>window.location.href='../index.php'</script>";
        //header("Location:http://localhost:8090/index.php");
    } catch (PDOException $Exception) {
    $pdo->rollBack();
    print "??: ".$Exception->getMessage();
    }
?>
