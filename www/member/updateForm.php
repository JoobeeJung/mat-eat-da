<?php
session_start();
$board_type = "mypage";
?>
<!DOCTYPE html>

<head>
<meta charset="UTF-8">
<title>맛Eat다</title>
<link rel="shortcut icon" type="image⁄x-icon" href="../img/M_logo.png">
<link rel="stylesheet" type="text/css" href="../css/common.css">
<link rel="stylesheet" type="text/css" href="../css/member_2.css">
<script>
function check_id()
{
  window.open("check_id.php?id="+document.member_form.id.value,"IDcheck", "left=200,top=200,width=200,height=60,scrollbars=no, resizable=yes");
}

function check_nick()
{
  window.open("check_nick.php?nick="+document.member_form.nick.value, "NICKcheck", "left=200,top=200,width=200,height=60, scrollbars=no, resizable=yes");
}
function check_input()
{
  if(!document.member_form.phoneNo.value)
  {
    alert("휴대폰 번호를 입력하세요"); 
    document.member_form.phoneNo.focus();
    return;
  }
  if(!document.member_form.id.value)
  {
    alert("아이디를 입력하세요"); 
    document.member_form.id.focus();
    return;
  }
  if(!document.member_form.name.value)
  {
    alert("이름을 입력하세요"); 
    document.member_form.name.focus();
    return;
  }
  if(!document.member_form.nick.value)
  {
    alert("닉네임을 입력하세요"); 
    document.member_form.nick.focus();
    return;
  }
  
  if(document.member_form.pswd1.value != document.member_form.pswd2.value)
  {
    alert("비밀번호가 일치하지 않습니다.\n다시 입력해주세요."); 
    document.member_form.pswd1.focus();
    document.member_form.pswd1.select();
    return;
  }

  document.member_form.submit();
}

function reset_form()
{
  document.member_form.id.value = "";
  document.member_form.pswd1.value = "";
  document.member_form.pswd2.value = "";
  document.member_form.name.value = "";
  document.member_form.nick.value = "";
  document.member_form.phoneNo.value = "";
  document.member_form.id.focus();
  return;
}
</script>
</head>
<?php
$id = $_SESSION["userid"];
require_once("../lib/MYDB.php"); 
$pdo = db_connect(); 
$sql = "select * from joobee97.member0201 where id='$id'";
try{
    $stmh = $pdo->query($sql);
    $row = $stmh->fetch(PDO::FETCH_ASSOC);
    $count = $stmh->rowCount();
    $name = $row["name"];
    $nick = $row["nick"];
    $hp = $row["hp"];
    $pass = $row["pass"];
?>

<body>
<div id="wrap">
    <div id="header">
    <?php include "../lib/top_login2.php"; ?>
    </div> <!-- end of header -->

    <div id="menu">

<?php
$qryStr2 = array($board_type);
$_POST["qryStr2"] = $qryStr2;
?>
    <?php include "../lib/top_menu2.php"; ?>
    </div> <!-- end of menu --> 

    <div id="container">
        <form name="member_form" method="post" action="updatePro.php?id=<?=$id?>"> 
            <div id="content">
            <!--회원정보수정 이미지 -->
            <div class="insert_member_image">
                <img src="../img/title_member_modify.png" width="200">
            </div>    
            <div class="join_content">
                <!--아이디, 비밀번호 입력-->
                <div class="row_group">
                    <div class="join_row">
                        <h3 class="join_title">
                            <img src="../img/id2.png">
                        </h3>

                        <!-- 아이디 -->
                        <span class="ps_box int_id"> 
                            <li style="font-size:20px;"> <?= print $row["id"]?></li>
                        </span>

                    </div>
                    <div class="join_row">
                        <h3 class="join_title">
                            <!-- 비밀번호 -->
                            <img src="../img/pw2.png">
                        </h3>
                        <span class="ps_box int_pass" id="pswd1Img">
                            <input type="password" id="pswd1" name="pswd1" class="int" title="비밀번호 입력" aria-describedby="paswd1Msg" maxlength="20" value="<?php print $pass; ?>">
                            <span class="lbl">
                                <span id="paswd1Span" class="step_txt"></span>
                            </span>
                        </span>
                        <span class="error_next_box" id="pswd1Msg" stylerole="alert">*필수 정보입니다.</span>
                        <h3 class="join_title">
                            <!-- 비밀번호 재확인 -->
                        <img src="../img/pw_check.png">
                        </h3>
                        <span class="ps_box int_pass_check" id="pswd2Img">
                            <input type="password" id="pswd2" name="pswd2" class="int" title="비밀번호 재확인 입력" aria-describedby="pswd2Blind" maxlength="20" value="<?php print $pass; ?>">
                        </span>
                        <span class="error_next_box" id="pswd2Msg" style="display:none" role="alert"></span>
                    </div>
                </div>
                <!-- //아이디, 비밀번호 입력-->
                <!-- 이름, 생년월일 입력 -->
                <div class="row_group">
                    <div class="join_row">
                        <!-- 이름 -->
                        <h3 class="join_title">
                        <img src="../img/name.png">
                        </h3>
                        <span class="ps_box box_right_space">
                            <input type="text" id="name" name="name" title="이름" class="int" maxlength="40" value="<?php print $name; ?>">
                        </span>
                        <span class="error_next_box" id="nameMsg" style role="alert">*필수 정보입니다.</span>
                    </div>
                    <div class="join_row">
                        <h3 class="join_title">
                            <!-- 닉네임 -->
                        <img src="../img/nickname.png">
                        </h3>
                        <span class="ps_box box_right_space">
                            <!-- 닉네임 중복체크 -->
                            <img src="../img/check_id.png" onclick="check_nick()" align="right" width="100">
                            <input type="text" id="nick" name="nick" title="닉네임" class="int" maxlength="40" value="<?php print $nick; ?>">
                        </span>
                        <span class="error_next_box" id="nameMsg" style role="alert">*필수 정보입니다.</span>
                    </div>
                    <!-- 휴대전화 번호 입력 -->
                    <div class="mobile">
                        <h3 class="join_title">
                            <!-- 휴대전화 -->
                            <img src="../img/hp.png">
                        </h3>
                        <span class="ps_box int_mobile">
                            <input type="tel" id="phoneNo" name="phoneNo" placeholder="전화번호 입력" aria-label="전화번호 입력" class="int" maxlength="20" value="<?php print $hp; ?>">
                            <label for="phoneNo" class="lbl"></label>
                        </span>
                        <span class="error_next_box" id="idMsg" style role="alert">*필수 정보입니다. <br> '-'없이 숫자만 입력해주세요.</span>
                    </div>                            
                </div>
<?php
} catch (PDOException $Exception) {
    print "오류: ".$Exception->getMessage();
}
?>
                <div id="button">
                    <img src="../img/button_save.png" onclick="check_input()" width="100">&nbsp;&nbsp;
                    <img src="../img/button_reset.png" onclick="reset_form()" width="100">
                </div>
            </div> <!-- end of join_content --> 
        </div> <!-- end of content -->
        </form>
    </div> <!-- end of container -->
</div>
<div id="footer_menu">
  <?php include "../lib/footer2.php"; ?>
</div>
</body>
</html>