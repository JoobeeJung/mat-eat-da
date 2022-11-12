<?php
session_start();
$id=$_SESSION["userid"];
?>
<div id= "menus" class="menus"><a href="./foodShow/list.php"><img src="./img/foodShow1.png" border="0" style="width:156px; height:70px;"></a></div>
<div id= "menus" class="menus"><a href="./restaurant/list.php"><img src="./img/restaurant1.png" border="0" style="width:156px; height:70px;"></a></div>
<div id= "menus" class="menus"><a href="./recipe/list.php"><img src="./img/recipe1.png" border="0" style="width:156px; height:70px;"></a></div>

<?php
if($id){
?>
<div id= "menus" class="menus"><a href="./mypage/write.php"><img src="./img/write1.png" border="0" style="width:156px; height:70px;"></a></div>
<div id= "menus" class="menus"><a href="./mypage/like.php"><img src="./img/like1.png" border="0" style="width:156px; height:70px;"></a></div>
<div id= "menus" class="menus"><a href="./member/updateForm.php"><img src="./img/mypage1.png" border="0" style="width:156px; height:70px;"></a></div>
<?php
}
?>
<script>
$(function() { 
    $("#menus img").hover(function(){ 
        $(this).attr("src", $(this).attr("src").replace("1.png", "4.jpeg")); 
    }, function(){ 
        $(this).attr("src", $(this).attr("src").replace("4.jpeg", "1.png")); 
    }); 
});
</script>