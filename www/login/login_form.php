<?php
  session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>?Eat?</title>
<link rel="shortcut icon" type="image?x-icon" href="../img/M_logo.png">
<link rel="stylesheet" type="text/css" href="../css/common.css">
<link rel="stylesheet" type="text/css" href="../css/member.css">
</head>

<body>
<div id="wrap">
<div id="header">
  <?php include "../lib/top_login2.php"; ?>
</div> <!-- end of header -->

<div id="menu">
  <?php include "../lib/top_menu2.php"; ?>
</div> <!-- end of menu -->

<div id="login_form">
  <form name="login_form" method="post" action="login_result.php"> 
  <img id="login_msg" src="../img/login_msg.png">
<div class="clear"></div>

<div id="login1">
  <img src="../img/id_card.png">
</div> <!-- end of login1 -->

<div id="login2">
<div id="id_input_button">
<div id="id_pw_title">
  <ul>
  <li><img src="../img/id_title.gif"></li>
  <li><img src="../img/pw_title.gif"></li>
  </ul>
</div> <!-- emd of id_pw_title-->

<div id="id_pw_input">
  <ul>
  <li><input type="text" font-size=16px; name="id" class="login_input" required></li>
  <li><input type="password" font-size=16px; name="pass" class="login_input" required></li>
  </ul>
</div> <!-- end of id_pw_input-->

<div id="login_button">
<input type="image" src="../img/login_button.png" 
  onclick="document.member_form.submit()">
</div> <!-- end of login button-->

</div> <!-- end of id_input_button-->

<div class="clear"></div> 
<div id="login_line">
<img src="../img/no_join.png">&nbsp;&nbsp; &nbsp;&nbsp;
</div>
<div id="join_button">
<a href="../member/insertForm.php"><img src="../img/join_button.gif"></a>
</div>

</div> <!-- end of login2 -->

</div> <!-- end of form_login -->

</form>
</div> <!-- end of col2 -->

</div> <!-- end of content -->

</div> <!-- end of wrap -->
<div id="footer_menu" style="margin-top:300px">
  <?php include "../lib/footer2.php"; ?>
</div>
</body>

</html>