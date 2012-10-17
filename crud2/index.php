<?php

ini_set('display_errors', 'On');
//error_reporting(E_ALL | E_STRICT);

include 'connect_db.php';
include 'open_db.php';


// set/read cookie monster

function cookieSetMonster ($cookieSetName, $cookieSetValue, $cookieSetTime) {
  if(!$cookieSetTime){$cookieSetTime = time()+33600;}
  setcookie($cookieSetName, $cookieSetValue, $cookieSetTime);
}

  
// is the theme set in cookies? if yes, add cookie theme as class to body
if (isset($_COOKIE["email"])){
  $bodyClass = $_COOKIE["theme"] . " from-cookies";
  $id        = $_COOKIE["id"];
  $pageTitle = $_COOKIE["email"] . " (from cookie)";
  $fontSize  = $_COOKIE["fontsize"];
}

$login = $_POST["login"];

// if user logging in, retrieve the theme from the just set mysql data
if($_POST[$login]=="yes"){

  // get theme pref
  $find_user_theme_value = $_POST["find_user_theme"];
  $find_user_theme_result = mysql_query("SELECT * FROM user WHERE email='".$find_user_theme_value."'");

  // add class from mysql to body
  if($row = mysql_fetch_array($find_user_theme_result))
  {
    if($row['theme'] == "dark" || $row['theme'] == "light"){
      $bodyClass = $row['theme']." (from mysql)";
      $pageTitle = "welcome ".$row['email']." (from mysql)";

    }
  }else{
    $bodyClass = "searched-not-found";
    $pageTitle = "user not found";

  }

}

// new

if (isset($_POST['submitted'])) { 
  foreach($_POST AS $key => $value) { $_POST[$key] = mysql_real_escape_string($value); } 
  $sql = "INSERT INTO `user` ( `email` ,  `theme` ,  `fontsize`  ) VALUES(  '{$_POST['email']}' ,  '{$_POST['theme']}' ,  '{$_POST['fontsize']}'  ) "; 
  //setcookie("email",$_POST['email']);
  //setcookie("theme",$_POST['theme']);
    setcookie("fontsize",$_POST['fontsize']);
  
  mysql_query($sql) or die(mysql_error()); 
  echo "Added row.<br />"; 
  echo "<a href='list.php'>Back To Listing</a>"; 
} 




?>
<!DOCTYPE html>
<html>
 <head>
  <meta charset="UTF-8">
  <title>CRUD2 - index.php</title>

  <link href="../css/ReadSpike.css" rel="stylesheet" />
  <style type="text/css">
      body * {padding: 0.5em;}
      hr {border: 0; border-bottom: black; background: #000; height: 1px; padding: 0}
  </style>
 </head>

<?php 
  

if ($bodyClass){
    echo "<body class='".$bodyClass."'\n"; // style='font-size:".$fontSize."px'>
    echo "<h1>".$pageTitle."</h1>";
    echo "<h2>ID: ".$id."</h2>";
    echo "<h3>Fontsize: ".$fontSize."</h3>";
    echo "<h4>Theme: ".$bodyClass."</h4>";
  } else {
    echo "<body>\n";
    echo "<h1>Welcome!</h1>\n";
}


?>

<ul>
<li><a href="edit.php">edit</a></li>
<li><a href="delete.php">delete</a></li>
<li><a href="list.php">list all</a></li>
<li><a href="new.php">new</a></li>
</ul>

<hr />


<!--  search records -->

<form method="post" action="index.php">
<table align="center" border="0">
<tr>
<td><label for="find_user_theme">login</label></td>
<td><input type="text" id="find_user_theme" name="find_user_theme" /></td>
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


<hr />

<!--  new record -->

<form action='index.php' method='POST'> 
<p><b>Email:</b><br /><input type='text' name='email'/> 
<p><b>Theme:</b><br /><input type='text' name='theme'/> 
<p><b>Fontsize:</b><br /><input type='text' name='fontsize'/> 
<p><input type='submit' value='Add Row' /><input type='hidden' value='1' name='submitted' /> 
</form> 


<hr />
<?php 
  include_once("list.php");
?>

<hr />
<?php 
  include_once("edit.php");
?>


</body>
</html>