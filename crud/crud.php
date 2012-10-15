<?php
include 'connect_db.php';
include 'open_db.php';


mysql_select_db("crud",$connect);
$email;
$theme;
if(isset($_POST["insert"])){
	if($_POST["insert"]=="yes"){
	$email=$_POST["email"];
	$theme=$_POST["theme"];

$query="insert into user(email, theme) values('$email', '$theme')";
if(mysql_query($query))
echo "<center>Record Inserted!</center><br>";
	}
}

if(isset($_POST["update"])){
	if($_POST["update"]=="yes"){
	$email=$_POST["email"];
	$theme=$_POST["theme"];

$query="update user set email='$email' , theme='$theme' where id=".$_POST['id'];
if(mysql_query($query))
echo "<center>Record Updated</center><br>";
	}
}

if(isset($_GET['operation'])){
if($_GET['operation']=="delete"){
$query="delete from user where id=".$_GET['id'];	
if(mysql_query($query))
echo "<center>Record Deleted!</center><br>";
}
}
?>
<html>
<head>
  <link href="../css/ReadSpike.css" rel="stylesheet" />
  <style type="text/css">
      body * {padding: 0.5em;}
      hr {border: 0; border-bottom: black; background: #000; height: 1px; padding: 0}
  </style>
</head>


<body>


<?php
$query="select * from user";
$result=mysql_query($query);


  
  while($row=mysql_fetch_array($result)){
    if($row['email'] == "felix@blackspike.com"){
      
      echo $row['theme'];
      
    }else if($row['email'] == "arse"){}
    
      echo $row['theme'];
	}

/*
  
if(mysql_num_rows($result)>0){
	echo "<table align='center' border='1'>";
	echo "<tr>";
	echo "<th>Id</th>";
	echo "<th>email</th>";
	echo "<th>theme</th>";
	echo "</tr>";
	while($row=mysql_fetch_array($result)){
	echo "<tr>";
	echo "<td>".$row['id']."</td>";	
	echo "<td>".$row['email']."</td>";	
	echo "<td>".$row['theme']."</td>";
	echo "<td><a href='crud.php?operation=edit&id=".$row['id']."&email=".$row['email']."&theme=".$row['theme']."'>edit</a></td>";
	echo "<td><a href='crud.php?operation=delete&id=".$row['id']."'>delete</a></td>";	
	echo "</tr>";
	}
	echo "</table>";
}
else{
echo "<center>No Records Found!</center>";	
}


*/
?>


<form method="post" action="crud.php">
<table align="center" border="0">
<tr>
<td>email:</td>
<td><input type="text" name="email" /></td>
</tr>
<tr>
<td>theme:</td>
<td><input type="theme" name="theme" /></td>
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







<form method="post" action="crud.php">
<table align="center" border="0">
<tr>
<td>find name:</td>
<td><input type="text" name="find_name" /></td>
</tr><tr>
<td>&nbsp;</td>
<td align="right">
<input type="submit" value="find name"/>
</td>
</tr>
</table>
</form>



<?php

if(isset($_GET['operation'])){
if($_GET['operation']=="edit"){
?>
<form method="post" action="crud.php">
<table align="center" border="0">
<tr>
<td>email:</td>
<td><input type="text" name="email" value="<?php echo $_GET['email']; ?>" /></td>
</tr>
<tr>
<td>theme:</td>
<td><input type="text" name="theme" value="<?php echo $_GET['theme']; ?>"/></td>
</tr>
<tr>
<td>&nbsp;</td>
<td align="right">
<input type="hidden" name="id" value="<?php echo $_GET['id'] ?>" />
<input type="hidden" name="update" value="yes" />
<input type="submit" value="update Record"/>
</td>
</tr>
</table>
</form>
<?php
}}
?>

<?php
$query="select * from user";
$result=mysql_query($query);
if(mysql_num_rows($result)>0){
	echo "<table align='center' border='1'>";
	echo "<tr>";
	echo "<th>Id</th>";
	echo "<th>email</th>";
	echo "<th>theme</th>";
	echo "</tr>";
	while($row=mysql_fetch_array($result)){
	echo "<tr>";
	echo "<td>".$row['id']."</td>";	
	echo "<td>".$row['email']."</td>";	
	echo "<td>".$row['theme']."</td>";
	echo "<td><a href='crud.php?operation=edit&id=".$row['id']."&email=".$row['email']."&theme=".$row['theme']."'>edit</a></td>";
	echo "<td><a href='crud.php?operation=delete&id=".$row['id']."'>delete</a></td>";	
	echo "</tr>";
	}
	echo "</table>";
}
else{
echo "<center>No Records Found!</center>";	
}

?>
</body>
</html>