<meta charset="UTF-8">
<title>맛Eat다</title>
<link rel="shortcut icon" type="image⁄x-icon" href="../img/M_logo.png">
<?php $id = $_REQUEST["nick"];
  if(!$id) 
  {
    print "닉네임을 입력하세요.<p>";
    }
  else
  {
    require_once("../lib/MYDB.php"); 
    $pdo = db_connect();

  try{
    $sql = "select * from joobee97.member0201 where nick = ? ";
    $stmh = $pdo->prepare($sql); 
    $stmh->bindValue(1,$id,PDO::PARAM_STR); 
    $stmh->execute(); 
    $count = $stmh->rowCount();              
  } catch (PDOException $Exception) {
    print "오류: ".$Exception->getMessage();
    }
      
      if($count<1){
          print "사용가능한 닉네임입니다.<p>";
      }else{
          print "닉네임이 중복됩니다.<br>다른 닉네임을 사용해 주세요.<p>";
      }
    }
      print "<center><input type=button value=창닫기 onClick='self.close()'></center>";

?>
