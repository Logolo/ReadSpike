<?php
include 'connect_db.php';
include 'open_db.php';

// body class

$bodyClass = "";
$pageTitle = "Welcome! log in or create an account";

// set/read cookie monster

function cookieSetMonster ($cookieSetName, $cookieSetValue, $cookieSetTime) {
  if(!$cookieSetTime){$cookieSetTime = time()+33600;}
  setcookie($cookieSetName, $cookieSetValue, $cookieSetTime);
}

// is the theme set in cookies? if yes, add cookie theme as class to body
if (isset($_COOKIE["theme"])){
  $bodyClass = $_COOKIE["theme"] . " from-cookies";
  $pageTitle = $_COOKIE["username"] . " (from cookie)";
}


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

      // clear cookies
      cookieSetMonster("username",'',1);
      cookieSetMonster("theme",'',1);


    } else {
      // create user, set cookies

      $query="insert into user(email, theme) values('$email', '$theme')";
      if(mysql_query($query))

      cookieSetMonster("username",$email);
      cookieSetMonster("theme",$theme);

      $bodyClass = $theme. " from new user";
      $pageTitle = "welcome ".$email. " - Record Inserted!";
    }

  }
}


// if user logging in, retrieve the theme from the just set mysql data
if($_POST["login"]=="yes"){

  // get theme pref
  $find_user_theme_value = $_POST["find_user_theme"];
  $find_user_theme_result = mysql_query("SELECT * FROM user WHERE email='".$find_user_theme_value."'");

  // add class from mysql to body
  if($row = mysql_fetch_array($find_user_theme_result))
  {
    if($row['theme'] == "dark" || $row['theme'] == "light"){
      $bodyClass = $row['theme']." (from mysql)";
      $pageTitle = "welcome ".$row['email']." (from mysql)";

      // clear cookies
      cookieSetMonster("username",'',1);
      cookieSetMonster("theme",'',1);

      // set cookies
      cookieSetMonster("username",$row['email']);
      cookieSetMonster("theme",$row['theme']);

    }
  }else{
    $bodyClass = "searched-not-found";
    $pageTitle = "user not found";

    // clear cookies
    cookieSetMonster("username",'',1);
    cookieSetMonster("theme",'',1);

  }

}


?>
<!DOCTYPE html>
<html>
 <head>
  <meta charset="UTF-8">
  <title>CRUD - login.php</title>

  <link href="../css/ReadSpike.css" rel="stylesheet" />
  <style type="text/css">
      body * {padding: 0.5em;}
      hr {border: 0; border-bottom: black; background: #000; height: 1px; padding: 0}
  </style>
 </head>

<?php
if ($bodyClass){
  echo "<body class='".$bodyClass."'>\n";
}else {echo "<body>\n";}
echo "<h1>".$pageTitle."</h1>";

?>


<!--  add records -->

<form method="post" action="login.php">
<table align="center" border="0">
<tr>
<td><label for="email">username</label></td>
<td><input type="text" name="email" id="email" /></td>
</tr>
<tr>
<td>
<label for="light">light</label>
</td>
<td>
<input type="radio" name="theme" value="light" id="light" checked="true" />
</td>
</tr>
<tr>
<td>
<label for="dark">dark</label>
</td>
<td>
<input type="radio" name="theme" value="dark" id="dark" />
</td>
</tr>
<tr>
<td>&nbsp;</td>
<td align="right">
<input type="hidden" name="insert" value="yes" />
<input type="submit" value="create account"/>
</td>
</tr>
</table>
</form>

<hr />

<!--  search records -->

<form method="post" action="login.php">
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







  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
 </body>
</html>
