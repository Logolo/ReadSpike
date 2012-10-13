<?php
include 'connect_db.php';
include 'open_db.php';

// add new user

if(isset($_POST["insert"])){
  if($_POST["insert"]=="yes"){
    $email=$_POST["email"];
    $theme=$_POST["theme"];

    $sql="SELECT COUNT(id) FROM user where email='" . $email . "'";
    $result=mysql_query($sql);
    $query_data=mysql_fetch_row($result);
    if($query_data[0]>0) {
      //username already exists
      echo "username already exists";

    } else {
      //no problem

      $query="insert into user(email, theme) values('$email', '$theme')";
      if(mysql_query($query))
        setcookie("username", $email, time()+33600);
        setcookie("theme", $theme, time()+33600);
        echo "<center>Record Inserted!</center><br>";
    }

  }
}
?>
<!DOCTYPE html>
<html>
 <head>
  <meta charset="UTF-8">
  <title>title</title>

  <link href="../css/ReadSpike.css" rel="stylesheet" />
  <style type="text/css">

  </style>
 </head>

<?php
if (isset($_COOKIE["theme"])){
  echo "<body class='" . $_COOKIE["theme"] . "'>";
  }
else{
    
  if(isset($_POST["login"])){
  
    if($_POST["login"]=="yes"){
  
      $find_user_theme_value = $_POST["find_user_theme"];
  
      $find_user_theme_result = mysql_query("SELECT * FROM user WHERE email='".$find_user_theme_value."'");
  
      if($row = mysql_fetch_array($find_user_theme_result))
      { 
        if($row['theme'] == "dark" || $row['theme'] == "light"){
          echo "<body class='".$row['theme']."'>";
          
          setcookie("username", $row['email'], time()+33600);
          setcookie("theme", $row['theme'], time()+33600);
        
        }
      }else{echo "<body class='searched-not-found'>";}
  
    }
  
  }else{
  
    echo "<body class='not-searched'>";
  
  }
  
}
?>


<!--
/*
<?php

$x=1;

switch($x) {

case localstorage:
	set body from localstorage;
	echo "<body class='from-localstorage'>";
	break;

case cookies:
	set body from cookies;
	echo "<body class='from-cookies'>";
	break;

case login:
	set body from db, set cookies;
	echo "<body class='from-mysql'>";
	break;

case:
	create account, write to db, set cookies;
	echo "<body class='local-mysql'>";
	break;

default:
	echo "<body class='no-class'>";
}

?>
*/
-->

<!--  add records -->

<form method="post" action="login.php">
<table align="center" border="0">
<tr>
<td>email:</td>
<td><input type="text" name="email" /></td>
</tr>
<tr>
<td>theme:</td>
<td><input type="text" name="theme" /></td>
</tr>
<tr>
<td>&nbsp;</td>
<td align="right">
<input type="hidden" name="insert" value="yes" />
<input type="submit" value="Insert Record"/>
</td>
</tr>
</table>
</form>



<!--  search records -->

<form method="post" action="login.php">
<table align="center" border="0">
<tr>
<td>login:</td>
<td><input type="text" name="find_user_theme" /></td>
</tr>
<tr>
<td>&nbsp;</td>
<td align="right">
<input type="hidden" name="login" value="yes" />
<input type="submit" value="login"/>
</td>
</tr>
</table>
</form>







  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
 </body>
</html>
