<?php
  session_start();
  unset($_SESSION["userid"]);
  unset($_SESSION["name"]);
  unset($_SESSION["nick"]);
  unset($_SESSION["level"]);
  echo "<script>window.location.href='../index.php'</script>";
  //header("Location:http://localhost:8090/index.php");   
?>

