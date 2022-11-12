<?php

session_start();
$id=$_SESSION["userid"];

$qryStr2 = $_POST["qryStr2"]; //[0] num [1] type [2] id
$board_type = $qryStr2[0];
$foodShow_button = "foodShow1.png";
$restaurant_button = "restaurant1.png";
$recipe_button = "recipe1.png";
$write_button = "write1.png";
$like_button = "like1.png";
$mypage_button = "mypage1.png";

if($board_type == "foodShow"){
    $foodShow_button = "foodShow2.png";
}else if($board_type == "restaurant"){
    $restaurant_button = "restaurant2.png";
}else if($board_type == "recipe"){
    $recipe_button = "recipe2.png";
}else if($board_type == "write"){
    $write_button = "write2.png";
}else if($board_type == "like"){
    $like_button = "like2.png";
}else if($board_type == "mypage"){
    $mypage_button = "mypage2.png";
}
?>

<link rel="stylesheet" type="text/css" href="../css/sideMenu.css">
<div id= "menus" class="menus"><a href="../foodShow/list.php"><img name="foodShow" src="../img/<?=$foodShow_button?>" border="0" style="width:156px; height:70px;"></a></div>
<div id= "menus" class="menus"><a href="../restaurant/list.php"><img name="restaurant" src="../img/<?=$restaurant_button?>" border="0" style="width:156px; height:70px;"></a></div>
<div id= "menus" class="menus"><a href="../recipe/list.php"><img name="recipe" src="../img/<?=$recipe_button?>" border="0" style="width:156px; height:70px;"></a></div>

<?php
if($id){
?>
<div id= "menus" class="menus"><a href="../mypage/write.php"><img name="recipe" src="../img/<?=$write_button?>" border="0" style="width:156px; height:70px;"></a></div>
<div id= "menus" class="menus"><a href="../mypage/like.php"><img name="recipe" src="../img/<?=$like_button?>" border="0" style="width:156px; height:70px;"></a></div>
<div id= "menus" class="menus"><a href="../member/updateForm.php"><img name="recipe" src="../img/<?=$mypage_button?>" border="0" style="width:156px; height:70px;"></a></div>
<?php
}
?>
<!--<div id="menus" class="menus" float="right"><span id="openmenu" class="openmenu" onclick="openNav()"><i class="fa fa-angle-double-left fa-5" aria-hidden="true"></i>ㅝ</span></div>-->
<script>
$(function() { 
    $("#menus img").hover(function(){ 
        $(this).attr("src", $(this).attr("src").replace("1.png", "4.jpeg"));
        //$(this).attr("src", $(this).attr("src").replace("2.png", "4.jpeg"));
        //$(this).attr("style", "width:250px; height:50px");
    }, function(){
        //if($(this).attr("name") == <?=$board_type?>){
        //    $(this).attr("src", $(this).attr("src").replace("4.jpeg", "2.png"));    
        //}else{
        $(this).attr("src", $(this).attr("src").replace("4.jpeg", "1.png"));
        //}
        //$(this).attr("style", "width:156px; height:50px");
    }); 
});
</script>
<script>
    function openNav() {
        $('#openmenu').removeAttr('onclick');
        $('#openmenu').attr('onclick', 'closeNav()');
        document.getElementById('mysidenav').style.width = '370px';
    }
    function closeNav() {
        $('#openmenu').removeAttr('onclick');
        $('#openmenu').attr('onclick', 'openNav()');
        document.getElementById('mysidenav').style.width = '0';
        
    }
</script>