<div id="top_login">
<?php
    if(!isset($_SESSION["userid"]))
	{
?>
          <a href="./login/login_form.php"><font color="white">로그인</font></a> | <a href="./member/insertForm.php"><font color="white">회원가입</font></a>
<?php
	}
	else
	{
?>
		<?=$_SESSION["nick"]?> | 
		<a href="./login/logout.php"><font color="white">로그아웃</font></a> | <a href="./member/updateForm.php?id=<?=$_SESSION["userid"]?>"><font color="white">정보수정</font></a>
<?php
	}
?>
	 </div>
    <div id="logo"><a href="./index.php"><img src="./img/M_logo.png" border="0"></a></div>
	
