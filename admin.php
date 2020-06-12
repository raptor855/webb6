<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style type="text/css">
  body{
	background-image:url("123.jpg");
}
table,th,td{
  border:2px solid black;
  margin:auto;
  border-collapse: collapse;
  background-color:#A9A9A9;
}
</style>
</head>
<body>
<?php
$loginadm=array();
$passadm=array();
$user = '';
$password = '';
$db = new PDO('mysql:host=localhost;dbname=', $user, $password, array(PDO::ATTR_PERSISTENT => true));
foreach($db->query("SELECT login,password FROM admin") as $row){
  array_push($loginadm,$row['login']);
  array_push($passadm,$row['password']);
}
$r=0;
$users=array();
foreach($loginadm as $w){
    $users[$w]=$passadm[$r];
}
if (empty($_SERVER['PHP_AUTH_USER']) ||
empty($_SERVER['PHP_AUTH_PW']) ||
md5($_SERVER['PHP_AUTH_USER']) != md5($loginadm[0]) ||
md5(md5($_SERVER['PHP_AUTH_PW'])) != md5($users[$loginadm[0]])) {
  header('HTTP/1.1 401 Unanthorized');
  header('WWW-Authenticate: Basic realm="My site"');
  print('<h1>401 Требуется авторизация</h1>');
  exit();
}
print("<form action='' method='POST' style='background-color:#A9A9A9;display: inline-block;'>
<p style='font-size:150%;'>Добро пожаловать,{$_SERVER['PHP_AUTH_USER']}.</p>
<select name='dead' size='1'>
<option value=''>...</option>");
foreach($db->query("SELECT login FROM info ") as $row){
  $text=$row['login'];
  print("<option value='$text'>$text</option>");
}
print("</select>
<input type='submit' value='Удалить пользователя'>
<a href='form.php'>На форму</a>
</form>");
if(!empty($_POST['dead'])){
  $die=$_POST['dead'];
  try {
    $stmt = $db->prepare("DELETE FROM info WHERE login='$die'");
    $stmt->execute();
}catch(PDOException $e){
  print('Error : ' . $e->getMessage());
  exit();
      }
      $die='';
      header('Location:admin.php');
  }
$database='';
$host='localhost';
$link = mysqli_connect($host, $user, $password, $database) 
    or die("Ошибка " . mysqli_error($link)); 
     
$query ="SELECT * FROM info";
$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
if($result)
{
    $rows = mysqli_num_rows($result); 
     
    echo "<table><tr><th>name</th><th>login</th><th>password(hash-code)</th><th>email</th><th>birth</th><th>sex</th><th>limbs</th><th>sverh</th><th>bio</th><th>consent</th></tr>";
    for ($i = 0 ; $i < $rows ; ++$i)
    {
        $row = mysqli_fetch_row($result);
        echo "<tr>";
            for ($j = 1 ; $j < 11 ; ++$j) echo "<td>$row[$j]</td>";
        echo "</tr>";
    }
    echo "</table>";
     
    
    mysqli_free_result($result);
}
 
mysqli_close($link);
?>
